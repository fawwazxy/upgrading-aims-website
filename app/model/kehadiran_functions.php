<?php
require '../../lib/db/connection.php';

$action = $_POST['action'];
if($action == "locationData"){
    $lokasi = $_POST['lokasi'];
    $cawangan_kod = $_POST['cawangan_kod'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $lkp_id = $_POST['lkp_id'];

    if($lkp_id > 0 ){
        $sql = "update lkp_location set cawangan_kod='$cawangan_kod', name='$lokasi',latitude='$latitude',
			longitude='$longitude' where id='$lkp_id' ";
        $result = db()->query($sql) or die(db()->error);
        echo "Data berjaya diproses";
    }else{
        $sql = "insert into lkp_location (cawangan_kod,name,latitude,longitude) 
			values('$cawangan_kod','$lokasi','$latitude','$longitude')";
        $result = db()->query($sql) or die(db()->error);

        echo "Data berjaya diproses";
    }

}else if ($action=="removeLocationData") {
    $lkp_id = $_POST['lkp_id'];
    $conn=db();

    $sql = "delete from lkp_location where id='$lkp_id' ";
    $result = $conn->query($sql) or die($conn->error);
    echo "Data berjaya dipadam";


}else if($action == "nyahaktifOutstation"){
    $id = $_POST['id'];
    $status = $_POST['status'];
    if ($status == '1') {
        $status = '0';
    }
    else {
        $status = '1';
    }

    $conn=db();
    $sql = "UPDATE staff_outstation set status='$status' WHERE id = '$id'";
    $result = $conn->query($sql);

}

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $conn=db();
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn,$str);
}

function getSys($sys_id) {
    $conn=db();
    $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getCompanyDetails($sys_id) {
    $conn=db();
    $sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
    return $conn->query($sql);
}

function login($username,$password) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
    return $conn->query($sql);
}

function getLogUser($com_id) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
    return $conn->query($sql);
}

function getLogStaff($dept_sub) {
    $conn=db();
    if ($dept_sub == 'HR-SEA'){
        $custom_condition = "AND s.department_id IN ('AGSHIMSB','MOCSB')";
    }
    $sql = "SELECT s.*,s.no_staff AS id_staff,k.*,m.device_masuk,m.device_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
		MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
		IFNULL(k.status_kehadiran,'BELUM LOG') AS status_kehadiran_flag,
		m.lokasi_masuk,m.lokasi_keluar,m.remark_masuk,m.remark_keluar AS remark_keluar 
		FROM staff s
		LEFT JOIN kehadiran k ON s.noic = k.nokp_staff 
		AND DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')
		LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
		WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 $custom_condition
		GROUP BY s.id
		ORDER BY masa_masuk DESC";
    return $conn->query($sql);
}

function getCutiStaff($no_staff){
    $conn=db();
    $sql=" SELECT sh.*, jc.desc AS nama_cuti,ha.approvement,ha.catatan, jk.jenis_lulus AS status_cuti , sr.no_staff
			FROM staff_holiday sh 
			LEFT JOIN holiday_approve ha ON ha.staff_holiday_id=sh.id
			LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
			LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
			LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
			WHERE sr.no_staff='$no_staff' AND ha.approvement = 'APPROVE' 
			AND DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y') 
			BETWEEN DATE_FORMAT(sh.tarikh_mula,'%d-%m-%Y') AND DATE_FORMAT(sh.tarikh_akhir,'%d-%m-%Y')";
    return $conn->query($sql);
}

function getHRSeaCompany($selected){
    $conn=db();
    $sql="SELECT code_department, description FROM department WHERE code_department IN ('AGSHIMSB','MOCSB')";
    $result = $conn->query($sql);

    $txt_result = "";
    while ($row = $result->fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getKehadiran($dateSelection,$cawangan_kod,$jabatan_kod) {
    $conn=db();
    $department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
    $role_id = $_SESSION['SESS_ROLE'];

    if (!in_array($department_sub, ['HR','HR-SEA']) && !in_array($role_id, ['FOUNDER', 'SUPERADMIN'])){
        echo ("<script type='text/javascript'>
                alert('You are not authorized to view this page');
                window.history.back();
                </script>");
        exit();
    }
    $where_cawangan_kod = $cawangan_kod != '0' ? "AND s.cawangan_kod='$cawangan_kod'" : "";
    $where_department_id = $jabatan_kod != '0' ? "AND s.department_id='$jabatan_kod'" : "";

    $sql = "SELECT s.name,k.id,k.nokp_staff,k.status_kehadiran,m.device_masuk,m.device_keluar,m.lokasi_masuk,m.lokasi_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
			IFNULL(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),'BELUM LOG') AS masa_keluar,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)) AS total,
			TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),s.jum_jam_kerja) AS beza,MAX(m.remark_keluar) AS remark_keluar,MIN(m.remark_masuk) AS remark_masuk  
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$dateSelection' 
			AND s.status='BEKERJA' $where_cawangan_kod $where_department_id
			GROUP BY k.nokp_staff
			ORDER BY MIN(m.masa_masuk)";

    return $conn->query($sql);
}

function getKehadiranByMonth($bln,$thn,$noic) {
    $conn=db();
    $sql = "SELECT s.*,k.*,DATE_FORMAT(k.created_date,'%d-%m-%Y') AS tarikh,
		        MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
		        MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
		        SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,
		        TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),s.jum_jam_kerja) AS beza,
		        m.lokasi_masuk,m.lokasi_keluar,
		        m.remark_masuk,m.remark_keluar
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
				WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND k.nokp_staff='$noic'
				GROUP BY k.created_date desc";
    return $conn->query($sql);
}
function getKehadiranByMonthStaff($bln,$thn,$noic) {
    $conn=db();
    $sql = "SELECT s.*,k.*,DATE_FORMAT(k.created_date,'%d-%m-%Y') AS tarikh,
		        MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
		        MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
		        SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,
		        TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),s.jum_jam_kerja) AS beza,
		        m.lokasi_masuk,m.lokasi_keluar,
		        m.remark_masuk,m.remark_keluar
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
				WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND k.nokp_staff='$noic'
				GROUP BY m.id";
    return $conn->query($sql);
}

function getKeseluruhanKehadiran($month,$year,$cawangan_kod,$jabatan_kod) {
    $conn=db();
    $where_cawangan_kod = $cawangan_kod!="0" ? "AND s.cawangan_kod='$cawangan_kod'" : "";
    $where_department_id = $jabatan_kod!="0" ? "AND s.department_id='$jabatan_kod'" : "";

    $sql = "SELECT s.name, s.noic, s.no_staff, k.* FROM kehadiran k 
                LEFT JOIN staff s on k.nokp_staff = s.noic
                WHERE MONTH(k.created_date) = '$month' AND YEAR(k.created_date) = '$year'
                 $where_cawangan_kod $where_department_id GROUP BY k.nokp_staff";
    return $conn->query($sql);
}

