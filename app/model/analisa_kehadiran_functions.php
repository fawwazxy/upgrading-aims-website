<?php

require '../../lib/db/connection.php';
session_start();

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
	$result = $conn->query($sql);
	return $result;
}

function login($username,$password) {
	$conn=db();
	$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
	$result = $conn->query($sql);
	return $result;
}

function getDropDownStaff($condition,$department_id,$selected) {
	$conn=db();
	$sql = "SELECT noic, CONCAT(noic,' - ',name) FROM staff WHERE cawangan_kod='$condition' AND department_id='$department_id' AND role_id NOT IN ('ADMIN', 'SUPERADMIN') AND status = 'BEKERJA' AND pantau_kehadiran = '1' ORDER BY name";
	
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function workdays($mnt,$thn,$no_staff){
	$conn=db();
	$sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
			WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND STATUS='1' AND no_staff='$no_staff'";
	$result = $conn->query($sql)->fetch_object()->workday;
	return $result;
}

function getWorkDayMonth($now,$first){
	$conn=db();
	$sql = "SELECT tb.tarikh FROM tarikh_bekerja tb
			WHERE tb.status='1' AND tb.tarikh <= '$now' AND tb.tarikh >= '$first'";
	$result = $conn->query($sql);
	return $result;
}

//analisa kehadiran keseluruhan - start-
function getCawanganByKod($cawangan_kod) {
	$conn=db();
	$sql = "SELECT * FROM lkp_cawangan WHERE cawangan_kod='$cawangan_kod'";
	$result = $conn->query($sql);
	return $result;
}

function getBilStafHadir($cawangan_kod,$department_id) {
	$conn=db();
	if($cawangan_kod=='' && $department_id ==''){
		$sql = "SELECT COUNT(s.id) AS bil_staff, COUNT(k.id) AS bil_hadir FROM staff s
				LEFT JOIN kehadiran k ON s.noic = k.nokp_staff 
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.status = 'BEKERJA' 
				AND s.pantau_kehadiran = '1'  
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
	}else if($cawangan_kod!='' && $department_id ==''){
		$sql = "SELECT COUNT(s.id) AS bil_staff, COUNT(k.id) AS bil_hadir FROM staff s
				LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.status = 'BEKERJA' 
				AND s.pantau_kehadiran = '1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.cawangan_kod='$cawangan_kod'";
	}else{
		$sql = "SELECT COUNT(s.id) AS bil_staff, COUNT(k.id) AS bil_hadir FROM staff s
				LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.status = 'BEKERJA' 
				AND s.pantau_kehadiran = '1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.cawangan_kod='$cawangan_kod' 
				AND s.department_id='$department_id' ";
	}
	$result = $conn->query($sql);
	return $result;
}

function getBilKehadiranStatus($cawangan_kod,$department_id,$status_kehadiran) {
	$conn=db();
	if($cawangan_kod=='' && $department_id ==''){
		$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE k.status_kehadiran = '$status_kehadiran' 
				AND s.pantau_kehadiran = '1'
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	}else if($cawangan_kod!='' && $department_id ==''){
		$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE k.cawangan_kod = '$cawangan_kod' 
				AND k.status_kehadiran = '$status_kehadiran' 
				AND s.pantau_kehadiran = '1'
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	}else{
		$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE s.department_id = '$department_id' 
				AND s.cawangan_kod = '$cawangan_kod' 
				AND k.status_kehadiran = '$status_kehadiran' 
				AND s.pantau_kehadiran = '1'
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	}
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}

function analisaKehadiranSemuaCawangan() {
	$conn=db();
	$sql = "SELECT COUNT(s.id) AS bil_staff, lc.nama, COUNT(k.id) AS bil_kehadiran, lc.nama, lc.cawangan_kod 
				FROM lkp_cawangan lc
				LEFT JOIN staff s ON lc.cawangan_kod = s.cawangan_kod
				LEFT JOIN kehadiran k ON s.noic = k.nokp_staff 
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.status = 'BEKERJA' 
				AND s.pantau_kehadiran = '1' 
				AND s.role_id NOT IN ('ADMIN', 'SUPERADMIN')
				GROUP BY lc.id";
	$result = $conn->query($sql);
	return $result;
}

function analisaKehadiranCawangan($cawangan_kod,$status_kehadiran) {
	$conn=db();
	$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE k.status_kehadiran = '$status_kehadiran' 
			AND k.cawangan_kod = '$cawangan_kod'
			AND s.pantau_kehadiran = '1'
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}

function analisaKehadiranJabatanByKod($cawangan_kod) {
	$conn=db();
	$sql = "SELECT d.description, d.code_department, COUNT(k.id) AS bil_hadir, COUNT(s.id) AS bil_staff, s.noic, s.cawangan_kod,s.no_staff FROM department d
			LEFT JOIN staff s ON d.code_department = s.department_id
			LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
			AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
			WHERE s.pantau_kehadiran = '1' 
			AND s.status = 'BEKERJA'
			AND s.cawangan_kod = '$cawangan_kod' 
			AND s.role_id NOT IN ('ADMIN', 'SUPERADMIN') 
			GROUP BY d.code_department";
	$result = $conn->query($sql);
	return $result;
}

function analisaKehadiranCawanganJabatan($cawangan_kod,$department_id) {
	$conn=db();
	$sql = "SELECT s.name,s.no_staff,COUNT(k.id) AS bil_kehadiran, lc.cawangan_kod,s.noic, d.description FROM staff s
			LEFT JOIN lkp_cawangan lc ON s.cawangan_kod = lc.cawangan_kod
			LEFT JOIN department d ON s.department_id = d.code_department
			LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
			WHERE s.pantau_kehadiran = '1' 
			AND s.status = 'BEKERJA'
			AND s.department_id = '$department_id' 
			AND lc.cawangan_kod = '$cawangan_kod' 
			AND s.role_id NOT IN ('ADMIN', 'SUPERADMIN') 
			GROUP BY s.noic ORDER BY s.name";
	$result = $conn->query($sql);
	return $result;
}

function analisaKehadiranStaffCawangan($cawangan_kod,$department_id,$status_kehadiran) {
	$conn=db();
	$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k	
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE s.department_id = '$department_id' 
			AND s.cawangan_kod = '$cawangan_kod' 
			AND k.status_kehadiran = '$status_kehadiran'
			AND s.pantau_kehadiran = '1'
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}

function analisaKehadiranStaffJabatan($cawangan_kod,$department_id,$noic,$status_kehadiran) {
	$conn=db();
	$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k	
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE s.department_id = '$department_id' 
			AND s.cawangan_kod = '$cawangan_kod' 
			AND s.noic = '$noic' 
			AND k.status_kehadiran = '$status_kehadiran'
			AND s.pantau_kehadiran = '1'
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}
//analisa kehadiran keseluruhan -end-

//analisa kehadiran kakitangan tidak hadir -start-
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

function getBilStaf($cawangan,$jabatan) {
	$conn=db();
	if($cawangan=='' && $jabatan ==''){
		$sql = "SELECT count(id) AS bil_staf FROM staff WHERE pantau_kehadiran='1' AND status='BEKERJA' AND noic IS NOT NULL AND role_id NOT IN('ADMIN','SUPERADMIN')";
	}else if($cawangan!='' && $jabatan ==''){
		$sql = "SELECT COUNT(id) AS bil_staf FROM staff WHERE pantau_kehadiran='1' AND cawangan_kod='$cawangan' AND status='BEKERJA' AND noic IS NOT NULL AND role_id NOT IN('ADMIN','SUPERADMIN')";
	}else{
		$sql = "SELECT COUNT(id) AS bil_staf FROM staff WHERE pantau_kehadiran='1' AND cawangan_kod='$cawangan' AND status='BEKERJA' AND department_id='$jabatan' AND noic IS NOT NULL AND role_id NOT IN('ADMIN','SUPERADMIN')";
	}
	$result = $conn->query($sql);
	return $result->fetch_object()->bil_staf;
}

function getBilStafTidakHadir($cawangan,$jabatan) {
	$conn=db();
	if($cawangan=='' && $jabatan ==''){
		$sql = "SELECT count(s.id) AS bil_staf FROM staff s 
			    LEFT JOIN role r ON r.`code` = s.role_id
			    WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
			    AND s.noic NOT IN (SELECT s.noic FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}else if($cawangan!='' && $jabatan ==''){
		$sql = "SELECT count(s.id) AS bil_staf FROM staff s 
			    LEFT JOIN role r ON r.`code` = s.role_id
			    WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
			    AND s.noic NOT IN (SELECT s.noic FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}else{
		$sql = "SELECT count(s.id) AS bil_staf FROM staff s 
			    LEFT JOIN role r ON r.`code` = s.role_id
			    WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
			    AND s.noic NOT IN (SELECT s.noic FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.department_id='$jabatan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}
	$result = $conn->query($sql);
	return $result->fetch_object()->bil_staf;
}
//edit 16102019
function getSenaraiStafTidakHadir($cawangan,$jabatan) {
	$conn=db();
	if($cawangan=='' && $jabatan ==''){
		$sql = "SELECT s.name,r.role,s.phone,s.no_staff FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.role_id NOT IN('ADMIN','SUPERADMIN')
				ORDER BY s.name ASC";
	}else if($cawangan!='' && $jabatan ==''){
		$sql = "SELECT s.name,r.role,s.phone,s.no_staff FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')
				ORDER BY s.name ASC";
	}else{
		$sql = "SELECT s.name,r.role,s.phone,s.no_staff FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE) AND  s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.department_id='$jabatan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')
				ORDER BY s.name ASC";
	}
	$result = $conn->query($sql);
	return $result;	
}
//analisa kehadiran kakitangan tidak hadir -end-

//analisa kehadiran peribadi -start-
function getAnalisaJumlahHariBekerja($nokp,$no_staff ) {
	$conn = db();
	$sql = "SELECT COUNT(*) AS jumlah_hari_bekerja FROM tarikh_bekerja tb 
			WHERE tb.status = '1' 
			AND tb.sys_id = (SELECT c.sys_id FROM company c LEFT JOIN staff s ON c.id = s.company_id WHERE s.noic = '$nokp' AND s.status = 'BEKERJA')
			AND DATE_FORMAT(tb.tarikh,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m') AND tb.no_staff='$no_staff'";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_hari_bekerja;
}

function getAnalisaJumlahKehadiran($nokp_staff) {
	$conn = db();
	$sql = "SELECT COUNT(*) AS jumlah_kehadiran FROM kehadiran k
	        LEFT JOIN staff s ON k.nokp_staff = s.noic 
			WHERE k.nokp_staff = '$nokp_staff' AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_kehadiran;
}

function getAnalisaKehadiranAwal($nokp) {
	$conn = db();
	$sql = "SELECT COUNT(*) AS kehadiran_awal FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic 
			WHERE s.noic IS NOT NULL 
			AND s.status = 'BEKERJA' 
			AND k.nokp_staff = '$nokp' 
			AND k.status_kehadiran = 'AWAL'
			AND DATE_FORMAT(k.created_date,'%Y-%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->kehadiran_awal;
}

function getAnalisaKehadiranTepat($nokp) {
	$conn = db();
	$sql = "SELECT COUNT(*) AS kehadiran_tepat FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic 
			WHERE s.noic IS NOT NULL 
			AND s.status = 'BEKERJA'
			AND k.nokp_staff = '$nokp' 
			AND k.status_kehadiran = 'TEPAT'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->kehadiran_tepat;
}

function getAnalisaKehadiranLewat($nokp) {
	$conn = db();
	$sql = "SELECT COUNT(*) AS kehadiran_lewat FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic 
			WHERE s.noic IS NOT NULL 
			AND s.status = 'BEKERJA'
			AND k.nokp_staff = '$nokp' 
			AND k.status_kehadiran = 'LEWAT'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->kehadiran_lewat;
}

function getAnalisaKehadiranAllDetails($nokp_staff) {
	$conn = db();
	$sql = "SELECT k.id AS idd,k.catatan,k.status_kehadiran,k.lokasi,k.cawangan_kod,k.latitude,k.longitude,k.nokp_staff,k.no_staff,k.created_date,k.remark_lokasi,k.availability,k.sebab_kelewatan,mk.*,s.*,DATE_FORMAT(mk.masa_masuk,'%W') AS hari_masuk,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS bil_jam_bekerja FROM kehadiran k
			LEFT JOIN masa_kehadiran mk ON k.id = mk.id_kehadiran
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE k.nokp_staff = '$nokp_staff'
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
			GROUP BY k.created_date ORDER BY k.created_date DESC";
	$result = $conn->query($sql) or die($conn->error);
	return $result;
}

function masukSebabKelewatanById($id) {
	$conn = db();
	$sql = "SELECT * FROM kehadiran
			WHERE id = '$id'";
	$result = $conn->query($sql) or die($conn->error);
	return $result;
}

function masukSebabKelewatan($id,$nokp_staff,$sebab_kelewatan){
		$conn=db();
		$sql = "UPDATE kehadiran SET sebab_kelewatan='$sebab_kelewatan' WHERE id = '$id' AND nokp_staff = '$nokp_staff'";
		$result = $conn->query($sql);
		return $result;
	}


function getAnalisaKehadiranDetails($nokp_staff,$status_kehadiran) {
	$conn = db();
	$sql = "SELECT k.*,mk.*,s.*,DATE_FORMAT(mk.masa_masuk,'%W') AS hari_masuk,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS bil_jam_bekerja FROM kehadiran k
			LEFT JOIN masa_kehadiran mk ON k.id = mk.id_kehadiran
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE k.nokp_staff = '$nokp_staff' 
			AND k.status_kehadiran = '$status_kehadiran' 
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
			GROUP BY k.created_date ORDER BY k.created_date DESC";
	$result = $conn->query($sql) or die($conn->error);
	return $result;
}

function getStaffDetailsByNokp($nokp_staff) {
	$conn = db();
	$sql = "SELECT k.*,s.*,r.*,d.*,lkpc.* FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			LEFT JOIN role r ON s.role_id = r.code
			LEFT JOIN department d ON s.department_id = d.code_department
			LEFT JOIN lkp_cawangan lkpc ON s.cawangan_kod = lkpc.cawangan_kod
			WHERE k.nokp_staff = '$nokp_staff'
			AND s.status = 'BEKERJA'";
	$result = $conn->query($sql) or die($conn->error);
	return $result;
}

function getLokasiKehadiran($latlng){
   $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=false&key=AIzaSyCyciSZxMmYCFy4GsJsEh0nKZezKwHvw_I";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geocode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response);
    $dataarray = get_object_vars($output);
    if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
        if (isset($dataarray['results'][0]->formatted_address)) {

            $address = $dataarray['results'][0]->formatted_address;

        } else {
            $address = 'Not Found';

        }
    } else {
        $address = 'Not Found';
    }
  return $address;
 }
//analisa kehadiran peribadi -end-
//16102019
function getCountCuti($cawangan,$jabatan) {
	$conn=db();
	if($cawangan=='' && $jabatan ==''){
		$sql = "SELECT count(s.noic) as bil FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)
			    AND s.pantau_kehadiran='1' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}else if($cawangan!='' && $jabatan ==''){
		$sql = "SELECT count(s.noic) as bil FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)
			    AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}else{
		$sql = "SELECT count(s.noic) as bil FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)
			    AND s.pantau_kehadiran='1' AND s.cawangan_kod='$cawangan' AND s.department_id='$jabatan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	}
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
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

	    $result=$conn->query($sql);
	  
	    return $result;  

	}
	//START ANALISA KEHADIRAN BASED ON JABATAN
function getDropDownStaffByDepartment($department_id,$selected) {
	$conn=db();
	$sql = "SELECT noic, CONCAT(noic,' - ',name) FROM staff WHERE department_id='$department_id' AND role_id NOT IN ('ADMIN', 'SUPERADMIN') AND status = 'BEKERJA' AND pantau_kehadiran = '1' ORDER BY name";
	
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function getBilStafHadirByDepartment($department_id) {
	$conn=db();
	
		$sql = "SELECT COUNT(s.id) AS bil_staff, COUNT(k.id) AS bil_hadir FROM staff s
				LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				WHERE s.status = 'BEKERJA' 
				AND s.pantau_kehadiran = '1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND s.department_id='$department_id' ";
	
	$result = $conn->query($sql);
	return $result;
}
function getBilStafTidakHadirByDepartment($jabatan) {
	$conn=db();
	
		$sql = "SELECT count(s.id) AS bil_staf FROM staff s 
			    LEFT JOIN role r ON r.`code` = s.role_id
			    WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
			    AND s.noic NOT IN (SELECT s.noic FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)) AND s.status = 'BEKERJA' AND s.pantau_kehadiran='1' AND s.department_id='$jabatan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	
	$result = $conn->query($sql);
	return $result->fetch_object()->bil_staf;
}
function getCountCutiByDepartment($jabatan) {
	$conn=db();
	
		$sql = "SELECT count(s.noic) as bil FROM staff s
			    LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
			    LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
			    LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
			    WHERE hp.approvement = 'APPROVE' AND s.status = 'BEKERJA'
			    AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir)
			    AND s.pantau_kehadiran='1' AND s.department_id='$jabatan' AND s.role_id NOT IN('ADMIN','SUPERADMIN')";
	
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getBilKehadiranStatusByDepartment($department_id,$status_kehadiran) {
	$conn=db();
	
		$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE s.department_id = '$department_id'
				AND k.status_kehadiran = '$status_kehadiran' 
				AND s.pantau_kehadiran = '1'
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}
function getJabatanByKod($department_kod) {
	$conn=db();
	$sql = "SELECT * FROM department WHERE code_department='$department_kod'";
	$result = $conn->query($sql);
	return $result;
}
function analisaKehadiranByJabatan($department_id) {
	$conn=db();
	$sql = "SELECT s.name,s.no_staff, COUNT(k.id) AS bil_kehadiran, lc.cawangan_kod,s.noic, d.description FROM staff s
			LEFT JOIN lkp_cawangan lc ON s.cawangan_kod = lc.cawangan_kod
			LEFT JOIN department d ON s.department_id = d.code_department
			LEFT JOIN kehadiran k ON s.noic = k.nokp_staff
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
			WHERE s.pantau_kehadiran = '1' 
			AND s.status = 'BEKERJA'
			AND s.department_id = '$department_id'
			AND s.role_id NOT IN ('ADMIN', 'SUPERADMIN') 
			GROUP BY s.noic ORDER BY s.name";
	$result = $conn->query($sql);
	return $result;
}
function analisaKehadiranStaffByJabatan($department_id,$noic,$status_kehadiran) {
	$conn=db();
	$sql = "SELECT COUNT(k.id) AS bil_hadir FROM kehadiran k	
			LEFT JOIN staff s ON k.nokp_staff = s.noic
			WHERE s.department_id = '$department_id'
			AND s.noic = '$noic' 
			AND k.status_kehadiran = '$status_kehadiran'
			AND s.pantau_kehadiran = '1'
			AND s.status = 'BEKERJA'
			AND DATE_FORMAT(k.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
	$result = $conn->query($sql)->fetch_object()->bil_hadir;
    return $result;
}
//end of analisa kehadiran jabatan
$conn->close();
?>