function workHourArray($ic_number, $month, $year){
    $conn = db();
    $work_hour_sum = $conn
        ->query("SELECT SUM(TIME_TO_SEC(total_time)) AS work_hour_sum FROM masa_kehadiran m
                LEFT JOIN kehadiran k ON k.id = m.id_kehadiran
                WHERE k.nokp_staff = '$ic_number' AND MONTH(k.created_date) = '$month' AND YEAR(k.created_date) = '$year'")
        ->fetch_object()->work_hour_sum; //in second

    $work_day_count = $conn
        ->query("SELECT COUNT(id) AS work_day_count FROM tarikh_bekerja
			                WHERE MONTH(tarikh)='$month' AND YEAR(tarikh)='$year'
			                AND STATUS='1' AND no_staff = '$ic_number'")
        ->fetch_object()->work_day_count; // in days

    $work_hour_indicator = $work_day_count * (8 * 60 * 60); //day * 8 hours  //in second
    $work_hour_difference = $work_hour_sum - $work_hour_indicator; //in seconds

    return [
        'sum' => secondToHoursMinutesSeconds($work_hour_sum),
        'difference' => secondToHoursMinutesSeconds($work_hour_difference),
    ];
}

function secondToHoursMinutesSeconds($seconds){
    $hours = floor($seconds / (60 * 60)); $seconds -= $hours*(60*60); // update seconds balance
    $minutes = floor($seconds / 60);
    $seconds = $seconds - ($minutes*60); // update seconds balance
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function personalAttendanceSummary($id,$month,$year) {
    $conn=db();
    $sql = "SELECT status_kehadiran, COUNT(id) AS total FROM kehadiran
				WHERE no_staff='$id' 
				AND MONTH(created_date)='$month' AND YEAR(created_date)='$year'
				GROUP BY status_kehadiran";
    $result = $conn->query($sql);

    $status_array = array();
    while ($row = $result->fetch_assoc()){
        $status_array[$row['status_kehadiran']] = $row['total'];
    }

    return $status_array;
}

function countHariBekerja($mnt,$thn){
    $conn=db();

    $sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_bekerja FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')='$mnt' AND DATE_FORMAT(created_date,'%Y')='$thn'";
    return $conn->query($sql);
}
//original attendance code
//edit 02092019 (tambah cawangan di table kehadiran)
//edit 20191002
function addkehadiranByLokasi($lokasi,$nokp,$cawangan){
    $conn=db();
    $sql1 ="SELECT * FROM lkp_location where id = '$lokasi' ";
    $lkp_lokasi=$conn->query($sql1)->fetch_object();
    $latlog = $lkp_lokasi->latitude.','.$lkp_lokasi->longitude;
    $remark = $lkp_lokasi->name;


    $masa=getMasaBekerja($nokp)->fetch_assoc();
    $masa_bekerja=$masa['masa_bekerja'];

    $sql6 ="SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
 		LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
  		WHERE DATE_FORMAT(mk.masa_masuk,'%d-%m-%Y') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')) AND k.nokp_staff='$nokp'";

    $id=$conn->query($sql6)->fetch_object()->id;

    $sql7= "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran  FROM masa_kehadiran
   		WHERE id='$id' AND masa_keluar IS NULL";

    $id_mk=$conn->query($sql7)->fetch_object()->id;

    if($id_mk > 0)//ada data
    {
        $id_kehadiran=$conn->query($sql7)->fetch_object()->id_kehadiran;
        $masa_masuk=$conn->query($sql7)->fetch_object()->masa_masuk;
        $tarikh_masuk = date('Y-m-d',strtotime($masa_masuk));
        $masa_mk = $tarikh_masuk." ".$masa_bekerja;
        $masa_keluar = date('Y-m-d H:i:s',strtotime('+9 hour',strtotime($masa_mk)));

        if($masa_masuk > $masa_keluar)
        {
            $sql8 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
		              lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
        }
        else
        {
            $sql8 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
		              lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
        }

        $conn->query($sql8);
        $sqlupdateKehadirankeluar="UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
        $conn->query($sqlupdateKehadirankeluar);
    }

    $sql9 ="SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			  	WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
			  	AND mk.masa_keluar IS NULL";

    $current_id=$conn->query($sql9)->fetch_object()->id;
    if($current_id > 0)//ada data
    {
        $sql9 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
		              lokasi_keluar='$latlog',remark_keluar='$remark',device_keluar='WEBSITE-MANUAL' where id='$current_id'";

        $conn->query($sql9);
    }

    $sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
		AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";

    $checkId=$conn->query($sql1)->fetch_object()->id;
    $sql4 = "SELECT noic,no_staff FROM staff WHERE noic='$nokp' AND status='BEKERJA'";

    $checknokp=$conn->query($sql4)->fetch_object()->noic;
    $no_staff=$conn->query($sql4)->fetch_object()->no_staff;
    if($checknokp==$nokp){
        if($checkId>0){
            $sql3 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk) 
				VALUES ('$checkId',CURRENT_TIMESTAMP,'$latlog','$remark','WEBSITE-MANUAL')";
            $result = $conn->query($sql3);
            $sqlupdateMasuk="UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
            $conn->query($sqlupdateMasuk);
        }else{
            $sql = "INSERT INTO kehadiran (status_kehadiran, lokasi,cawangan_kod,nokp_staff,no_staff,remark_lokasi,availability) 
				VALUES (
				(
						SELECT CASE 
						WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) = TIME_TO_SEC('$masa_bekerja') THEN 'TEPAT' 
						WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) > TIME_TO_SEC('$masa_bekerja') THEN 'LEWAT' ELSE 'AWAL' END
				)
				, '$latlog','$cawangan', '$nokp','$no_staff', '$remark','MASUK')";
            $result = $conn->query($sql) or die($conn->error);
            $newid=$conn->insert_id;
            $sql2 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk) 
				VALUES ('$newid',CURRENT_TIMESTAMP,'$latlog','$remark','WEBSITE-MANUAL')";
            $result = $conn->query($sql2) or die($conn->error);
        }
    }else{
        echo ("<script type='text/javascript'>
		window.alert('No Kad Pengenalan Tiada Dalam Rekod Staf!!!');
		window.location.href='../view/log_kehadiran.php';
		</script>");
    }
    return $result;
}

function updatekehadiranByLokasi($lokasi,$nokp){
    $conn=db();

    $sql1 ="SELECT * FROM lkp_location where id = '$lokasi' ";
    $lkp_lokasi=$conn->query($sql1)->fetch_object();
    $latlog = $lkp_lokasi->latitude.','.$lkp_lokasi->longitude;
    $remark = $lkp_lokasi->name;

    $sql1 ="SELECT IFNULL(max(k.id),0) AS id FROM kehadiran k LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran WHERE nokp_staff='$nokp'AND m.masa_keluar IS NULL ";

    $checkId=$conn->query($sql1)->fetch_object()->id;
    if($checkId>0){
        $sql3 = "SELECT id  FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
		AND id=( SELECT MAX(id) FROM masa_kehadiran WHERE id_kehadiran='$checkId')";
        $masa_res=$conn->query($sql3);
        if($masa_res->num_rows > 0){
            $masa_id=$masa_res->fetch_object()->id;
            if($masa_id > 0){
                $sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk), lokasi_keluar='$latlog', remark_keluar='$remark', device_keluar='WEBSITE-MANUAL' where id='$masa_id' ";
                $conn->query($sql4);
                $sqlupdateKehadirankeluar="UPDATE kehadiran SET availability='KELUAR' where id='$checkId'";
                $conn->query($sqlupdateKehadirankeluar);
            }
        }
    }
    return $checkId;
}
//end original
//end edit 02092019 (tambah cawangan di table kehadiran)

//adding webcam
//edit 20191002
function addkehadiran($nokp){
    $conn=db();
    $masa=getMasaBekerja($nokp)->fetch_assoc(); //pukul 9pg
    $masa_bekerja=$masa['masa_bekerja'];

    $sqlCawangan = "SELECT cawangan_kod FROM staff WHERE noic='$nokp' AND status='BEKERJA'";
    $cawangan_kod=$conn->query($sqlCawangan)->fetch_object()->cawangan_kod;


    $sql6 ="SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
 		LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
  		WHERE DATE_FORMAT(mk.masa_masuk,'%d-%m-%Y') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')) AND k.nokp_staff='$nokp'";

    $id=$conn->query($sql6)->fetch_object()->id;

    $sql7= "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
   		WHERE id='$id' AND masa_keluar IS NULL";

    $id_mk=$conn->query($sql7)->fetch_object()->id;

    if($id_mk > 0)//ada data
    {
        $id_kehadiran=$conn->query($sql7)->fetch_object()->id_kehadiran;
        $masa_masuk=$conn->query($sql7)->fetch_object()->masa_masuk;
        $tarikh_masuk = date('Y-m-d',strtotime($masa_masuk));
        $masa_mk = $tarikh_masuk." ".$masa_bekerja;
        $masa_keluar = date('Y-m-d H:i:s',strtotime('+9 hour',strtotime($masa_mk)));

        if($masa_masuk > $masa_keluar)
        {
            $sql8 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
		              lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
        }
        else
        {
            $sql8 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
		              lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
        }

        $conn->query($sql8);
        $sqlupdateKehadirankeluar="UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
        $conn->query($sqlupdateKehadirankeluar);

    }


    $sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
		AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";

    $sql5 = "SELECT name,latitude,longitude,concat(latitude,',',longitude) AS lokasi FROM lkp_location WHERE name='pejabat'";
    $checkname=$conn->query($sql5)->fetch_object()->name;
    $checklokasi=$conn->query($sql5)->fetch_object()->lokasi;
    $checklatitude=$conn->query($sql5)->fetch_object()->latitude;
    $checklongitude=$conn->query($sql5)->fetch_object()->longitude;


    $checkId=$conn->query($sql1)->fetch_object()->id;
    $sql4 = "SELECT noic,no_staff FROM staff WHERE noic='$nokp' AND status='BEKERJA'";
    $checknokp=$conn->query($sql4)->fetch_object()->noic;
    $no_staff=$conn->query($sql4)->fetch_object()->no_staff;


    $sql9 ="SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			  	WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
			  	AND mk.masa_keluar IS NULL";

    $current_id=$conn->query($sql9)->fetch_object()->id;
    if($current_id > 0)//ada data
    {
        $sql9 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
		              lokasi_keluar='$checklokasi',remark_keluar='$checkname',device_keluar='WEBSITE-KAD MATRIK' where id='$current_id'";

        $conn->query($sql9);
    }


    if($checknokp==$nokp){
        if($checkId>0){
            $sqlupdateMasuk="UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
            $conn->query($sqlupdateMasuk);
            $sql3 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk) 
				VALUES ('$checkId',CURRENT_TIMESTAMP,'$checklokasi','$checkname','WEBSITE-KAD MATRIK')";
            $conn->query($sql3);
        }else{
            $sql = "INSERT INTO kehadiran (status_kehadiran,cawangan_kod, lokasi,latitude,longitude,nokp_staff,no_staff,remark_lokasi,availability) 
				VALUES (
				(
						SELECT CASE 
						WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) = TIME_TO_SEC('$masa_bekerja') THEN 'TEPAT' 
						WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) > TIME_TO_SEC('$masa_bekerja') THEN 'LEWAT' ELSE 'AWAL' END
				)
				,'$cawangan_kod', '$checklokasi','$checklatitude','$checklongitude', '$nokp','$no_staff', '$checkname','MASUK')";
            $result = $conn->query($sql) or die($conn->error);
            $newid=$conn->insert_id;
            $sql2 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk) 
				VALUES ('$newid',CURRENT_TIMESTAMP,'$checklokasi','$checkname','WEBSITE-KAD MATRIK')";
            $conn->query($sql2);
        }
    }else{
        echo ("<script type='text/javascript'>
		window.alert('No Kad Pengenalan Tiada Dalam Rekod Staf');
		window.location.href='../view/log_kehadiran.php';
		</script>");
    }
    return $conn->insert_id;
    //return $result;
}
//edit 20191002
function updatekehadiran($nokp){
    $conn=db();

    // echo $sql1 ="SELECT IFNULL(MAX(k.id),0) AS id
    // FROM kehadiran k
    // LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran
    // LEFT JOIN lkp_location lkp ON k.lokasi=lkp.name
    // WHERE nokp_staff='$nokp' AND lkp.name='PEJABAT' AND m.masa_keluar IS NULL";

    //$sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";
    $sql1 ="SELECT IFNULL(max(k.id),0) AS id FROM kehadiran k LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran WHERE nokp_staff='$nokp'AND m.masa_keluar IS NULL ";

    $checkId=$conn->query($sql1)->fetch_object()->id;
    if($checkId>0){
        $sql3 = "SELECT id  FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
		AND id=( SELECT MAX(id) FROM masa_kehadiran WHERE id_kehadiran='$checkId')";
        $masa_res=$conn->query($sql3);

        $sql5 = "SELECT name,concat(latitude,',',longitude) AS lokasi FROM lkp_location WHERE name='pejabat'";
        $checkname=$conn->query($sql5)->fetch_object()->name;
        $checklokasi=$conn->query($sql5)->fetch_object()->lokasi;

        $masa_id = 0;
        if($masa_res->num_rows > 0){
            $masa_id=$masa_res->fetch_object()->id;
            if($masa_id > 0){


                $sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk), lokasi_keluar= '$checklokasi', remark_keluar='$checkname' , device_keluar='WEBSITE-KAD MATRIK' where id='$masa_id' ";
                $conn->query($sql4);
                $sqlupdateKehadirankeluar="UPDATE kehadiran SET availability='KELUAR' where id='$checkId'";
                $conn->query($sqlupdateKehadirankeluar);
            }
        }
    }
    return $masa_id;
}
function getMasaBekerja($nokp) {
    $conn=db();
    $sql = "SELECT * FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status='BEKERJA') ";
    return $conn->query($sql);
}
function addMasaBekerja($masa_bekerja){
    $conn=db();

    $sql = "INSERT INTO masa_bekerja (masa_bekerja) 
				VALUES ('$masa_bekerja')";
    return $conn->query($sql);
}
function updateMasaBekerja($id,$masa_bekerja){
    $conn=db();

    $sql = "UPDATE masa_bekerja SET masa_bekerja='$masa_bekerja' where id='$id'";
    return $conn->query($sql);
}
//edit
function getCuti(){
    $conn=db();
    $sql = "SELECT * FROM cuti WHERE DATE_FORMAT(tarikh_cuti,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y') ORDER BY tarikh_cuti";
    return $conn->query($sql);
}
function addCuti($perkara,$tarikh_cuti){
    $conn=db();
    $sql = "INSERT INTO cuti (perkara,tarikh_cuti)
				VALUES ('$perkara','$tarikh_cuti')";
    return $conn->query($sql);
}
function delCuti($id){
    $conn=db();
    $sql = "DELETE FROM cuti WHERE id='$id'";
    return $conn->query($sql);
}
function getCountCuti($mnt,$thn){
    $conn=db();
    $sql = "SELECT COUNT(tarikh_cuti) AS hari_cuti
				FROM cuti WHERE DATE_FORMAT(tarikh_cuti,'%m')='$mnt' AND DATE_FORMAT(tarikh_cuti,'%Y')='$thn'
				";
    return $conn->query($sql)->fetch_assoc();
}
//function workday lama
function workdayslama($mnt,$thn){
    $workdays = array();
    $type = CAL_GREGORIAN;
    $month = date('n'); // Month ID, 1 through to 12.
    $year = date('Y'); // Year in 4 digit 2009 format.
    $day_count = cal_days_in_month($type, $month, $year); // Get the amount of days
    $cuti=getCountCuti($mnt,$thn);

    //loop through all days
    for ($i = 1; $i <= $day_count; $i++) {

        $date = $year.'/'.$month.'/'.$i; //format date
        $get_name = date('l', strtotime($date)); //get week day
        $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

        //if not a weekend add day to array
        if($day_name != 'Fri'){
            $workdays[] = $i;
        }
    }
// length array
    $work=count($workdays);
    //workdays this month
    return $work-$cuti['hari_cuti'];
}
//function workday baru
function workdays($mnt,$thn,$no_staff){
    $conn=db();
    $sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
			WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND STATUS='1' AND no_staff='$no_staff'";
    return $conn->query($sql)->fetch_object()->workday;
}
function getPins($id){
    $conn=db();
    $sql = "SELECT m.lokasi_masuk,m.lokasi_keluar,m.masa_masuk,m.masa_keluar
				FROM kehadiran k 
				LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
				WHERE k.id='$id'
				";
    return $conn->query($sql);
}

function getPinsLocation(){
    $conn=db();
    $sql = "SELECT ll.name,ll.latitude,ll.longitude
				FROM lkp_location ll  
				WHERE ll.status=1 
				ORDER BY ll.latitude";
    return $conn->query($sql);
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function getLokasiData(){
    $conn=db();
    $sql = "SELECT * FROM lkp_location WHERE status=1";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function getLokasiDetails($id){
    $conn=db();
    $sql = "SELECT * FROM lkp_location WHERE id='$id'";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}



//wani
function getStaffName($noic){
    $conn=db();
    $sql = "SELECT s.*,c.nama AS cawangan,d.description AS jabatan FROM staff s
LEFT JOIN lkp_cawangan c ON c.cawangan_kod=s.cawangan_kod
LEFT JOIN department d ON d.code_department=s.department_id
		WHERE s.noic = '$noic'
		AND s.status = 'BEKERJA'";

    return $conn->query($sql);
}

function getCompany() {
    $conn=db();
    $sql = "SELECT * FROM company";
    return $conn->query($sql);
}
//edit 20200309
function getLaporanKehadiran($bln,$thn,$noic) {
    $conn=db();

    $sql = "SELECT s.*,k.*,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*(SELECT COUNT(id) AS workday FROM tarikh_bekerja
			WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$bln' AND STATUS='1' AND no_staff=s.no_staff))) AS beza, SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*(SELECT COUNT(id) AS workday FROM tarikh_bekerja
			WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$bln' AND STATUS='1' AND no_staff=s.no_staff)) AS sasaran
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND s.noic='$noic' AND s.status='BEKERJA'";
    return $conn->query($sql);
}
//edit 202010113
function getKeseluruhanLaporanKehadiran($bln,$thn,$noic) {
    $conn=db();
    $sql = "SELECT k.id,k.status_kehadiran,k.sebab_kelewatan,s.no_staff, s.noic,s.name,m.device_masuk,m.device_keluar, m.lokasi_masuk, m.lokasi_keluar, m.remark_keluar, m.masa_masuk, m.masa_keluar, m.remark_masuk,k.created_date, DATE_FORMAT(k.created_date,'%m') AS bulan,
				DATE_FORMAT(k.created_date,'%Y') AS tahun,m.photo_masuk,m.photo_keluar  
				FROM masa_kehadiran m
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND s.noic='$noic' AND s.status='BEKERJA'";
    return $conn->query($sql);
}
//edit 20200309
function getLaporanKehadiranMengikutHari($dateSelection, $noic){
    $conn=db();
    $sql = "SELECT s.*,k.*,m.remark_masuk, m.remark_keluar,m.lokasi_masuk,m.lokasi_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
			SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total_harian,TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),s.jum_jam_kerja) AS beza_harian, SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)) AS sasaran
		FROM kehadiran k
		LEFT JOIN staff s ON k.nokp_staff=s.noic
		LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
		WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$dateSelection' AND s.noic='$noic' AND s.status='BEKERJA'";

    //

    return $conn->query($sql);
}
//end edit 202020309
//EDIT 20201013
function getKehadiranMengikutHari($dateSelection, $noic){
    $conn=db();
    $sql = "SELECT k.id,k.status_kehadiran,k.sebab_kelewatan,s.no_staff,k.created_date, s.noic,s.name,m.device_masuk,m.device_keluar, m.lokasi_masuk, m.lokasi_keluar, m.remark_keluar, m.masa_masuk, m.masa_keluar, m.remark_masuk,k.created_date, 
			DATE_FORMAT(k.created_date,'%d-%m-%Y') AS DATE,m.photo_masuk,m.photo_keluar 
			FROM masa_kehadiran m
			LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$dateSelection' AND s.noic='$noic' AND s.status='BEKERJA'";

    return $conn->query($sql);
}
//end wani
//----------------------------------------------------------------------------bai 8 jabuary 2019
$action = ($_POST['action']);
if ($action == "waktu_bekerja_update"){
    $masa_bekerja = clean($_POST['masa_bekerja']);
    $shift_code = clean($_POST['shift_code']);
    $description = clean($_POST['description']);
    $id_masa_kehadiran = clean($_POST['id']);

    $result = editWaktuBekerja($masa_bekerja,$shift_code,$description,$id_masa_kehadiran);

}
function getAllWaktuBekerja(){
    $conn=db();
    $sql = "SELECT mb.id,mb.`masa_bekerja`,mb.`shift_code`,mb.`description`
		FROM `masa_bekerja` mb
		";
    return $conn->query($sql);
}

function addWaktuBekerja($masa_bekerja,$shift_code,$description){
    $conn=db();
    $sql = "INSERT INTO masa_bekerja (masa_bekerja,shift_code,description) 
				VALUES ('$masa_bekerja','$shift_code','$description')";
    return $conn->query($sql);
}
function getWaktuBekerja($id_masa_kehadiran){
    $conn=db();
    $sql = "SELECT * from `masa_bekerja` where id = '$id_masa_kehadiran'";
    return $conn->query($sql);
}
function editWaktuBekerja($masa_bekerja,$shift_code,$description,$id_masa_kehadiran){
    $conn=db();
    $sql = "UPDATE masa_bekerja SET masa_bekerja='$masa_bekerja',shift_code='$shift_code',description='$description'
		where id = '$id_masa_kehadiran'";
    return $conn->query($sql);
}
function deleteWaktuBekerja($id_masa_kehadiran){
    $conn=db();
    $sql = "DELETE FROM masa_bekerja WHERE id='$id_masa_kehadiran'";
    return $conn->query($sql);
}
function isShiftCodeExist($shift_code){
    $conn=db();
    $sql = "
		SELECT COUNT(shift_kerja) as counting FROM staff WHERE shift_kerja = '$shift_code' AND status='BEKERJA'";
    $result = $conn->query($sql)->fetch_object()->counting;
    if($result>0){
        return true;
    }
    return false;
}
//--------------------------------------------------------------------------------------------------------/bai 9/juanuary/2019
//start camera
function updateLogHadir($filename, $masa_kehadiran_id, $flag){
    $setcol = 'photo_keluar';
    if($flag == "panel_imbasan_masuk"){
        $setcol = 'photo_masuk';
    }
    $conn=db();
    $sql = "UPDATE masa_kehadiran set $setcol = '$filename' where id='$masa_kehadiran_id'";

    return $conn->query($sql);
}

function getNoStaff($masa_kehadiran_id){
    $conn=db();
    $sql = "select k.nokp_staff from kehadiran k, masa_kehadiran mk where k.id=mk.id_kehadiran and mk.id='$masa_kehadiran_id' limit 1";

    return $conn->query($sql)->fetch_object()->nokp_staff;
}
//end camera
function getDepartmentByStaff($dept_sub){

    if ($dept_sub == 'HR-SEA'){
        $custom_condition = "WHERE d.code_department IN ('AGSHIMSB','MOCSB')";
    }
    $conn=db();
    $sql = "select s.department_id,d.description from staff s
		inner join department d on s.department_id = d.code_department $custom_condition
		group by s.department_id";

    return $conn->query($sql);
}
//edit 20191002
function getLogStaffByDepartment($department_id) {
    $conn=db();

    $sql = "SELECT s.*,s.no_staff AS id_staff,k.*,m.device_masuk,m.device_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
		MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
		IFNULL(k.status_kehadiran,'BELUM LOG') AS status_kehadiran_flag,
		m.lokasi_masuk,m.lokasi_keluar,m.remark_masuk,m.remark_keluar as remark_keluar 
		FROM staff s
		left join kehadiran k on s.noic = k.nokp_staff 
		and DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')
		LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
		WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 
		AND s.department_id = '$department_id'
		group by s.id
		ORDER BY masa_masuk DESC";

    return $conn->query($sql);
}
//pemantauan kehadiran baru
function getBilStafDipantauKeseluruhan($dept_sub){
    if ($dept_sub == 'HR-SEA'){
        $custom_condition = "AND department_id IN ('AGSHIMSB','MOCSB')";
    }
    $conn=db();
    $sql = "SELECT COUNT(id) AS bil_staf_dipantau FROM staff
			WHERE noic IS NOT NULL AND STATUS='BEKERJA' AND pantau_kehadiran=1 $custom_condition";

    return $conn->query($sql)->fetch_object()->bil_staf_dipantau;
}
function getBilStafHadirByStatusKehadiran($status, $dept_sub){
    if ($dept_sub == 'HR-SEA'){
        $custom_condition = "AND s.department_id IN ('AGSHIMSB','MOCSB')";
    }
    $conn=db();
    /*$sql = "SELECT COUNT(id) AS bil FROM kehadiran WHERE DATE_FORMAT(created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') AND status_kehadiran='$status' $custom_condition";*/

    $sql = "SELECT COUNT(k.id) AS bil FROM kehadiran k 
            LEFT JOIN staff s ON s.noic = k.nokp_staff
            WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') AND k.status_kehadiran='$status' $custom_condition";

    return $conn->query($sql)->fetch_object()->bil;
}
function getBilStafDipantauKeseluruhanByDept($department_id){
    $conn=db();
    $sql = "SELECT COUNT(id) AS bil_staf_dipantau FROM staff WHERE noic IS NOT NULL AND status='BEKERJA' AND pantau_kehadiran=1 AND department_id = '$department_id'";

    return $conn->query($sql)->fetch_object()->bil_staf_dipantau;
}
function getBilStafHadirByStatusKehadiranByDept($status,$department_id){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
			WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 
			AND s.department_id = '$department_id' AND k.status_kehadiran='$status'";

    return $conn->query($sql)->fetch_object()->bil;
}
//end kehadiran pemantauan baru
//START ANALISA KEHADIRAN
function getBilKehadiranByStaff($status,$nokp){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil FROM kehadiran k
	LEFT JOIN staff s ON k.nokp_staff = s.noic
	AND YEAR(k.created_date)=YEAR(CURRENT_TIMESTAMP) AND MONTH(k.created_date)=MONTH(CURRENT_TIMESTAMP)
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 
	AND s.noic = '$nokp' AND k.status_kehadiran='$status'";

    return $conn->query($sql)->fetch_object()->bil;
}
function getBulanBekerjaStaf($nokp){
    $conn=db();
    $sql = "SELECT DATE_FORMAT(k.created_date,'%m') AS bulan FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			WHERE YEAR(k.created_date)=YEAR(CURRENT_TIMESTAMP) AND k.nokp_staff='$nokp' AND s.status='BEKERJA'
			GROUP BY DATE_FORMAT(k.created_date,'%m')";

    return $conn->query($sql);
}
function getTotalJamBekerjaStaf($bulan,$nokp){
    $conn=db();
    $sql = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),'%H') AS total
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%m')='$bulan' AND YEAR(k.created_date)=YEAR(CURRENT_TIMESTAMP) AND k.nokp_staff='$nokp'";

    return $conn->query($sql)->fetch_object()->total;
}
//nina
function getStaffOutstationList($status,$cawangan_kod,$jabatan_kod){
    $conn=db();

    if($cawangan_kod=="0" && $jabatan_kod=="0"){
        $cond="";
    }else if($cawangan_kod=="0" && $jabatan_kod!="0"){
        $cond="AND s.department_id='$jabatan_kod'";
    }else if($cawangan_kod!="0" && $jabatan_kod=="0"){
        $cond="AND s.cawangan_kod='$cawangan_kod'";
    }else{
        $cond="AND s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod'";
    }
    $sql = "SELECT so.* FROM staff_outstation so
				LEFT JOIN staff s ON s.noic=so.nokp_staff
				WHERE so.status='$status' AND s.status='BEKERJA' $cond";
    return $conn->query($sql);
}
function getStaffOutstationById($id){
    $conn=db();
    $sql = "SELECT * FROM staff_outstation WHERE id = '$id'";
    return $conn->query($sql);
}

function tambahOutstation($nokp_staff,$lokasi,$latitude,$longitude,$tarikh_mula,$tarikh_tamat){
    $conn=db();
    $sql = "INSERT INTO staff_outstation (nokp_staff,lokasi,latitude,longitude,tarikh_mula,tarikh_tamat) VALUES ('$nokp_staff','$lokasi','$latitude','$longitude','$tarikh_mula','$tarikh_tamat')";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function kemaskiniOutstation($id,$nokp_staff,$lokasi,$latitude,$longitude,$tarikh_mula,$tarikh_tamat){
    $conn=db();
    $sql = "UPDATE staff_outstation SET nokp_staff='$nokp_staff',lokasi='$lokasi',latitude='$latitude',longitude='$longitude',tarikh_mula='$tarikh_mula',tarikh_tamat='$tarikh_tamat' WHERE id='$id'";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
//end nina
//warning letter
function getStaffLewat($cawangan,$jabatan){
    $conn=db();
    if($cawangan=='' && $jabatan ==''){
        $sql = "SELECT s.name,s.no_staff,s.noic,s.phone,r.role,COUNT(k.id) AS lewat
				FROM staff s
				LEFT JOIN role r ON s.role_id = r.code
				LEFT JOIN kehadiran k ON s.no_staff = k.no_staff
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 AND k.status_kehadiran='LEWAT'
				GROUP BY s.id
				ORDER BY lewat DESC";
    }else if($cawangan!='' && $jabatan ==''){
        $sql = "SELECT s.name,s.no_staff,s.noic,s.phone,r.role,COUNT(k.id) AS lewat
				FROM staff s
				LEFT JOIN role r ON s.role_id = r.code
				LEFT JOIN kehadiran k ON s.no_staff = k.no_staff
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 AND k.status_kehadiran='LEWAT' AND s.cawangan_kod='$cawangan'
				GROUP BY s.id
				ORDER BY lewat DESC";
    }else{
        $sql = "SELECT s.name,s.no_staff,s.noic,s.phone,r.role,COUNT(k.id) AS lewat
				FROM staff s
				LEFT JOIN role r ON s.role_id = r.code
				LEFT JOIN kehadiran k ON s.no_staff = k.no_staff
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 AND k.status_kehadiran='LEWAT' AND s.cawangan_kod='$cawangan' AND s.department_id='$jabatan'
				GROUP BY s.id
				ORDER BY lewat DESC";
    }
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getTotalJamBekerjaStafSemasa($nokp){
    $conn=db();
    $sql = "SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
		LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
		WHERE DATE_FORMAT(mk.masa_masuk,'%d-%m-%Y') IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')) AND k.nokp_staff='$nokp'";

    $id=$conn->query($sql)->fetch_object()->id;
    $sql1 = "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran  FROM masa_kehadiran
		WHERE id='$id' AND masa_keluar IS NULL";

    $id_mk=$conn->query($sql1)->fetch_object()->id;
    if($id_mk>0){
        $sql2 = "SELECT TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk) AS belum_kira FROM masa_kehadiran
       WHERE id='$id_mk'";
        $result = $conn->query($sql2) or die($conn->error);

        return $result->fetch_object()->belum_kira;
    }else{
        return "0";
    }


}
function getStafInfo($nokp,$no_staff){
    $conn=db();
    $sql = "SELECT s.name,s.noic,s.phone,r.role,s.role_id,s.alamat_surat
				FROM staff s
				LEFT JOIN role r ON s.role_id = r.code
				WHERE s.noic='$nokp' AND s.status='BEKERJA' AND no_staff='$no_staff'";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

//get array of month
function getMonthArray(){
    return [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Mac',
        '04' => 'April', '05' => 'Mei', '06' => 'Jun',
        '07' => 'Julai', '08' => 'Ogos', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Disember',
    ];
}

//get month name from number
function getMonthStringArr($num){
    $month_string = [
        "01" => "Januari", "02" => "Februari",
        "03" => "Mac", "04" => "April",
        "05" => "Mei", "06" => "Jun",
        "07" => "Julai", "08" => "Ogos",
        "09" => "September", "10" => "Oktober",
        "11" => "November", "12" => "Disember",
    ];

    return $month_string[$num];
}

//edit 20200309
function getJumlahMasaBezaBekerja($nokp,$dateSelection,$jam_belum_kira){
    $conn=db();
    $sql = "SELECT SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(m.masa_keluar,MIN(m.masa_masuk)))-SUM(TIME_TO_SEC(total_time))) AS total_masa_keluar,
			(SELECT CASE 
			WHEN TIME_TO_SEC(TIMEDIFF(MAX(m.masa_keluar),MIN(m.masa_masuk)))-SUM(TIME_TO_SEC(total_time)) > TIME_TO_SEC(s.jum_jam_break) THEN SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) 
			ELSE SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-(TIME_TO_SEC(s.jum_jam_break)-(TIME_TO_SEC(TIMEDIFF(MAX(m.masa_keluar),MIN(m.masa_masuk)))-SUM(TIME_TO_SEC(total_time))))) END) AS total_masa_bekerja,
			(SELECT CASE 
			WHEN TIME_TO_SEC(TIMEDIFF(MAX(m.masa_keluar),MIN(m.masa_masuk)))-SUM(TIME_TO_SEC(total_time)) > TIME_TO_SEC(s.jum_jam_break) THEN TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),s.jum_jam_kerja) 
			ELSE TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-(TIME_TO_SEC(s.jum_jam_break)-(TIME_TO_SEC(TIMEDIFF(MAX(m.masa_keluar),MIN(m.masa_masuk)))-SUM(TIME_TO_SEC(total_time))))),s.jum_jam_kerja) END) AS total_beza,
			(SELECT CASE 
			WHEN TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,MIN(m.masa_masuk)))-(SUM(TIME_TO_SEC(total_time))+TIME_TO_SEC('$jam_belum_kira')) > TIME_TO_SEC(s.jum_jam_break) THEN SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))+TIME_TO_SEC('$jam_belum_kira')) 
			ELSE SEC_TO_TIME((SUM(TIME_TO_SEC(total_time))+TIME_TO_SEC('$jam_belum_kira'))-(TIME_TO_SEC(s.jum_jam_break)-(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,MIN(m.masa_masuk)))-(SUM(TIME_TO_SEC(total_time))+TIME_TO_SEC('$jam_belum_kira')))))  END) AS total_bekerja_semasa
			FROM kehadiran k
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$dateSelection'
			AND k.nokp_staff='$nokp' AND s.status='BEKERJA'";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getDropDownJabatan($selected) {
    $conn=db();
    $sql = "SELECT code_department,description FROM department WHERE status='1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}
function getMaklumatLewat($nokp,$no_staff){
    $conn=db();

    $masa=getMasaBekerja($nokp)->fetch_assoc();
    $masa_bekerja=$masa['masa_bekerja'];

    $sql = "SELECT DATE_FORMAT(k.created_date,'%d %b %Y') AS tarikh,DATE_FORMAT(MIN(m.masa_masuk),'%H:%i:%s') AS masa_masuk,TIMEDIFF(DATE_FORMAT(MIN(m.masa_masuk),'%H:%i:%s'),'$masa_bekerja') AS masa_lewat
			FROM kehadiran k
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran
			WHERE k.nokp_staff='$nokp' AND k.no_staff='$no_staff' AND k.status_kehadiran='LEWAT'
			GROUP BY m.id_kehadiran";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getKehadiranTerbaik($yearmonth) {
    $conn=db();

    $sql = "SELECT s.name,s.noic,COUNT(k.id) AS bil_hadir,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%AWAL%' THEN 1 END) AS awal,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%TEPAT%' THEN 1 END) AS tepat,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%LEWAT%' THEN 1 END) AS lewat,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%AWAL%' OR k.status_kehadiran LIKE '%TEPAT%' THEN 1 END) AS awal_lewat
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE DATE_FORMAT(k.created_date,'%Y-%m')='$yearmonth'
				AND s.status='BEKERJA' AND s.pantau_kehadiran='1'
				GROUP BY k.nokp_staff 
				ORDER BY bil_hadir DESC,awal_lewat DESC,lewat
				LIMIT 10";
    return $conn->query($sql);
}
function getDashboardKehadiranTerbaik($yearmonth) {
    $conn=db();

    $sql = "SELECT s.name,s.noic,COUNT(k.id) AS bil_hadir,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%AWAL%' THEN 1 END) AS awal,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%TEPAT%' THEN 1 END) AS tepat,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%LEWAT%' THEN 1 END) AS lewat,
				COUNT(CASE WHEN k.status_kehadiran LIKE '%AWAL%' OR k.status_kehadiran LIKE '%TEPAT%' THEN 1 END) AS awal_lewat
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE DATE_FORMAT(k.created_date,'%Y-%m')='$yearmonth'
				AND s.status='BEKERJA' AND s.pantau_kehadiran='1'
				GROUP BY k.nokp_staff 
				ORDER BY bil_hadir DESC,awal_lewat DESC,lewat
				LIMIT 3";
    return $conn->query($sql);
}

function getDropDownYearMonth($selected) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(created_date,'%Y-%m') AS val,DATE_FORMAT(created_date,'%M %Y') AS label
			FROM kehadiran
			WHERE DATE_FORMAT(created_date,'%Y')=YEAR(NOW())
			GROUP BY val";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}
function getWeekByDate($date){
    $conn=db();
    $sql = "SELECT DATE_FORMAT('$date','%V') AS minggu";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->minggu;
}
function getHari($year,$month,$week){
    $conn=db();
    $sql = "SELECT tarikh,DATE_FORMAT(tarikh,'%a') AS hari,DATE_FORMAT(tarikh,'%d-%m-%Y') AS tarikh_hari FROM tarikh_bekerja
				WHERE DATE_FORMAT(tarikh,'%Y')='$year' AND DATE_FORMAT(tarikh,'%m')='$month' AND DATE_FORMAT(tarikh,'%V')='$week'";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getDayString($day){
    switch($day)
    {
        case 'Sun':
            $hari="Ahad";
            break;
        case 'Mon':
            $hari="Isnin";
            break;
        case 'Tue':
            $hari="Selasa";
            break;
        case 'Wed':
            $hari="Rabu";
            break;
        case 'Thu':
            $hari="Khamis";
            break;
        case 'Fri':
            $hari="Jumaat";
            break;
        case 'Sat':
            $hari="Sabtu";
            break;
        default:
            $hari="Invalid day";
    }
    return $hari;
}

function getMinggu($tahun,$bulan) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%V') AS minggu FROM tarikh_bekerja
				WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND DATE_FORMAT(tarikh,'%m')='$bulan'
				GROUP BY DATE_FORMAT(tarikh,'%V')";
    return $conn->query($sql);
}
function getBulan() {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%b') AS bulan,DATE_FORMAT(tarikh,'%m') AS num_bulan
				FROM tarikh_bekerja
				GROUP BY bulan
				ORDER BY num_bulan";
    return $conn->query($sql);
}
function getTahun() {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%Y') AS tahun
				FROM tarikh_bekerja
				GROUP BY tahun
				ORDER BY tahun DESC";
    return $conn->query($sql);
}
function getTarikhCuti($tarikh) {
    $conn=db();
    $sql = "SELECT * FROM tarikh_bekerja WHERE tarikh='$tarikh' AND `status`='0'";
    $result = $conn->query($sql);
    return $result->num_rows;
}
function getBilTidakHadirByDate($tarikh) {
    $conn=db();
    $sql = "SELECT COUNT(s.id) AS bil_staf FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = '$tarikh')
				AND s.noic NOT IN (SELECT s.noic FROM staff s
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
				LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
				WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
				AND '$tarikh' BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)) AND s.status = 'BEKERJA' 
				AND s.pantau_kehadiran='1' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_staf;
}
function getWorkdaysByYear($thn){
    $conn=db();
    $sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
		WHERE YEAR(tarikh)='$thn' AND STATUS='1' AND tarikh<=CURRENT_DATE";
    return $conn->query($sql)->fetch_object()->workday;
}
function getWorkdayByMonth($mnt,$thn){
    $conn=db();
    $sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND STATUS='1' AND tarikh<=CURRENT_DATE";
    return $conn->query($sql)->fetch_object()->workday;
}
function getWorkdayByWeek($thn,$mnt,$week){
    $conn=db();
    $sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND DATE_FORMAT(tarikh,'%V')='$week' AND STATUS='1' AND tarikh<=CURRENT_DATE";
    return $conn->query($sql)->fetch_object()->workday;
}
function getBilTidakHadirByMonth($tahun,$bulan) {
    $conn=db();
    $bil_hari_bekerja=getWorkdayByMonth($bulan,$tahun);
    $sql = "SELECT COUNT(id) AS bil_staf FROM staff WHERE `status`='BEKERJA' AND pantau_kehadiran='1' AND role_id NOT IN('SUPERADMIN','ADMIN')";
    $bil_staf = $conn->query($sql)->fetch_object()->bil_staf;

    $sql1 = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun' AND MONTH(k.created_date)='$bulan'";
    $bil_staf_hadir = $conn->query($sql1)->fetch_object()->bil_hadir;

    $sql2 = "SELECT sum(sh.jumlah_cuti) AS bil_cuti FROM staff s
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
				LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
				WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1'
				AND YEAR(sh.tarikh_akhir)='$tahun' AND MONTH(sh.tarikh_akhir)='$bulan' AND sh.tarikh_akhir<=CURRENT_DATE";
    $bil_staf_cuti = $conn->query($sql2)->fetch_object()->bil_cuti;

    return $bil_hari_bekerja*$bil_staf-($bil_staf_hadir+$bil_staf_cuti);

}
function getBilTidakHadirByYear($tahun) {
    $conn=db();
    $bil_hari_bekerja=getWorkdaysByYear($tahun);
    $sql = "SELECT COUNT(id) AS bil_staf FROM staff WHERE `status`='BEKERJA' AND pantau_kehadiran='1' AND role_id NOT IN('SUPERADMIN','ADMIN')";
    $bil_staf = $conn->query($sql)->fetch_object()->bil_staf;

    $sql1 = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun'";
    $bil_staf_hadir = $conn->query($sql1)->fetch_object()->bil_hadir;

    $sql2 = "SELECT sum(sh.jumlah_cuti) AS bil_cuti FROM staff s
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
				LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
				WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1'
				AND YEAR(sh.tarikh_akhir)='$tahun' AND sh.tarikh_akhir<=CURRENT_DATE";
    $bil_staf_cuti = $conn->query($sql2)->fetch_object()->bil_cuti;

    return $bil_hari_bekerja*$bil_staf-($bil_staf_hadir+$bil_staf_cuti);

}
function getBilTidakHadirByWeek($tahun,$bulan,$minggu) {
    $conn=db();
    $bil_hari_bekerja=getWorkdayByWeek($tahun,$bulan,$minggu);
    $sql = "SELECT COUNT(id) AS bil_staf FROM staff WHERE `status`='BEKERJA' AND pantau_kehadiran='1' AND role_id NOT IN('SUPERADMIN','ADMIN')";
    $bil_staf = $conn->query($sql)->fetch_object()->bil_staf;

    $sql1 = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun' AND MONTH(k.created_date)='$bulan' AND DATE_FORMAT(k.created_date,'%V')='$minggu'";
    $bil_staf_hadir = $conn->query($sql1)->fetch_object()->bil_hadir;

    $sql2 = "SELECT sum(sh.jumlah_cuti) AS bil_cuti FROM staff s
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
				LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
				WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1'
				AND YEAR(sh.tarikh_akhir)='$tahun' AND MONTH(sh.tarikh_akhir)='$bulan' AND DATE_FORMAT(sh.tarikh_akhir,'%V')='$minggu' AND sh.tarikh_akhir<=CURRENT_DATE";
    $bil_staf_cuti = $conn->query($sql2)->fetch_object()->bil_cuti;

    return $bil_hari_bekerja*$bil_staf-($bil_staf_hadir+$bil_staf_cuti);

}
function getBilStafLewatByDate($date){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')='$date' AND k.status_kehadiran='LEWAT'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_lewat;
}
function getBilStafLewatByWeek($tahun,$bulan,$minggu){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun' AND MONTH(k.created_date)='$bulan' AND DATE_FORMAT(k.created_date,'%V')='$minggu' AND k.status_kehadiran='LEWAT'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_lewat;
}
function getBilStafLewatByMonth($tahun,$bulan){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun' AND MONTH(k.created_date)='$bulan' AND k.status_kehadiran='LEWAT'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_lewat;
}
function getBilStafLewatByYear($tahun){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON s.noic=k.nokp_staff
				WHERE s.status='BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('SUPERADMIN','ADMIN')
				AND YEAR(k.created_date)='$tahun' AND k.status_kehadiran='LEWAT'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_lewat;
}
function getMasaKehadiranTerbaik($yearmonth) {
    $conn=db();
    //$masa_bekerja=workdays($mnt,$thn);
    $sql = "SELECT s.name,s.noic,SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))) AS total,
					SUBSTRING_INDEX(SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))),':', 1) AS jam,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))), ':', 2), ':', -1) AS minit
					FROM kehadiran k
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
					WHERE DATE_FORMAT(k.created_date,'%Y-%m')='$yearmonth'
					AND s.status='BEKERJA' AND s.pantau_kehadiran='1'
					GROUP BY k.nokp_staff 
					ORDER BY total DESC
					LIMIT 10";
    return $conn->query($sql);
}
function getDashboardMasaKehadiranTerbaikk($yearmonth) {
    $conn=db();
    //$masa_bekerja=workdays($mnt,$thn);
    $sql = "SELECT s.name,s.noic,SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))) AS total,
					SUBSTRING_INDEX(SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))),':', 1) AS jam,
					SUBSTRING_INDEX(SUBSTRING_INDEX(SEC_TO_TIME(SUM(TIME_TO_SEC(m.total_time))), ':', 2), ':', -1) AS minit
					FROM kehadiran k
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
					WHERE DATE_FORMAT(k.created_date,'%Y-%m')='$yearmonth'
					AND s.status='BEKERJA' AND s.pantau_kehadiran='1'
					GROUP BY k.nokp_staff 
					ORDER BY total DESC
					LIMIT 3";
    return $conn->query($sql);
}
function getTugasanTerbaik($yearmonth) {
    $conn=db();

    $sql = "SELECT s.name,s.noic,COUNT(pt.id_task) AS bil_task FROM projek_task pt
					LEFT JOIN staff s ON s.noic=pt.assigned_to
					WHERE pt.id_category='DONE' AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m')='$yearmonth' AND s.status='BEKERJA'
					GROUP BY pt.assigned_to
					ORDER BY bil_task DESC
					LIMIT 10";
    return $conn->query($sql);
}
function getDashboardTugasanTerbaik($yearmonth) {
    $conn=db();

    $sql = "SELECT s.name,s.noic,COUNT(pt.id_task) AS bil_task FROM projek_task pt
					LEFT JOIN staff s ON s.noic=pt.assigned_to
					WHERE pt.id_category='DONE' AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m')='$yearmonth' AND s.status='BEKERJA'
					GROUP BY pt.assigned_to
					ORDER BY bil_task DESC
					LIMIT 3";
    return $conn->query($sql);
}
//start pemantauan based on lokasi
function getLokasiByStaff($dept_sub){

    if ($dept_sub == 'HR-SEA'){
        $custom_condition = "WHERE s.department_id IN ('AGSHIMSB','MOCSB')";
    }
    $conn=db();
    $sql = "SELECT s.cawangan_kod,c.nama FROM staff s
					INNER JOIN lkp_cawangan c ON s.cawangan_kod = c.cawangan_kod $custom_condition
					GROUP BY s.cawangan_kod";

    return $conn->query($sql);
}
function getBilStafDipantauKeseluruhanByLokasi($cawangan_kod){
    $conn=db();
    $sql = "SELECT COUNT(id) AS bil_staf_dipantau FROM staff WHERE noic IS NOT NULL AND status='BEKERJA' AND pantau_kehadiran=1 AND cawangan_kod = '$cawangan_kod'";

    return $conn->query($sql)->fetch_object()->bil_staf_dipantau;
}
function getBilStafHadirByStatusKehadiranByLokasi($status,$cawangan_kod){
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 
				AND s.cawangan_kod = '$cawangan_kod' AND k.status_kehadiran='$status'";

    return $conn->query($sql)->fetch_object()->bil;
}
function getLogStaffByLokasi($cawangan_kod) {
    $conn=db();

    $sql = "SELECT s.*,s.no_staff AS id_staff,k.*,m.device_masuk,m.device_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
		MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')) AS masa_keluar,
		IFNULL(k.status_kehadiran,'BELUM LOG') AS status_kehadiran_flag,
		m.lokasi_masuk,m.lokasi_keluar,m.remark_masuk,m.remark_keluar as remark_keluar 
		FROM staff s
		left join kehadiran k on s.noic = k.nokp_staff 
		and DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')
		LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
		WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.pantau_kehadiran=1 
		AND s.cawangan_kod = '$cawangan_kod'
		group by s.id
		ORDER BY masa_masuk DESC";

    return $conn->query($sql);
}
//end pemantauan by lokasi
// start card elektronik
/*function getTarikhBekerja($mnth,$yr,$no_staff){
      $conn=db();
      $sql = "SELECT *,DATE_FORMAT(tarikh,'%W') AS hari FROM tarikh_bekerja
            WHERE MONTH(tarikh)='$mnth' AND YEAR(tarikh)='$yr' AND no_staff='$no_staff'
            ORDER BY tarikh ASC";

        $result = $conn->query($sql);
        return $result;
    }*/
//edit 20201013

// start card elektronik
//edit 03/11/2020
function getTarikhBekerja($mnth,$yr,$no_staff){
    $conn=db();
    $sql = "SELECT t.*,mb.description,DATE_FORMAT(t.tarikh,'%W') AS hari,c.perkara FROM tarikh_bekerja t
          LEFT JOIN cuti c ON c.tarikh_cuti=t.tarikh 
		  LEFT JOIN masa_bekerja mb ON t.shift_kerja=mb.shift_code 
          WHERE MONTH(t.tarikh)='$mnth' AND YEAR(t.tarikh)='$yr' AND t.no_staff='$no_staff'
          ORDER BY t.tarikh";

    return $conn->query($sql);
}

function getKehadiranElektronik($dateSelection,$noic) {
    $conn=db();
    $sql = "SELECT s.*,k.*,m.device_masuk,m.device_keluar,m.lokasi_masuk,m.lokasi_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i')) AS masa_masuk,
			IFNULL(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i')),'') AS masa_keluar,DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),'%H:%i:%s') AS total,
			TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),s.jum_jam_kerja) AS beza,MAX(m.remark_keluar) AS remark_keluar,MIN(m.remark_masuk) AS remark_masuk 
			FROM kehadiran k
			LEFT JOIN staff s ON k.no_staff=s.no_staff
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
			AND k.no_staff='$noic' AND s.status='BEKERJA'";
    return $conn->query($sql);
}
function checkKehadiran($dateSelection,$noic) {
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
			AND k.no_staff='$noic' AND s.status='BEKERJA'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}
function seconds_from_time($time) {
    list($h, $m, $s) = explode(':', $time);
    return ((int)$h * 3600) + ((int)$m * 60) + (int)$s;
}
function time_from_seconds($seconds) {
    $h = floor($seconds / 3600);
    $m = floor(($seconds % 3600) / 60);
    $s = $seconds - ($h * 3600) - ($m * 60);
    return sprintf('%03d:%02d:%02d', $h, $m,$s);
}
function getJumlahMasaBekerja($noic,$mnt,$thn) {
    $conn=db();

    $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
				WHERE DATE_FORMAT(k.created_date,'%m')='$mnt' AND DATE_FORMAT(k.created_date,'%Y')='$thn' 
				AND s.status='BEKERJA' AND k.nokp_staff='$noic'";
    $result = $conn->query($sql);
    return $result->fetch_object()->total;
}
// new laporan kehadiran peribadi
function getKeseluruhanKehadiranPeribadi($ic_number,$year) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(k.created_date, '%m') AS month, s.name, s.noic, s.no_staff, k.* FROM kehadiran k 
                LEFT JOIN staff s on k.nokp_staff = s.noic
                WHERE YEAR(k.created_date) = '$year' AND k.nokp_staff='$ic_number'
				GROUP BY MONTH(k.created_date)";
    return $conn->query($sql);
}
function getLokasi() {
    $conn=db();

    $sql = "SELECT * FROM lkp_cawangan WHERE status='1'";
    return $conn->query($sql);
}
//get shift
function getShift($no_staff,$tarikh) {
    $conn=db();

    $sql = "SELECT m.* FROM tarikh_bekerja t
				LEFT JOIN masa_bekerja m ON m.shift_code=t.shift_kerja
				WHERE t.no_staff='$no_staff' AND t.tarikh=DATE_FORMAT('$tarikh','%Y-%m-%d')";

    $result = $conn->query($sql);
    return $result->fetch_object()->description;
}
function getElektronikCuti($staff_no,$tarikh) {
    $conn=db();

    $sql = "SELECT COUNT(sh.id) AS bil,sh.*,date(sh.tarikh_mula) AS mula,date(sh.tarikh_akhir) AS tamat FROM staff s
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
				LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
				WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA' AND s.no_staff='$staff_no'
				AND '$tarikh' BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)";
    return $conn->query($sql);
}
function getKehadiranByCawUnit($dateSelection,$cawangan_kod,$jabatan_kod,$department_sub) {
    $conn=db();
    $cond1='';
    $cond2='';
    $cond3='';
    if($cawangan_kod!="0"){
        $cond1="AND s.cawangan_kod='$cawangan_kod' ";
    }
    if($jabatan_kod!="0"){
        $cond2="AND s.department_id='$jabatan_kod'";
    }
    if($department_sub!="0"){
        $cond3="AND s.department_sub='$department_sub'";
    }

    $cond=$cond1.$cond2.$cond3;

    $sql = "SELECT s.name,k.id,k.nokp_staff,k.status_kehadiran,m.device_masuk,m.device_keluar,m.lokasi_masuk,m.lokasi_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s')) AS masa_masuk,
			IFNULL(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),'BELUM LOG') AS masa_keluar,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)) AS total,
			TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),s.jum_jam_kerja) AS beza,MAX(m.remark_keluar) AS remark_keluar,MIN(m.remark_masuk) AS remark_masuk  
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')='$dateSelection' 
			AND s.status='BEKERJA' $cond
			GROUP BY k.nokp_staff
			ORDER BY MIN(m.masa_masuk)";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getKeseluruhanKehadiranCawUnit($mnt,$thn,$cawangan_kod,$jabatan_kod,$department_sub) {
    $conn=db();
    $cond1='';
    $cond2='';
    $cond3='';
    if($cawangan_kod!="0"){
        $cond1="AND s.cawangan_kod='$cawangan_kod' ";
    }
    if($jabatan_kod!="0"){
        $cond2="AND s.department_id='$jabatan_kod'";
    }
    if($department_sub!="0"){
        $cond3="AND s.department_sub='$department_sub'";
    }

    $cond=$cond1.$cond2.$cond3;

    //$masa_bekerja=workdays($mnt,$thn);
    $sql = "SELECT s.*,k.*,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*(SELECT COUNT(id) AS workday FROM tarikh_bekerja
			WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND STATUS='1' AND no_staff=s.no_staff))) AS beza
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
				WHERE DATE_FORMAT(k.created_date,'%m')='$mnt' AND DATE_FORMAT(k.created_date,'%Y')='$thn' 
				AND s.status='BEKERJA' $cond
				GROUP BY k.nokp_staff";
    return $conn->query($sql);
}

$conn->close();