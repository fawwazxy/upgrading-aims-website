<?php
require '../../lib/db/connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date('m');
$date_year = date('Y');
$date_day = date('d');
$time_hour = date('H');
$time_min = date('i');
$time_sec = date('s');


$action=$_POST['action'];

//education
if ($action=="update_education") {

    $staff_edu_id= $_POST['staff_edu_id'];
    $pencapaian = $_POST['pencapaian'];
    $tempat = $_POST['tempat'];
    $tahun_mula = $_POST['tahun_mula'];
    $tahun_akhir = $_POST['tahun_akhir'];
    $keputusan = $_POST['keputusan'];
    $no_staff= $_POST['no_staff'];

    if($staff_edu_id=='0'){
        //need insert new data
        addEdu($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$no_staff);
    }else{
        //will update
        updateStaffEducation($staff_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan);
    }
}


if ($action=="del_education") {
    echo $staff_edu_id=clean($_POST['staff_edu_id']);
    if($staff_edu_id == "0"){

    }else{
        deleteEdu($staff_edu_id);
    }
}



//skills
if ($action=="update_skills") {
    $staff_skill_id=clean($_POST['staff_skill_id']);
    $skill=clean($_POST['skill']);
    $level=clean($_POST['level']);
    $no_staff=clean($_POST['no_staff']);

    if($staff_skill_id=='0'){
        //need insert new data
        addSkill($skill,$level,$no_staff);
    }else{
        //will update
        updateStaffKemahiran($staff_skill_id,$skill,$level);
    }
}


if ($action=="del_skill") {
    echo $staff_skill_id =clean($_POST['staff_skill_id']);
    if($staff_skill_id == "0"){

    }else{
        deleteSkill($staff_skill_id);
    }
}


//family

if ($action=="update_family") {
    $staff_family_id=clean($_POST['staff_family_id']);
    $nama=clean($_POST['nama']);
    $hubungan=clean($_POST['hubungan']);
    $pekerjaan=clean($_POST['pekerjaan']);
    $phone=clean($_POST['phone']);
    $no_staff=clean($_POST['no_staff']);

    if($staff_family_id=='0'){
        //need insert new data
        addFamily($nama,$hubungan,$pekerjaan,$phone,$no_staff);
    }else{
        //will update
        updateStaffFamily($staff_family_id,$nama,$hubungan,$pekerjaan,$phone);
    }
}


if ($action=="del_family") {
    echo $staff_family_id=clean($_POST['staff_family_id']);
    if($staff_family_id == "0"){

    }else{
        deleteFamily($staff_family_id);
    }
}



//experience
if ($action=="update_experience") {

    $staff_ex_id= $_POST['staff_ex_id'];
    $tempat_berkerja = $_POST['tempat_berkerja'];
    $tarikh_mula = $_POST['tarikh_mula'];
    $tarikh_akhir = $_POST['tarikh_akhir'];
    $gaji = $_POST['gaji'];
    $jawatan = $_POST['jawatan'];
    $peranan= $_POST['peranan'];
    $no_staff= $_POST['no_staff'];




    if($staff_ex_id=='0'){
        //need insert new data
        addExperience($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$no_staff);
    }else{
        //will update
        updateStaffExperience($staff_ex_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan);
    }
}


if ($action=="del_experience") {
    echo $staff_ex_id=clean($_POST['staff_ex_id']);
    if($staff_ex_id == "0"){

    }else{
        deleteExp($staff_ex_id);
    }
}

if ($action=="statusKelulusanUpdate") {
    $pemohon_id=$_POST['pemohon_id'];
    $pmohon_lulus_id=$_POST['pmohon_lulus_id'];

    $status = "TDKTERIMA";

    updateStatusPemohon($pemohon_id, $pmohon_lulus_id, $status);

    echo "Permohonan berjaya diproses.";
}

if ($action=="removePemohonData") {
    $pemohon_id=$_POST['pemohon_id'];
    $pmohon_lulus_id=$_POST['pmohon_lulus_id'];

    removePemohon($pemohon_id, $pmohon_lulus_id);

    echo "Permohonan berjaya dipadam.";
}
//add 20201013
if ($action=="subDepartment") {
    $kod_department = clean($_POST['kod_department']);
    $conn=db();
    $sql = "SELECT * FROM department_sub
				WHERE code_department='$kod_department'";
    $result = $conn->query($sql);
    echo '<option value="">-- Pilih Sub Bahagian --</option>';
    while($row = $result->fetch_assoc()){
        echo '<option value="'.$row['code_sub_department'].'">'.$row['code_sub_department'].' - '.$row['description'].'</option>';
    }

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
    $sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress,c.tel as ctel,c.email as cemail FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    $result = $conn->query($sql);
    return $result;
}

function login($username,$password) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
    $result = $conn->query($sql);
    return $result;
}

// function getLogUser($com_id) {
// $conn=db();
// $sql = "SELECT s.*,r.role,ss.desc FROM staff s
// LEFT JOIN role r ON s.role_id=r.id
// LEFT JOIN status_staff ss ON s.status=ss.id
// ";
// $result = $conn->query($sql);
// return $result;
// }

function getLogUser($com_id) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
    $result = $conn->query($sql);
    return $result;
}

function getLog($no_staff) {
    $conn=db();
    $sql = "   
	SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,j.jawatan AS jawatan_nama FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN jawatan j ON j.code=s.jawatan_code 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.id='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function getStaffRecordId($no_staff){
    $conn=db();
    $sql="SELECT id FROM staff_record WHERE no_staff = '$no_staff'";
    return $conn->query($sql)->fetch_object()->id;
}

function getDropDownStaff($selected) {
    $conn=db();
    $sql = "SELECT s.noic, CONCAT(noic,' - ',NAME),s.role_id FROM staff s
			LEFT JOIN role r ON s.role_id = r.code
			WHERE r.status_pelulus_cuti = '1' 
			AND s.status = 'BEKERJA'
			ORDER BY s.no_staff";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getLogStaff($cawangan_kod,$statact) {
    $conn=db();
    if ($statact=='ACTIVE') {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') AND s.role_id NOT IN ('CONTRACT') AND s.cawangan_kod='$cawangan_kod'
	ORDER BY s.name ASC";
    }

    else if ($statact=='INTERN') {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id='INTERN' AND s.role_id NOT IN ('CONTRACT') AND s.cawangan_kod='$cawangan_kod'
	ORDER BY s.name ASC";
    }

    else if ($statact=='CONTRACT') {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') AND s.role_id='CONTRACT' AND s.cawangan_kod='$cawangan_kod'
	ORDER BY s.name ASC";
    }

    else {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status NOT IN ('BEKERJA') AND s.cawangan_kod='$cawangan_kod'
	ORDER BY s.name ASC";
    }
    $result = $conn->query($sql);



    return $result;
}



function getLogStaffByJabatan($cawangan_kod,$jabatan_kod,$statact, $active_status) {
    $conn=db();
    $department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
    $role_id = $_SESSION['SESS_ROLE'];

    if (!in_array($department_sub,['HR','HR-SEA']) && !in_array($role_id, ['FOUNDER', 'MANAGER', 'SUPERADMIN'])){
        echo ("<script type='text/javascript'>
				window.location.href='../view/aims_hr_specialleavemessage.php';
				</script>");
    }

    $where_role = ($statact != '0') ? "AND s.role_id = '$statact'" : "";
    $where_cawangan = ($cawangan_kod != '0') ? "AND s.cawangan_kod='$cawangan_kod'" : "";
    $where_jabatan = ($jabatan_kod != '0') ? "AND s.department_id='$jabatan_kod'" : "";

    $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji,sr.id AS record_id FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
	WHERE s.noic <> '' AND s.status='$active_status' $where_role $where_cawangan $where_jabatan
	ORDER BY s.name";

    return $conn->query($sql);
}


function getPekerja($no_staff) {
    $conn=db();
    $sql = "   
	SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,j.jawatan AS jawatan_nama FROM staff s
	LEFT JOIN role r ON r.id=s.role_id
	LEFT JOIN status_staff ss ON ss.id=s.status
	LEFT JOIN department d ON d.id=s.department_id 
	LEFT JOIN jawatan j ON j.code=s.jawatan_code 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.no_staff='$no_staff' 
	
	";
    $result = $conn->query($sql);
    return $result;
}

function checkStaffRecord($no_staff) {
    $conn=db();
    $sql = "   
	SELECT id FROM staff_record WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function UpdateStatusStaff($no_staff) {
    $conn=db();
    $sql = "UPDATE staff  SET status = 'BERHENTI'
	WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    $sql2 = "UPDATE staff_record SET status = 'BERHENTI' WHERE no_staff='$no_staff'";
    $result = $conn->query($sql2);
    return $result;
}

function UpdateStatusSt($no_staff){
    $conn=db();
    $sql="
	UPDATE staff s,staff_record sr
	SET s.status = 'BEKERJA',
	sr.status = 'BEKERJA'
	
	WHERE s.no_staff='$no_staff'";

    $result=$conn->query($sql);

    return $result;


}

// function getLogStaff() {
// $conn=db();
// $sql = "SELECT s.*,sr.jawatan ,j.jawatan AS SD,r.role,ss.desc FROM staff s
// LEFT JOIN role r ON s.role_id=r.id
// LEFT JOIN status_staff ss ON s.status=ss.id
// LEFT JOIN staff_record sr ON s.no_staff=sr.no_staff
// LEFT JOIN department d ON d.id=s.department_id
// LEFT JOIN jawatan j ON j.code=sr.jawatan";
// $result = $conn->query($sql);

// // $sql2 = "UPDATE staff_record SET jawatan = 's.jawatan'
// // WHERE id = '$no_staff'

// // ";
// // $result = $conn->query($sql2);

// return $result;
// }

function getStaffInfo($no_staff) {
    $conn=db();
    $sql = "SELECT s.*,sr.*,r.role,ss.desc ,d.description AS department FROM staff s
	            LEFT JOIN role r ON s.role_id=r.id
            	LEFT JOIN status_staff ss ON s.status=ss.id
            	LEFT JOIN staff_record sr ON s.no_staff=sr.no_staff
            	LEFT JOIN department d ON d.code_department=s.department_id
            	WHERE s.no_staff='$no_staff' AND sr.tarikh_akhir IS NULL
            	";
    $result = $conn->query($sql);
    return $result;
}

function getStaffInformation($no_staff){
    $conn=db();
    $sql = "SELECT MAX(sr.id) AS staff_record_id,sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role, sr.total_cuti,sr.baki_cuti,sr.baki_cuti_pohon
            FROM staff_record sr 
            LEFT JOIN staff s ON s.no_staff=sr.no_staff 
            LEFT JOIN department d ON d.code_department=s.department_id 
            LEFT JOIN role r ON sr.peranan=r.code
            WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
            AND s.no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

// function getStaffInfo($id) {
// $conn=db();
// $sql = "SELECT s.*,j.jawatan,d.desc
// FROM staff s
// LEFT JOIN department d ON d.id=s.department_id";
// $result = $conn->query($sql);
// return $result;
// }

function getStaff($no_staff) {
    $conn=db();
    $sql = "SELECT s.*, sr.id , sr.tarikh_mula, sr.tarikh_akhir, sr.gaji, sr.jawatan, sr.peranan, 
	sr.nama_bank ,sr.no_akaun, sr.status, sr.total_cuti, sr.baki_cuti
	FROM staff s, staff_record sr 
	WHERE s.no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

//edit 20201013
function getStafIn($id) {
    $conn=db();
    $sql = "SELECT s.*,r.role,rg.role_group_name,d.description,g.description AS gender_name,m.desc as status_kahwin,ds.description as sub_department  
	FROM staff s
	LEFT JOIN gender g ON g.gender=s.gender 
	LEFT JOIN role r ON r.code=s.role_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN department_sub ds ON ds.code_sub_department=s.department_sub
	LEFT JOIN martial m ON m.id=s.martial_status 
	WHERE s.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getRecStart($nostaff) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh_mula,'%d/%m/%Y') AS tarikh_mula
	        FROM staff_record 
	        WHERE no_staff='$nostaff' 
	        ORDER BY tarikh_mula ASC 
	        LIMIT 1";
    $result = $conn->query($sql);
    return $result;
}

function getRecEnd($nostaff) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh_akhir,'%d/%m/%Y') AS tarikh_akhir 
	        FROM staff_record 
	        WHERE no_staff='$nostaff' 
	        ORDER BY tarikh_mula DESC 
	        LIMIT 1";
    $result = $conn->query($sql);
    return $result;
}

function activeStaff($id,$status){
    $conn=db();
    $sql=  "UPDATE staff SET status= $status WHERE id = $id";
    $result = $conn->query($sql);
    return $result;

}

function getRole() {
    $conn=db();
    $sql = "SELECT r.*, rg.role_group_name
	FROM role r
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	WHERE rg.role_group_name NOT IN ('SYSTEM')";
    $result = $conn->query($sql);
    return $result;
}

function getAddDepartment() {
    $conn=db();
    $sql = "SELECT * FROM department ";
    $result = $conn->query($sql);
    return $result;
}

function getAddJawatan() {
    $conn=db();
    $sql = "SELECT * FROM jawatan";
    $result = $conn->query($sql);
    return $result;
}

function getJawatan() {
    $conn=db();
    $sql = "SELECT * FROM jawatan WHERE code='CEO'";
    $result = $conn->query($sql);
    return $result;
}

function getAddStatus() {
    $conn=db();
    $sql = "SELECT * FROM status_staff ";
    $result = $conn->query($sql);
    return $result;
}

function getMartial() {
    $conn=db();
    $sql = "SELECT * FROM martial ";
    $result = $conn->query($sql);
    return $result;
}

function getPemohon() {
    $conn=db();
    $sql = "SELECT pk.*,p.name,p.phone,p.email,p.noic,sp.desc,sp.code,rg.role_group_name
	FROM pmohon_kelulusan pk
	LEFT JOIN role r ON r.role=pk.role_id 
	LEFT JOIN status_pemohon sp ON pk.status_pemohon=sp.code
	LEFT JOIN role_group rg ON rg.id=r.role_group_id
	LEFT JOIN pemohon p ON p.id=pk.pemohon_id 
	WHERE pk.status_pemohon='TERIMA'
	ORDER BY pk.created_date DESC";
    $result = $conn->query($sql);
    return $result;
}

function updateStatusPemohon($pemohon_id, $pmohno_klulusan_id, $status){
    $conn=db();
    $sql7 = "UPDATE pemohon SET status_pemohon = '$status' 
	WHERE id = '$pemohon_id'";
    $result = $conn->query($sql7) or die($conn->error);

    $sql9 = "UPDATE pmohon_kelulusan SET status_pemohon = '$status' 
	WHERE id = '$pmohno_klulusan_id'";
    $result = $conn->query($sql9) or die($conn->error);

    return $result;
}

function removePemohon($pemohon_id, $pmohno_klulusan_id){
    $conn=db();
    $sql7 = "DELETE FROM pemohon WHERE id = '$pemohon_id'";
    $result = $conn->query($sql7) or die($conn->error);

    $sql9 = "DELETE FROM pmohon_kelulusan WHERE id = '$pmohno_klulusan_id'";
    $result = $conn->query($sql9) or die($conn->error);

    return $result;
}

function getStaffGajiPokok($no_staff) {
    $conn=db();
    $sql = " SELECT gaji FROM staff_record WHERE status='bekerja' AND no_staff='$no_staff' AND tarikh_akhir IS NULL";
    $result = $conn->query($sql);
    return $result->fetch_object()->gaji;
}

function getSal($no_staff){
    $conn=db();
    $sql=" SELECT sl.*,sa.jenis_kelulusan, ssr.desc AS salary_status,sr.gaji AS gajitotal
	FROM salary sl
	LEFT JOIN salary_approve sa ON sa.staff_salary_id=sl.id 
	LEFT JOIN status_salary ssr 
	ON ssr.code=sa.jenis_kelulusan 
	LEFT JOIN staff_record sr 
	ON sr.no_staff=sl.no_staff
	WHERE sl.no_staff='$no_staff' ";

    $result=$conn->query($sql);
    return $result;
}

function getSalaryStaff($no_staff,$tahun,$bulan){
    $conn=db();
    $sql=" SELECT sl.*,sa.jenis_kelulusan, ssr.desc AS salary_status
	FROM salary sl
	LEFT JOIN salary_approve sa ON sa.staff_salary_id=sl.id 
	LEFT JOIN status_salary ssr 
	ON ssr.code=sa.jenis_kelulusan 
	WHERE sl.no_staff='$no_staff' AND YEAR(tarikh_bayar)='$tahun' AND MONTH(tarikh_bayar)='$bulan' ";
    $result=$conn->query($sql);
    return $result;
}

function updateNotiPelulusSal($noti_status,$no_staff,$jenis_kelulusan){
    $conn=db();
    $sql="UPDATE salary_approve SET noti_status_pelulus='1'
	WHERE approve_by='$no_staff'
	AND jenis_kelulusan='$jenis_kelulusan'";

    $result = $conn->query($sql);
    return $result;
}

//count notification number page superior or HR
function getNotificationPelulusSal($no_staff,$jenis_kelulusan){
    $conn=db();
    $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM salary_approve 
	WHERE noti_status_pelulus='0'
	AND jenis_kelulusan='$jenis_kelulusan'
	AND approve_by='$no_staff'";

    $n_status_1= $conn->query($sql)->fetch_object()->noti;
    return $n_status_1;
}

function getCheckboxUpdateGaji($id,$no_staff){
    $conn=db();
    if(isset($_POST['checkbox'])){
        $checkbox = $_POST['checkbox'];
        if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
            $id = "('" . implode( "','", $checkbox ) . "');" ;
        $sql="UPDATE salary_approve SET approve_by='$no_staff',catatan='-',tarikh_diluluskan=SysDate(),noti_status_pelulus='1', jenis_kelulusan = '".(isset($activate)?'LULUS':'TDKLULUS')."' WHERE id IN $id" ;
        $result=$conn->query($sql);
        return $result;
    }
}

function getStatusBulan($bulan,$currently_selected,$no_staff){
    $conn=db();
    $sql="SELECT tarikh_bayar,gaji_bulan,gaji_tahun FROM salary WHERE gaji_bulan=$bulan AND gaji_tahun=$currently_selected AND no_staff='$no_staff'";
    $result=$conn->query($sql);
    return $result;
}
//tambah staff
function addNewStaff($id,$shortcode) {
    $conn=db();

    $no_staff=getRunning_No("no_staff",$shortcode);

    $sql =
        "INSERT INTO staff(noic, NAME, phone, email, alamat_tetap, alamat_surat, umur, company_id,status, martial_status, tanggungan,gender,no_staff,role_id,cawangan_kod)
	SELECT noic, NAME, phone, email, alamat_tetap, alamat_surat, umur, company_id,'BEKERJA',martial_status, tanggungan,gender,'$no_staff',role_id,cawangan_kod FROM pemohon WHERE id='$id' ";
    $result = $conn->query($sql);


    $new_staffid=$conn->insert_id;

    $sql1 =
        "INSERT INTO staff_education (pencapaian, tempat, tahun_mula, tahun_akhir, keputusan,no_staff)
	SELECT PE.pencapaian, PE.tempat, PE.tahun_mula, PE.tahun_akhir, PE.keputusan, '$no_staff' FROM pmohon_education PE
	WHERE PE.pemohon_id='$id'";
    $result = $conn->query($sql1);

    $sql2 =
        "INSERT INTO staff_experience (tempat_berkerja, tarikh_mula, tarikh_akhir, gaji, jawatan, peranan, no_staff)
	SELECT PEX.tempat_berkerja, PEX.tarikh_mula, PEX.tarikh_akhir, PEX.gaji, PEX.jawatan, PEX.peranan,'$no_staff' FROM pmohon_experience PEX
	WHERE PEX.pemohon_id='$id'";
    $result = $conn->query($sql2);

    $sql3 =
        "INSERT INTO staff_family (nama, phone, pekerjaan, hubungan, no_staff)
	SELECT PF.nama, PF.phone, PF.pekerjaan, PF.hubungan, '$no_staff' FROM pmohon_family PF
	WHERE PF.pemohon_id='$id'";
    $result = $conn->query($sql3);

    $sql4 =
        "INSERT INTO staff_family (nama, phone, pekerjaan, hubungan, no_staff)
	SELECT PF.nama, PF.phone, PF.pekerjaan, PF.hubungan, '$no_staff' FROM pmohon_family PF
	WHERE PF.pemohon_id='$id'";
    $result = $conn->query($sql4s);


    $sql4 =
        "INSERT INTO staff_skill(skill, LEVEL, no_staff)
	SELECT PS.skill, PS.level, '$no_staff' FROM pmohon_skill PS
	WHERE PS.pemohon_id='$id'";
    $result = $conn->query($sql4);

    //Last activity after insert
    $sql7 = "UPDATE pemohon SET status_pemohon = 'STAFF' 
	WHERE id = '$id'";
    $result = $conn->query($sql7);

    $sql8 = "UPDATE staff SET status = 'BEKERJA' 
	WHERE no_staff= '$no_staff'";
    $result = $conn->query($sql8);

    $sql9 = "UPDATE pmohon_kelulusan SET status_pemohon = 'STAFF' 
	WHERE pemohon_id = '$id'";
    $result = $conn->query($sql9);

    return $result;
}


///tgok tambah satu atau tidak
function getRunning_No($reference,$shortcode) {
    $conn=db();
    $new_running_no='';
    if ($reference=='no_staff'){
        $new_running_no=$shortcode;
    }else if($reference=='no_slip'){
        $new_running_no='SG';
    }

    $sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
    $run_no = $conn->query($sql)->fetch_object()->running_no ;
    $staff_number =$new_running_no.$run_no;

    //update running no

    $sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
    $result = $conn->query($sql8);

    return $staff_number;


}
function getRunning_NoView($reference,$shortcode) {
    $conn=db();
    $new_running_no='';
    if ($reference=='no_staff'){
        $new_running_no=$shortcode;
    }else if($reference=='no_slip'){
        $new_running_no='SG';
    }

    $sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
    $run_no = $conn->query($sql)->fetch_object()->running_no ;
    $staff_number =$new_running_no.$run_no;

    //update running no
    return $staff_number;


}


//INSERT TO TABLE STAFF EDUCATION FROM PEMOHON EDUCATION
function addStaffEducation() {
    $conn=db();
    $sql1 =
        "INSERT INTO staff_education (pencapaian, tempat, tahun_mula, tahun_akhir, keputusan)
	SELECT PE.pencapaian, PE.tempat, PE.tahun_mula, PE.tahun_akhir, PE.keputusan FROM pmohon_education PE
	LEFT JOIN pemohon p ON PE.pemohon_id=p.id";
    $result = $conn->query($sql1);

    return $result;
}


//tambahan athirah
function getCutiTahunan ($salary_id,$staff_record_id){
    $conn=db();
    $sql="SELECT *
	FROM staff_holiday WHERE id='$salary_id' AND staff_record_id='$staff_record_id'";

    $result=$conn->query($sql);
    return $result;
}

function getMonthString($num)
{

    //Create a local variable to hold the string
    switch($num)
    {
        case 1:
            $month="Januari";
            break;
        case 2:
            $month="Februari";
            break;
        case 3:
            $month="Mac";
            break;
        case 4:
            $month="April";
            break;
        case 5:
            $month="Mei";
            break;
        case 6:
            $month="Jun";
            break;
        case 7:
            $month="Julai";
            break;
        case 8:
            $month="Ogos";
            break;
        case 9:
            $month="September";
            break;
        case 10:
            $month="Oktober";
            break;
        case 11:
            $month="November";
            break;
        case 12:
            $month="Disember";
            break;
        default:
            $month="Invalid month";
    }
    return $month;
}


function isStaffdplct($id) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE id='$id'" ;
    $result = $conn->query($sql);
    $duplicate=$result->num_rows;
    return $duplicate;
}

function activePemohon($id,$status){
    $conn=db();
    $sql=  "UPDATE pemohon SET status= $status WHERE id = $id";
    $result = $conn->query($sql);
    return $result;

}


function getEmployerSocso($gaji_pokok){
    $conn=db();
    $sql=" SELECT majikan
	FROM socso
	WHERE '$gaji_pokok' BETWEEN gaji_min AND gaji_max ";
    $result=$conn->query($sql)->fetch_object();
    return $result -> majikan;
}

function getSocsoPekerja($gaji_pokok){
    $conn=db();
    $sql=" SELECT pekerja
	FROM socso
	WHERE '$gaji_pokok' BETWEEN gaji_min AND gaji_max ";
    $result=$conn->query($sql)->fetch_object();
    return $result -> pekerja;
}

function getCompany() {
    $conn=db();
    $sql = "SELECT * FROM company";
    $result = $conn->query($sql);
    return $result;
}

function getNama($id){
    $conn=db();
    $sql="SELECT name FROM staff WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;

}



function getValueName($no_staff){
    $conn=db();
    $sql="SELECT * FROM staff WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;


}



function getGender() {
    $conn=db();
    $sql = "SELECT * FROM gender ";
    $result = $conn->query($sql);
    return $result;
}



function getStaffMaklumat($no_staff) {
    $conn=db();
    $sql = "SELECT s.*,sr.*,d.code_department
	FROM staff s LEFT JOIN staff_record sr ON s.id=sr.staff_id
	LEFT JOIN department d ON d.id=s.department_id WHERE s.no_staff
	='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}


function getStaffRecord($no_staff) {
    $conn=db();
    $sql = " SELECT s.*,sr.*,d.description,m.desc 
	FROM staff s LEFT JOIN staff_record sr ON s.no_staff=sr.no_staff
	AND s.jawatan_code=sr.jawatan
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial m ON m.id=s.martial_status
	WHERE s.no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}




function getStaffPendidikan($no_staff) {
    $conn=db();
    $sql = "SELECT *
	FROM staff_education WHERE no_staff='$no_staff' ORDER BY tahun_mula DESC";
    $result = $conn->query($sql);
    return $result;
}



function getStaffPengalaman($no_staff) {
    $conn=db();
    $sql = "SELECT *
	FROM staff_experience  WHERE no_staff='$no_staff' ORDER BY tarikh_mula DESC";
    $result = $conn->query($sql);
    return $result;
}

function getStaffKemahiran($no_staff) {
    $conn=db();
    $sql = "SELECT *
	FROM staff_skill WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function getStaffFamily($no_staff) {
    $conn=db();
    $sql = "SELECT *
	FROM staff_family  WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}



function updateStaffEducation($staff_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan) {
    $conn=db();

    $sql = "UPDATE staff_education SET pencapaian = '$pencapaian', tempat='$tempat', tahun_mula='$tahun_mula',
	tahun_akhir='$tahun_akhir', keputusan='$keputusan'
	WHERE id = '$staff_edu_id'";
    $result = $conn->query($sql);


    return $result;
}



function updateStaffExperience($staff_ex_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan) {
    $conn=db();
    $sql = "UPDATE staff_experience SET tempat_berkerja = '$tempat_berkerja', tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'),
	gaji='$gaji', jawatan='$jawatan' ,peranan='$peranan'
	WHERE id = '$staff_ex_id'";
    $result = $conn->query($sql);
    return $result;
}

function updateStaffKemahiran($staff_skill_id,$skill,$level) {
    $conn=db();
    $sql = "UPDATE staff_skill SET  skill = '$skill', level='$level'
	WHERE id = '$staff_skill_id'";
    $result = $conn->query($sql);
    return $result;
}


function updateStaffFamily($staff_family_id,$nama,$hubungan,$pekerjaan,$phone) {
    $conn=db();
    $sql = "UPDATE staff_family SET  nama = '$nama', hubungan='$hubungan',
	pekerjaan='$pekerjaan', phone='$phone'
	WHERE id = '$staff_family_id'";
    $result = $conn->query($sql);
    return $result;
}


function addEdu($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$no_staff) {
    $conn=db();
    $sql = "INSERT INTO staff_education(pencapaian,tempat,tahun_mula,tahun_akhir,keputusan,no_staff) 
	VALUES('$pencapaian','$tempat','$tahun_mula','$tahun_akhir','$keputusan','$no_staff')";
    $result = $conn->query($sql);
    return $result;
}

function addSkill($skill,$level,$no_staff) {
    $conn=db();
    $sql = "INSERT INTO staff_skill(skill,level,no_staff) 
	VALUES('$skill','$level','$no_staff')";
    $result = $conn->query($sql);
    return $result;
}

function addFamily($nama,$hubungan,$pekerjaan,$phone,$no_staff) {
    $conn=db();
    $sql = "INSERT INTO staff_family(nama,hubungan,pekerjaan,phone,no_staff) 
	VALUES('$nama','$hubungan','$pekerjaan','$phone','$no_staff')";
    $result = $conn->query($sql);
    return $result;
}


function addExperience($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$no_staff) {
    $conn=db();
    $sql = "INSERT INTO staff_experience(tempat_berkerja,tarikh_mula,tarikh_akhir,gaji,jawatan,peranan,no_staff) 
	VALUES('$tempat_berkerja',STR_TO_DATE('$tarikh_mula','%d/%m/%Y'),STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'),'$gaji','$jawatan','$peranan','$no_staff')";
    $result = $conn->query($sql);
    return $result;
}


//delete staff education
function deleteEdu($staff_edu_id) {
    $conn=db();
    $sql = "DELETE FROM staff_education WHERE id = '$staff_edu_id'";
    $result = $conn->query($sql);
    return $result;
}


function deleteExp($staff_ex_id) {
    $conn=db();
    $sql = "DELETE FROM staff_experience WHERE id = '$staff_ex_id'";
    $result = $conn->query($sql);
    return $result;
}


function deleteFamily($staff_family_id) {
    $conn=db();
    $sql = "DELETE FROM staff_family WHERE id = '$staff_family_id'";
    $result = $conn->query($sql);
    return $result;
}


function deleteSkill($staff_skill_id) {
    $conn=db();
    $sql = "DELETE FROM staff_skill WHERE id = '$staff_skill_id'";
    $result = $conn->query($sql);
    return $result;
}




function getSalary($no_staff) {
    $conn=db();
    $sql = "SELECT s.*, e.nilai_elaun, e.nama_elaun 
	FROM salary s
	LEFT JOIN elaun e ON e.
	WHERE no_staff='$no_staff'
	";
    $result = $conn->query($sql);
    return $result;
}

function getStaffTolakGaji($no_staff) {
    $conn=db();
    $sql = " SELECT SUM(jumlah_tolak) AS total FROM tolak_gaji WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function getKWSPpekerja($gaji_pokok){
    $conn=db();
    $sql=" SELECT pekerja
	FROM kwsp
	WHERE '$gaji_pokok' BETWEEN gaji_min AND gaji_max ";
    $result=$conn->query($sql)->fetch_object();
    return $result -> pekerja;



}

function getKWSPMajikan($gaji_pokok){
    $conn=db();
    $sql=" SELECT majikan
	FROM kwsp
	WHERE '$gaji_pokok' BETWEEN gaji_min AND gaji_max ";
    $result=$conn->query($sql)->fetch_object();
    return $result -> majikan;


}

function addSalary($tarikh_bayar,$no_staff,$kwsp,$socso,$elaun,$claim,$gaji_kasar,$tolak_gaji,$gaji_bersih,$gaji_pokok,$gaji_dibayar,$belum_bayar,$jumlah_potongan,$kwsp_majikan,$socso_majikan,$gaji_bulan,$gaji_tahun) {
    $conn=db();
    //no slip generate
    $no_slip=getRunning_No("no_slip");
    $sql = "INSERT INTO salary (tarikh_bayar,no_staff,no_slip,kwsp,socso,elaun,claim,gaji_kasar,tolak_gaji,gaji_bersih,gaji_pokok,gaji_dibayar,belum_bayar,jumlah_potongan,kwsp_majikan,socso_majikan,gaji_bulan,gaji_tahun)
	VALUES('$tarikh_bayar','$no_staff','$no_slip','$kwsp','$socso','$elaun','$claim','$gaji_kasar','$tolak_gaji','$gaji_bersih','$gaji_pokok,','$gaji_dibayar','$belum_bayar','$jumlah_potongan','$kwsp_majikan','$socso_majikan','$gaji_bulan','$gaji_tahun')";
    $result = $conn->query($sql);
    $staff_salary_id=$conn->insert_id;
    $sql2 = "INSERT INTO salary_approve(staff_salary_id,jenis_kelulusan)
	VALUES('$staff_salary_id','BLMHNTR')";
    $result2 = $conn->query($sql2);
    return $result;
}

function getStaffRecordInfo($no_staff) {
    $conn=db();
    $sql = "SELECT sr.*, r.role AS myperanan,j.jawatan AS myjawatan,d.description  AS mybahagian,s.phone AS phone,s.department_sub AS myunit,rg.role_group_name,c.nama AS cawangan
	FROM staff_record sr
	LEFT JOIN role r ON r.code=sr.peranan
	LEFT JOIN department d ON d.code_department=sr.department
	LEFT JOIN jawatan j ON j.code=sr.jawatan 
	LEFT JOIN staff s ON s.no_staff=sr.no_staff
	LEFT JOIN role_group rg ON rg.id=r.role_group_id
	LEFT JOIN lkp_cawangan c ON c.cawangan_kod=sr.cawangan_kod
	WHERE sr.no_staff='$no_staff' ORDER BY sr.id DESC";
    $result = $conn->query($sql);
    return $result;
}

function getStaffRecordDetails($staff_record_id) {
    $conn=db();
    $sql = "SELECT * FROM staff_record WHERE id='$staff_record_id'";
    $result = $conn->query($sql);
    return $result;
}

function getSalaryInfo($salary_id) {
    $conn=db();
    $sql = "SELECT * FROM salary WHERE id='$salary_id'";
    $result = $conn->query($sql);
    return $result;
}


function updateSalary($salary_id,$gaji_pokok,$elaun,$claim,$gaji_kasar,$kwsp,$socso,$tolak_gaji,$gaji_bersih,$gaji_dibayar,$belum_bayar,$tarikh_bayar,$jumlah_potongan,$kwsp_majikan,$socso_majikan) {
    $conn=db();
    $sql = "UPDATE salary SET gaji_pokok='$gaji_pokok',elaun='$elaun',claim='$claim',gaji_kasar='$gaji_kasar',kwsp='$kwsp',socso='$socso',tolak_gaji='$tolak_gaji'
	,gaji_bersih='$gaji_bersih',gaji_dibayar='$gaji_dibayar',belum_bayar='$belum_bayar',tarikh_bayar='$tarikh_bayar', jumlah_potongan='$jumlah_potongan', kwsp_majikan='$kwsp_majikan', socso_majikan='$socso_majikan'
	WHERE id='$salary_id'";
    $result = $conn->query($sql);
    return $result;
}

//tambah rekod staf
//20201013
function addStaffRecord($no_staff,$tarikh_mula,$tarikh_akhir,$gaji,$peranan,$department,$nama_bank,$no_akaun,$status,$total_cuti,$baki_cuti,$baki_cuti_pohon,$catatan,$cawangan,$rule_cuti,$department_sub) {
    $conn=db();
    $end_date = "NULL";
    if($tarikh_akhir!=""){
        $end_date = "STR_TO_DATE('$tarikh_akhir','%Y-%m-%d')";
        $sql8 = "UPDATE staff SET role_id = '$peranan' ,department_id = '$department', cawangan_kod='$cawangan',department_sub='$department_sub'
		WHERE no_staff= '$no_staff'";
        $result = $conn->query($sql8);
    }else{
        $sql8 = "UPDATE staff SET role_id = '$peranan' ,department_id = '$department', cawangan_kod='$cawangan',department_sub='$department_sub'
		WHERE no_staff= '$no_staff'";
        $result = $conn->query($sql8);
    }

    $sql = "INSERT INTO staff_record (no_staff,tarikh_mula,tarikh_akhir,gaji,peranan,department,nama_bank,no_akaun,status,catatan,no_epf,no_socso,cawangan_kod,rule_cuti,department_sub)
	VALUES('$no_staff',STR_TO_DATE('$tarikh_mula','%Y-%m-%d'),$end_date,'$gaji','$peranan','$department','$nama_bank','$no_akaun','$status','$catatan','$no_epf','$no_socso','$cawangan','$rule_cuti','$department_sub')";
    $result = $conn->query($sql);

    $staff_record_id = $conn->insert_id;
    $sql = "INSERT INTO staff_total_cuti (staff_record_id,jenis_cuti,total_cuti,baki_cuti,baki_cuti_pohon,tahun) (SELECT '$staff_record_id',code,$rule_cuti,$rule_cuti,$rule_cuti,YEAR(CURRENT_TIMESTAMP) FROM jenis_cuti WHERE code IN ('AL','MC'))";
    $result = $conn->query($sql);

    $sql = "INSERT INTO aims_lv_total_medical (staff_record_id,entitle_medical,jumlah_claim,baki_claim,tahun) (SELECT '$staff_record_id','1000','1000','1000',YEAR(CURRENT_TIMESTAMP))";
    $result = $conn->query($sql);

    return $result;
}

//kemaskini rekod staf
//20201013
function updateStaffRecord($staff_record_id,$tarikh_mula,$tarikh_akhir,$gaji,$peranan,$department,$nama_bank,$no_akaun,$status,
                           $total_cuti,$baki_cuti,$baki_cuti_pohon,$catatan,$no_staff,$cawangan,$rule_cuti,$department_sub) {
    $conn=db();
    $end_date = "NULL";
    if($tarikh_akhir!=""){
        $end_date = "STR_TO_DATE('$tarikh_akhir','%d/%m/%Y')";
    }

    $sql = "UPDATE staff_record SET tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=$end_date,gaji='$gaji',
	peranan='$peranan',department='$department',nama_bank='$nama_bank',no_akaun='$no_akaun'
	,status='$status',catatan='$catatan', cawangan_kod='$cawangan',rule_cuti='$rule_cuti',department_sub='$department_sub'
	WHERE id='$staff_record_id'";
    $result = $conn->query($sql);

// 	$current_year = date('Y');
// 	$sql = "SELECT staff_record_id,tahun FROM staff_total_cuti WHERE staff_record_id = '$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP)";
//   	$tahun = $conn->query($sql)->fetch_object()->tahun;

//   	if($tahun == $current_year) {
// 		$sql = "UPDATE staff_total_cuti stc 
// 				LEFT JOIN jenis_cuti jc ON jc.code=stc.jenis_cuti
// 				SET stc.baki_cuti=($rule_cuti-(SELECT (stc.total_cuti - stc.baki_cuti))),stc.baki_cuti_pohon=($rule_cuti-(SELECT (stc.total_cuti - stc.baki_cuti_pohon))),stc.total_cuti=$rule_cuti
// 				WHERE stc.staff_record_id='$staff_record_id' AND stc.tahun=YEAR(CURRENT_TIMESTAMP)";
// 		$result = $conn->query($sql);
//   	}
//   	else {
// 		$sql = "INSERT INTO staff_total_cuti (staff_record_id,jenis_cuti,total_cuti,baki_cuti,baki_cuti_pohon,tahun) (SELECT '$staff_record_id',code,$rule_cuti,$rule_cuti,$rule_cuti,YEAR(CURRENT_TIMESTAMP) FROM jenis_cuti WHERE code IN ('AL','MC'))";
// 		$result = $conn->query($sql);
//   	}

    $sql8 = "UPDATE staff SET role_id = '$peranan',department_id='$department',status='$status', cawangan_kod='$cawangan',department_sub='$department_sub'
	WHERE no_staff= '$no_staff'";
    $result = $conn->query($sql8);

    return $result;
}

function updateStaff($id,$no_staff,$name,$noic,$umur,$martial_status,$tanggungan,$phone,$email,$alamat_tetap,
                     $alamat_surat,$status,$username,$accs_pwd,$nama_photo,$leave_approval,$pantau_kehadiran,$gender,$cawangan_kod,$company_id,$jum_jam_kerja,$jum_jam_break,$status_qrcode,$status_swafoto,$status_tag) {
    $conn=db();
    if($id==0){
        if($nama_photo!=""){
            $gambar=" ,nama_photo";
            $gambar_val=",'$nama_photo'";
        }
        $sql ="INSERT INTO staff(noic, name, username, accs_pwd,  phone, email, alamat_tetap, alamat_surat, umur,status, martial_status, tanggungan,gender,leave_approval,pantau_kehadiran,no_staff,company_id,cawangan_kod,role_id,jum_jam_kerja,jum_jam_break$gambar) VALUES ('$noic','$name','$username','$accs_pwd','$phone','$email','$alamat_tetap','$alamat_surat','$umur','$status','$martial_status','$tanggungan','$gender','$leave_approval','$pantau_kehadiran','$no_staff','$company_id','$cawangan_kod','STAFF','$jum_jam_kerja','$jum_jam_break'$gambar_val)";

        $sqlupdate = "UPDATE running_no SET running_no=running_no+1 WHERE reference='no_staff'";
        $result = $conn->query($sqlupdate);

    }else{

        $sqlMaxid = "SELECT MAX(id) AS id FROM staff_record WHERE no_staff='$no_staff'";
        $id_staff_record = $conn->query($sqlMaxid)->fetch_object()->id;
        $sql_update_record="UPDATE staff_record SET cawangan_kod='$cawangan_kod' WHERE id='$id_staff_record'";
        $conn->query($sql_update_record);
        $sql = "UPDATE staff SET no_staff='$no_staff' ,name='$name', noic='$noic', umur='$umur',martial_status='$martial_status',leave_approval='$leave_approval',pantau_kehadiran='$pantau_kehadiran',tanggungan='$tanggungan',gender='$gender', phone='$phone', email='$email', alamat_tetap='$alamat_tetap', alamat_surat='$alamat_surat',status='$status',username='$username', accs_pwd='$accs_pwd',cawangan_kod='$cawangan_kod',jum_jam_kerja='$jum_jam_kerja',jum_jam_break='$jum_jam_break',status_qrcode='$status_qrcode',status_swafoto='$status_swafoto',status_tag='$status_tag'";
        if($nama_photo!=""){
            $sql.=" ,nama_photo='$nama_photo' ";
        }
        $sql.="  WHERE id='$id'";
    }
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}


function UpdateStatusSalary($id,$no_staff_login){
    $conn=db();
    $sql="UPDATE salary_approve
	SET jenis_kelulusan = 'SDGDIPROSES', 
	request_id = '$no_staff_login'
	
	WHERE staff_salary_id='$id'";

    $result=$conn->query($sql);
    return $result;

}

function getSalaryApprove($salary_id) {
    $conn=db();
    $sql = "SELECT * FROM salary_approve WHERE id='$salary_id'";
    $result = $conn->query($sql);
    return $result;
}


function getSalaryApp() {
    $conn=db();
    $sql = " SELECT sa.*,sa.jenis_kelulusan, ssr.desc AS salary_status,s.name AS nama_pekerja,sl.no_slip,
	j.role AS nama_jawatan,d.description,st.name AS requester,stf.name AS approver, s.no_staff
	FROM salary_approve sa
	LEFT JOIN salary sl
	ON sl.id=sa.staff_salary_id
	LEFT JOIN status_salary ssr
	ON ssr.code=sa.jenis_kelulusan
	LEFT JOIN staff s ON s.no_staff=sl.no_staff
	LEFT JOIN staff st ON st.no_staff=sa.request_id
	LEFT JOIN staff stf ON stf.no_staff=sa.approve_by
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN role j ON s.role_id = j.code
	WHERE sa.jenis_kelulusan='SDGDIPROSES'
	ORDER BY sa.id DESC";
    $result = $conn->query($sql);
    return $result;
}

function getSalaryAppLulus() {
    $conn=db();
    $sql = " SELECT sa.*,sa.jenis_kelulusan, ssr.desc AS salary_status,s.name AS nama_pekerja,sl.no_slip,
	j.role AS nama_jawatan,d.description,st.name AS requester,stf.name AS approver, s.no_staff,sl.gaji_bersih AS gaji
	FROM salary_approve sa
	LEFT JOIN salary sl
	ON sl.id=sa.staff_salary_id
	LEFT JOIN status_salary ssr
	ON ssr.code=sa.jenis_kelulusan
	LEFT JOIN staff s ON s.no_staff=sl.no_staff
	LEFT JOIN staff st ON st.no_staff=sa.request_id
	LEFT JOIN staff stf ON stf.no_staff=sa.approve_by
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN role j ON s.role_id = j.code
	WHERE sa.jenis_kelulusan='LULUS'
	ORDER BY sa.id DESC";
    $result = $conn->query($sql);
    return $result;
}

function getSalaryAppTidakLulus() {
    $conn=db();
    $sql = " SELECT sa.*,sa.jenis_kelulusan, ssr.desc AS salary_status,s.name AS nama_pekerja,sl.no_slip,
	j.role AS nama_jawatan,d.description,st.name AS requester,stf.name AS approver, s.no_staff
	FROM salary_approve sa
	LEFT JOIN salary sl
	ON sl.id=sa.staff_salary_id
	LEFT JOIN status_salary ssr
	ON ssr.code=sa.jenis_kelulusan
	LEFT JOIN staff s ON s.no_staff=sl.no_staff
	LEFT JOIN staff st ON st.no_staff=sa.request_id
	LEFT JOIN staff stf ON stf.no_staff=sa.approve_by
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN role j ON s.role_id = j.code
	WHERE sa.jenis_kelulusan='TDKLULUS'
	ORDER BY sa.id DESC";
    $result = $conn->query($sql);
    return $result;
}




function getSalaryAppInfo($staff_salary_id) {
    $conn=db();
    $sql = "    
	SELECT sa.*,sl.*,sa.jenis_kelulusan, ssr.desc AS salary_status,s.name AS nama_pekerja,sl.no_slip,j.role AS nama_jawatan,d.description
	FROM salary_approve sa LEFT JOIN salary sl ON sl.id=sa.staff_salary_id
	LEFT JOIN status_salary ssr ON ssr.code=sa.jenis_kelulusan 
	LEFT JOIN staff s ON s.no_staff=sl.no_staff
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role j ON s.role_id = j.code
	WHERE sa.id='$staff_salary_id'";
    $result = $conn->query($sql);
    return $result;
}



function statusKelulusanGaji(){
    $conn=db();
    $sql="SELECT * FROM status_salary WHERE code IN ('LULUS','TDKLULUS')";

    $result=$conn->query($sql);
    return $result;
}

//tambahan athirah
function checkElaun ($no_staff, $code_department){
    $jumlah_elaun=0;
    $conn=db();
    $sql="SELECT * FROM elaun WHERE status='1'";

    $result=$conn->query($sql);
    while($row=$result->fetch_assoc()) {

        if($row['jenis_elaun']=='UMUM')
        {
            $jumlah_elaun = ( $jumlah_elaun + $row ['nilai_elaun']);
        }
        else if ($row['jenis_elaun']=='DEPARTMENT')
        {
            if ($code_department==$row['ref']){
                $jumlah_elaun = ($jumlah_elaun + $row ['nilai_elaun']);
            }
        }
        else if($row['jenis_elaun']=='INDIVIDU')
        {
            if ($no_staff==$row['ref']){
                $jumlah_elaun = ($jumlah_elaun + $row ['nilai_elaun']);
            }
        }
    }
    return $jumlah_elaun;
}

function getlistElaun ($no_staff, $code_department){
    $jumlah_elaun=0;
    $conn=db();
    $sql="SELECT * FROM elaun WHERE status='1'";

    $result=$conn->query($sql);
    while($row=$result->fetch_assoc()) {

        if($row['jenis_elaun']=='UMUM')
        {
            $jumlah_elaun = ( $jumlah_elaun + $row ['nilai_elaun']);
            echo $jumlah_elaun;
        }
        else if ($row['jenis_elaun']=='DEPARTMENT')
        {
            if ($code_department==$row['ref']){
                $jumlah_elaun = ($jumlah_elaun + $row ['nilai_elaun']);
                echo $jumlah_elaun;
            }
        }
        else if($row['jenis_elaun']=='INDIVIDU')
        {
            if ($no_staff==$row['ref']){
                $jumlah_elaun = ($jumlah_elaun + $row ['nilai_elaun']);
                echo $jumlah_elaun;
            }
        }
    }
    return $jumlah_elaun;
}

function checkClaim($no_staff,$approve_status,$tahun,$bulan){

    $conn=db();
    $sql="SELECT SUM(jumlah_tuntut) AS total
    	FROM claim_approve  ca
    	LEFT JOIN tarikh_tuntutan tt ON ca.tarikh_tuntutan_id =tt.id
    	WHERE ".
        getTarikhTuntutanFinal()." AND ca.approve_status='L' AND ca.no_pemohon='$no_staff'  ";

    $result= $conn->query($sql);


    return $result;
}

function getTarikhTuntutanFinal(){

    $conn=db();
    $sql="SELECT * , MONTH(CURRENT_TIMESTAMP) AS bulan FROM tarikh_tuntutan WHERE status_tuntutan= 1 LIMIT 1 ";

    $result= $conn->query($sql);

    while($row=$result->fetch_assoc()) {

        if($row['bulan']==$row['perubahan_tarikh'])
        {
            //check if current id not equal 0 after ditolak
            if($row['id'] - 1 > 0){
                $sql="SELECT * , MONTH(CURRENT_TIMESTAMP) AS bulan FROM tarikh_tuntutan WHERE id= ".($row['id'] - 1);

                $tarikhaktif= $conn->query($sql)->fetch_assoc();
                return "tarikh_approvement BETWEEN '".$tarikhaktif['tarikh_mula_tuntutan']."' AND '".$tarikhaktif['tarikh_akhir_tuntutan']."'" ;

            }
        }
        else if ($row['bulan']>$row['perubahan_tarikh'] && ($row['bulan']-$row['perubahan_tarikh'])=='1')
        {
            if($row['id'] - 1 > 0){
                $sql="SELECT tarikh_mula_tuntutan FROM tarikh_tuntutan  WHERE id= ".($row['id'] - 1);

                $tarikhmula= $conn->query($sql)->fetch_object()->tarikh_mula_tuntutan;

                $sql="SELECT tarikh_akhir_tuntutan FROM tarikh_tuntutan  WHERE id= ".($row['id']);

                $tarikhakhir= $conn->query($sql)->fetch_object()->tarikh_akhir_tuntutan;

                return "tarikh_approvement BETWEEN '".$tarikhmula."' AND '".$tarikhakhir."'";
            }
        }
        else if ($row['bulan']>$row['perubahan_tarikh'] && $row['bulan']-$row['perubahan_tarikh']>'1')
        {


            return "tarikh_approvement BETWEEN '".$row['tarikh_mula_tuntutan']."' AND '".$row['tarikh_akhir_tuntutan']."'";
        }
    }
    return "";
}

function getBelumBayar($no_staff,$bulan,$tahun){
    $conn=db();
    $sql="SELECT belum_bayar AS baki_bayar FROM salary
	           WHERE no_staff='$no_staff' AND MONTH(tarikh_bayar)='$bulan'-1 AND YEAR(tarikh_bayar)='$tahun'";
    $result=$conn->query($sql);
    return $result;
}

function getlistClaim($no_staff,$salary_id,$approve_status,$bulan,$tahun){

    $conn=db();
    $sql="SELECT  jenis_tuntutan, jumlah_tuntut, tarikh_approvement FROM claim_approve WHERE approve_status='L' AND no_pemohon='$no_staff' AND MONTH(tarikh_approvement)='$bulan' AND YEAR(tarikh_approvement)='$tahun' ";

    $result= $conn->query($sql);

    return $result;

}



function UpdateStatusSalary2($staff_salary_id,$jenis_kelulusan,$approve_by,$catatan){
    $conn=db();

    $sql=" UPDATE salary_approve
        SET jenis_kelulusan = '$jenis_kelulusan',approve_by='$approve_by',catatan='$catatan',tarikh_diluluskan=SysDate()
        WHERE staff_salary_id='$staff_salary_id'";

    $result=$conn->query($sql);

//$staff_record_id= $conn->insert_id;

//    if($jenis_kelulusan=='LULUS'){

//   $baki_cuti=$baki_cuti-$jumlah_cuti;

    //    $sql1="UPDATE staff_record SET baki_cuti=$baki_cuti
    //        WHERE  id='$staff_record_id'";


//  $result1=$conn->query($sql1);


// }
//else{

// $baki_cuti_pohon=$baki_cuti_pohon+$jumlah_cuti;

// $sql2="UPDATE staff_record SET baki_cuti_pohon='$baki_cuti_pohon'
//      WHERE  id='$staff_record_id'";


//$result2=$conn->query($sql);



//}


    return $result;


}


function getstaffImg($no_staff){
    $conn=db();
    $sql="	SELECT * FROM staff WHERE no_staff='$no_staff'";

    $result = $conn->query($sql);
    $default= $result-> fetch_assoc();
    echo '<img src="../../staffphoto/'.$default['nama_photo'].'" border="0" width="350px" height="350px"/>';

}

function addPic($photo){
    $conn=db();
    $sql = "INSERT INTO staff(photo) 
	VALUES('$photo')";
    $result = $conn->query($sql);
    return $result;
}

function updateKataLaluan($staff_id,$new_password) {
    $conn = db();
    return $conn->query("UPDATE staff SET accs_pwd = '$new_password' WHERE id='$staff_id'");
}

function revertResetPassword($staff_id, $old_password){
    $conn = db();
    return $conn->query("UPDATE staff SET accs_pwd = '$old_password' WHERE id = '$staff_id'");
}

function String2Stars($string='',$first=0,$last=0,$rep='*'){
    $begin  = substr($string,0,$first);
    $middle = str_repeat($rep,strlen(substr($string,$first,$last)));
    $end    = substr($string,$last);
    $stars  = $begin.$middle.$end;
    return $stars;
}

function getNamaPemohon($salary_id){
    $conn=db();
    $sql="SELECT sl.gaji_bulan,sl.gaji_tahun,
	st.name AS requester,stf.name AS approver
	FROM salary_approve sa
	LEFT JOIN salary sl
	ON sl.id=sa.staff_salary_id
	LEFT JOIN staff st ON st.no_staff=sa.request_id
	LEFT JOIN staff stf ON stf.no_staff=sa.approve_by
	WHERE sl.id='$salary_id'";
    $result=$conn->query($sql);
    return $result;
}


//start nabilah
function getShift($shift){
    $conn=db();
    $sql = "SELECT * FROM masa_bekerja
			    WHERE shift_code='$shift'";
    $result = $conn->query($sql);
    return $result;

}
function getAllShift(){
    $conn=db();
    $sql = "SELECT * FROM masa_bekerja ORDER BY masa_bekerja ASC";
    $result = $conn->query($sql);
    return $result;

}

function getShiftStaff($shift,$cawangan_kod,$jabatan_kod){
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

    $sql = "SELECT s.name, s.no_staff, m.description
            FROM staff s
            LEFT JOIN masa_bekerja m ON s.shift_kerja=m.shift_code
            WHERE m.shift_code='$shift' AND s.status='BEKERJA' AND s.noic IS NOT NULL $cond";
    $result = $conn->query($sql);
    return $result;
}

function getShiftKerja(){
    $conn=db();
    $sql = "SELECT * FROM masa_bekerja";
    $result = $conn->query($sql);
    return $result;
}

function getShiftStaffAll($cawangan_kod,$jabatan_kod){
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
    $sql = "SELECT s.id, s.name, s.no_staff, m.description, m.shift_code AS code_shift
	FROM staff s
	LEFT JOIN masa_bekerja m ON s.shift_kerja=m.shift_code 
	WHERE s.status='BEKERJA' AND s.noic IS NOT NULL $cond";
    $result = $conn->query($sql);
    return $result;
}

function updateShift($shift_code, $no_staff){
    $conn=db();
    $sql = "UPDATE staff SET shift_kerja='$shift_code' WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

//end nabilah
//add staf from excel
function addStaffExcel($shortcode,$noic,$nama,$username,$password,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$martial_status,$tanggungan,$gender,$pantau_kehadiran,$company_id,$cawangan_kod) {
    $conn=db();
    $no_staff=getRunning_No("no_staff",$shortcode);
    $sql1="SELECT id From staff WHERE noic='$noic' AND status='BEKERJA'";
    $checkIfExist = $conn->query($sql1);
    if($checkIfExist->num_rows == 0){

        $sql ="INSERT INTO staff(noic, name, username, accs_pwd,  phone, email, alamat_tetap, alamat_surat, umur,status, martial_status, tanggungan,gender,pantau_kehadiran,no_staff,company_id,role_id,cawangan_kod) VALUES ('$noic','$nama','$username','$password','$phone','$email','$alamat_tetap','$alamat_surat','$umur','BEKERJA','$martial_status','$tanggungan','$gender','$pantau_kehadiran','$no_staff','$company_id','STAFF','$cawangan_kod')";
        $result = $conn->query($sql) or die($conn->error);
        return $result;
    }else{
        return 0;
    }
}
//end
//start 10 09 2019
function getNamaCawanganByKod($cawangan_kod){
    $conn=db();
    $sql = "SELECT nama FROM lkp_cawangan WHERE cawangan_kod='$cawangan_kod'";
    $result = $conn->query($sql);
    return $result->fetch_object()->nama;
}
//31082020
function getLogStaffByJabatanOld($cawangan_kod,$jabatan_kod,$statact) {
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
    if ($statact=='ACTIVE') {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') $cond
	ORDER BY s.name ASC";
    } else if ($statact=='INTERN') {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id='INTERN' $cond
	ORDER BY s.name ASC";
    }
    else {
        $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status NOT IN ('BEKERJA') $cond
	ORDER BY s.name ASC";
    }
    $result = $conn->query($sql);



    return $result;
}
function getSenaraiCutiByStaff($staff_record_id){
    $conn=db();
    $sql="SELECT stc.*,jc.code,jc.desc FROM staff_total_cuti stc
			LEFT JOIN jenis_cuti jc ON stc.jenis_cuti = jc.code
			WHERE stc.staff_record_id = '$staff_record_id'";
    return $conn->query($sql);
}

function getCutiInfoByJenisCuti($id){
    $conn=db();
    $sql="SELECT stc.*,jc.code,jc.desc FROM staff_total_cuti stc
			LEFT JOIN jenis_cuti jc ON stc.jenis_cuti = jc.code
			WHERE stc.id = '$id'";
    $result=$conn->query($sql);
    return $result;
}

function getTotalcutiAL($id){
    $conn=db();
    $sql="SELECT sh.total_cuti - sh.baki_cuti AS totalal FROM staff_total_cuti sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.jenis_cuti='AL'
		AND sh.id = '$id'
		AND sh.tahun = YEAR(CURRENT_TIMESTAMP)";
    $result=$conn->query($sql);
    return $result;
}

function getTotalcutiMC($id){
    $conn=db();
    $sql="SELECT sh.total_cuti - sh.baki_cuti AS totalmc FROM staff_total_cuti sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.jenis_cuti='MC'
		AND sh.id = '$id'
		AND sh.tahun = YEAR(CURRENT_TIMESTAMP)";
    $result=$conn->query($sql);
    return $result;
}

function updateStaffCuti($id,$total_cuti,$baki_cuti,$baki_cuti_pohon){
    $conn=db();
    $sql="UPDATE staff_total_cuti SET baki_cuti = '$baki_cuti',baki_cuti_pohon='$baki_cuti_pohon',total_cuti= '$total_cuti' WHERE id='$id'";
    $result=$conn->query($sql);
    return $result;
}

function getListCutiAL($department_code,$department_sub) {
    $conn=db();

    if ($department_sub == 'HR'){
        $sql = "SELECT s.name,s.department_sub,s.noic,ss.desc AS status_name,ss.code,d.description,al.*,tc.total_cuti,tc.jenis_cuti,tc.baki_cuti,ah.approvement,ah.date_approve,ah.support,ah.approve_by,ah.support_by,sf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN staff_total_cuti tc ON tc.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff sf ON sf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.department_id='$department_code' AND tc.jenis_cuti = 'AL'  AND al.type_leave='AL'
	AND ah.approvement='APPROVE'
	ORDER BY ah.date_approve DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_hr_specialleavemessage.php';
						</script>");
    }
    $result = $conn->query($sql);

    return $result;
}
//UPDATE 8/7/2021
function getListCutiALChecked($department_code,$department_sub) {
    $conn=db();

    if ($department_sub == 'HR'){
        $sql = "SELECT s.name,s.department_sub,s.noic,ss.desc AS status_name,ss.code,d.description,al.*,tc.total_cuti,tc.jenis_cuti,tc.baki_cuti,ah.approvement,ah.date_approve,ah.support,ah.approve_by,ah.support_by,sf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN staff_total_cuti tc ON tc.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff sf ON sf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.department_id='$department_code' AND tc.jenis_cuti = 'AL'  AND al.type_leave='AL'
	AND ah.approvement='APPROVE' AND al.hr_checked = 'CHECKED'
	ORDER BY ah.date_approve DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_hr_specialleavemessage.php';
						</script>");
    }
    $result = $conn->query($sql);

    return $result;
}

function getListCutiMC($department_code) {
    $conn=db();

    $sql = "SELECT s.name,s.department_sub,s.noic,ss.desc AS status_name,ss.code,d.description,
	al.id,al.staff_record_id,al.department_id,al.date_fill,al.dic_leave,al.date_lv_from,al.date_lv_to,al.day_lv_from,al.day_lv_to,al.type_leave,al.total_lv_req,al.reason_leave,al.document_name,al.document_type,al.descrip,al.hr_checked,al.created_date,
	tc.total_cuti,tc.jenis_cuti,tc.baki_cuti,ah.approvement,ah.date_approve,ah.support,ah.approve_by,ah.support_by,sf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN staff_total_cuti tc ON tc.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff sf ON sf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.department_id='$department_code' AND tc.jenis_cuti = 'MC' AND al.type_leave='MC'
	AND ah.approvement='APPROVE'
	ORDER BY ah.date_approve DESC";
    $result = $conn->query($sql);

    return $result;
}

function getListCutiOT($department_code,$year,$leave) {
    $conn=db();

    $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,al.*,ah.approvement,ah.support FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA'
	AND s.department_id='$department_code' 
	AND al.type_leave = '$leave'
	AND YEAR(al.date_lv_from) = '$year'
	AND ah.approvement='APPROVE'
	ORDER BY al.created_date DESC"; //changed by fhumaidi on 05/07/2022
    $result = $conn->query($sql);

    return $result;
}

function getMedicalById($id){
    $conn=db();
    $sql="SELECT tm.entitle_medical, tm.baki_claim, tm.jumlah_claim FROM aims_lv_total_medical tm
			WHERE tm.id = '$id'";
    $result=$conn->query($sql);
    return $result;
}

function updateStaffmedical($id,$entitle_medical,$jumlah_claim,$baki_claim){
    $conn=db();
    $sql="UPDATE aims_lv_total_medical SET entitle_medical='$entitle_medical',baki_claim='$baki_claim',jumlah_claim='$baki_claim' WHERE id='$id'";
    $result=$conn->query($sql);
    return $result;
}

function getSenaraiMedicalByStaff($staff_record_id){
    $conn=db();
    $sql="SELECT * FROM aims_lv_total_medical
			WHERE staff_record_id = '$staff_record_id'";
    $result = $conn->query($sql);
    return $result;

}

function getDropDownMonth($selected) {
    $conn=db();
    $sql = "SELECT MONTH(date_fill), YEAR(date_fill) FROM aims_lv_form GROUP BY MONTH(date_fill) ORDER BY date_fill DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getDropDownYear($selected) {
    $conn=db();
    $sql = "SELECT  YEAR(date_lv_from) FROM aims_lv_form WHERE YEAR(date_lv_from) NOT IN ('','0','202','20') GROUP BY YEAR(date_lv_from) ORDER BY YEAR(date_lv_from) DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getListAL($department_code,$month) {
    $conn=db();


    $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,al.*,tc.total_cuti,tc.*,ah.approvement,ah.support,ah.support_by,ah.approve_by,sf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN staff_total_cuti tc ON tc.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff sf ON sf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL 
	AND s.status='BEKERJA' 
	AND s.department_id='$department_code' 
	AND tc.jenis_cuti = 'AL'  
	AND al.type_leave='AL'
	AND ah.approvement='APPROVE'
	AND MONTH(al.date_fill) = '$month'
	ORDER BY al.date_fill DESC";

    $result = $conn->query($sql);

    return $result;
}

function getListMC($department_code,$month) {
    $conn=db();

    $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,al.*,tc.total_cuti,tc.*,ah.approvement,ah.support,ah.support_by,ah.approve_by,sf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN staff_total_cuti tc ON tc.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff sf ON sf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL 
	AND s.status='BEKERJA' 
	AND s.department_id='$department_code'
	AND tc.jenis_cuti = 'MC'
	AND al.type_leave='MC'
	AND ah.approvement='APPROVE'
	AND MONTH(al.date_fill) = '$month'
	ORDER BY al.date_fill DESC";
    $result = $conn->query($sql);

    return $result;
}

function getListOTH($department_code,$month) {
    $conn=db();

    $sql = "SELECT s.*,ss.desc AS status_name,ss.code,d.description,al.*,ah.approvement,ah.support,stf.name AS pelulus FROM staff s
	LEFT JOIN status_staff ss ON ss.code=s.status
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status
	LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
	LEFT JOIN aims_lv_form al ON al.staff_record_id = sr.id
	LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
	LEFT JOIN staff stf ON stf.no_staff = ah.approve_by
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA'
	AND s.department_id='$department_code' 
	AND al.type_leave <>'MC' 
	AND al.type_leave <>'AL'
	AND ah.approvement='APPROVE'
	AND MONTH(al.date_fill) = '$month'
	ORDER BY al.date_fill DESC";
    $result = $conn->query($sql);

    return $result;
}

function gettotalcutidiambilLP($no_staff){
    $conn=db();
    $sql = "SELECT  SUM(total_lv_req) AS totallp FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.type_leave='LP'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalcutidiambilCL($no_staff){
    $conn=db();
    $sql = "SELECT  SUM(total_lv_req) AS totalcl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='CL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalcutidiambilURL($no_staff){
    $conn=db();
    $sql = "SELECT  SUM(total_lv_req) AS totalurl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='URL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalcutidiambilHL($no_staff){
    $conn=db();
    $sql = "SELECT  SUM(total_lv_req) AS totalhl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.type_leave='HL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownCompany($selected) {
    $conn=db();
    $sql = "SELECT id, code_department, description From department";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function updatePhoto($no_staff, $imageName){
    $conn=db();
    return $conn->query("UPDATE staff SET nama_photo = '$imageName' WHERE no_staff = '$no_staff'");
}

/* PIKAH EDITED ------------------------------------------------------------------------------------------------------*/

function staffProfileDefault($staff_id){
    $conn=db();
    return $conn->query("UPDATE staff SET nama_photo = 'default-image.jpg' WHERE id = '$staff_id'");
}

function getStaffNoById($staff_id){
    $conn=db();
    return $conn->query("SELECT no_staff FROM staff WHERE id = '$staff_id'")->fetch_object()->no_staff;
}

function getStaffById($staff_id){
    $conn=db();
    return $conn->query("SELECT * FROM staff WHERE id = '$staff_id'");
}

function updatePassword($id, $encryted){
    $conn=db();
    return $conn->query("UPDATE staff SET accs_pwd = '$encryted' WHERE id = '$id'");
}

/* MAKLUMAT PEKERJA --------------------------------------------------------------------------------------------------*/

function generateCompanyId($code){
    $conn=db();
    $sql = "SELECT id FROM department WHERE code_department = '$code'";
    $result = $conn->query($sql)->fetch_object()->id;

    if ($result != ''){
        return $result;
    }
    return '1';
}

function generateApprovalId($no_staff){
    $conn=db();
    $sql = "SELECT id FROM staff WHERE noic = '$no_staff'";
    $result = $conn->query($sql)->fetch_object()->id;

    if ($result != ''){
        return $result;
    }
    return '1';
}

function undoAddStaffByNoStaff($ic_number){
    $conn = db();
    $conn->query("DELETE FROM staff WHERE no_staff='$ic_number'");
    $conn->query("UPDATE running_no SET running_no = running_no-1 WHERE reference = 'no_staff'");
    return $conn->query("DELETE from staff_record WHERE no_staff='$ic_number'");
}

function icNumberIsExist($no_ic){
    $conn = db();
    $count = $conn->query("SELECT noic FROM staff WHERE noic = '$no_ic'")->num_rows;
    return $count > 0;
}

function getStaffRecordByNoStaff($no_staff){
    $conn=db();
    return $conn->query("SELECT * FROM staff_record WHERE no_staff = '$no_staff'");
}

function staffAdd($noic,$encryted,$name,$tarikh_lahir,$phone,$email,$martial_status,$tanggungan,$gender,
                  $alamat_tetap,$alamat_surat,$peranan,$unit,$bahagian,$lokasi,
                  $jum_jam_kerja,$jum_jam_break,$status,$leave_approval,
                  $pantau_kehadiran,$status_qrcode,$status_swafoto,$status_tag){
    $conn = db();
    $sql = "INSERT INTO staff (no_staff, noic, name, username, accs_pwd, phone, email, alamat_tetap, alamat_surat, umur, jawatan_code, role_id, department_id, company_id, cawangan_kod, department_sub, status, created_date, martial_status, tanggungan, photo, nama_photo, gender, pantau_kehadiran, jenis_darah, shift_kerja, leave_approval, jum_jam_kerja, jum_jam_break, status_qrcode, status_swafoto, status_tag) 
			VALUE ('$noic', '$noic', '$name', '$noic', '$encryted', '$phone', '$email', '$alamat_tetap', '$alamat_surat', '$tarikh_lahir', NULL, '$peranan', '$bahagian', '1', '$lokasi', '$unit', '$status', CURRENT_TIMESTAMP, '$martial_status', '$tanggungan', NULL, 'default-image.jpg', '$gender', '$pantau_kehadiran', NULL, 'pagi', '$leave_approval', '$jum_jam_kerja', '$jum_jam_break', '$status_qrcode', '$status_swafoto', '$status_tag')";
    $conn->query($sql);
    return $conn->insert_id;
}

function staffUpdate($staff_id, $staff_no, $name,$phone,$email,$martial_status,$tanggungan,$gender,
                     $alamat_tetap,$alamat_surat,$peranan,$unit,$bahagian,$lokasi,
                     $jum_jam_kerja,$jum_jam_break,$status,$leave_approval,
                     $pantau_kehadiran,$status_qrcode,$status_swafoto,$status_tag, $preferred_shift){
    $conn = db();
    $sql = "UPDATE staff SET no_staff = '$staff_no', name = '$name', phone = '$phone', email = '$email', alamat_tetap = '$alamat_tetap', 
                alamat_surat = '$alamat_surat', role_id = '$peranan', department_id = '$bahagian', cawangan_kod = '$lokasi', 
                department_sub = '$unit', status = '$status', martial_status = '$martial_status', tanggungan = '$tanggungan', gender = '$gender', 
                pantau_kehadiran = '$pantau_kehadiran', leave_approval = '$leave_approval', jum_jam_kerja = '$jum_jam_kerja', jum_jam_break = '$jum_jam_break', 
                status_qrcode = '$status_qrcode', status_swafoto = '$status_swafoto', status_tag = '$status_tag', preferred_shift = '$preferred_shift'
                WHERE id = '$staff_id'";
    return $conn->query($sql);
}

function staffRunningNoUpdate(){
    $conn = db();
    return $conn->query("UPDATE running_no SET running_no = running_no+1 WHERE reference = 'no_staff'");
}

function staffRecordAdd($noic,$tarikh_mula,$tarikh_akhir,$taraf_jawatan,$peranan,$unit,$bahagian,$status,$lokasi){
    $conn = db();
    $sql = "INSERT INTO staff_record (no_staff, tarikh_mula, tarikh_akhir, gaji, jawatan, taraf_jawatan, peranan, department, nama_bank, no_akaun, status, total_cuti, baki_cuti, baki_cuti_pohon, catatan, no_epf, no_socso, sah_jawatan, tarikh_sah_jawatan, rule_cuti, cawangan_kod, department_sub) 
			VALUE ('$noic', '$tarikh_mula', '$tarikh_akhir', NULL, NULL, '$taraf_jawatan', '$peranan', '$bahagian', NULL, NULL, '$status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$lokasi', '$unit')";
    $conn->query($sql);
    return $conn->insert_id;
}

function staffRecordEdit($staff_no,$tarikh_mula,$tarikh_akhir,$taraf_jawatan,$peranan,$unit,$bahagian,$status,$lokasi){
    $conn = db();
    $sql = "UPDATE staff_record SET tarikh_mula = '$tarikh_mula', tarikh_akhir = '$tarikh_akhir', taraf_jawatan = '$taraf_jawatan', 
			peranan = '$peranan', department = '$bahagian', status = '$status',cawangan_kod = '$lokasi', department_sub = '$unit' WHERE no_staff = '$staff_no'";
    return $conn->query($sql);
}

function staffMedicalAdd($record_id){
    $conn = db();
    $sql = "INSERT INTO aims_lv_total_medical (staff_record_id,entitle_medical,jumlah_claim,baki_claim,tahun) 
			VALUE ('$record_id','1000','1000','1000',YEAR(CURRENT_TIMESTAMP))";
    return $conn->query($sql);
}

/* MAKLUMAT PENDIDIKAN -----------------------------------------------------------------------------------------------*/

function getEducationListByStaffNo($staff_no){
    $conn = db();
    return $conn->query("SELECT * FROM staff_education WHERE no_staff = '$staff_no' ORDER BY tahun_akhir");
}

function getEducationListById($edu_id){
    $conn = db();
    return $conn->query("SELECT * FROM staff_education WHERE id = '$edu_id'");
}

function staffEducationAdd($staff_no,$pencapaian,$tempat,$keputusan,$tahun_mula,$tahun_akhir,$sess_id){
    $conn = db();
    $sql = "INSERT INTO staff_education (pencapaian, tempat, tahun_mula, tahun_akhir, keputusan, no_staff, updated_by, updated_at) 
			VALUE ('$pencapaian', '$tempat', '$tahun_mula', '$tahun_akhir', '$keputusan', '$staff_no','$sess_id',CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function staffEducationUpdate($edu_id,$pencapaian,$tempat,$keputusan,$tahun_mula,$tahun_akhir,$sess_id){
    $conn = db();
    $sql = "UPDATE staff_education SET pencapaian = '$pencapaian', tempat = '$tempat', tahun_mula = '$tahun_mula', 
            tahun_akhir = '$tahun_akhir', keputusan = '$keputusan', updated_at = '$sess_id', updated_by = CURRENT_TIMESTAMP
			WHERE id = '$edu_id'";
    return $conn->query($sql);
}

function staffEducationDelete($edu_id){
    $conn = db();
    return $conn->query("DELETE FROM staff_education WHERE id = '$edu_id'");
}

/* MAKLUMAT PEKERJAAN TERDAHULU --------------------------------------------------------------------------------------*/

function getExperienceList($staff_no){
    $conn = db();
    return $conn->query("SELECT * FROM staff_experience WHERE no_staff = '$staff_no'");
}

function getExperienceListById($exp_id){
    $conn = db();
    return $conn->query("SELECT * FROM staff_experience WHERE id = '$exp_id'");
}

function staffExperienceAdd($staff_no,$tempat_bekerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$sess_id){
    $conn = db();
    $sql = "INSERT INTO staff_experience (tempat_berkerja, tarikh_mula, tarikh_akhir, gaji, jawatan, peranan, no_staff, updated_by, updated_at) 
			VALUE ('$tempat_bekerja', '$tarikh_mula', '$tarikh_akhir', '$gaji', '$jawatan', '$peranan', '$staff_no','$sess_id',CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function staffExperienceUpdate($exp_id,$tempat_bekerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$sess_id){
    $conn = db();
    $sql = "UPDATE staff_experience SET tempat_berkerja = '$tempat_bekerja', tarikh_mula = '$tarikh_mula', 
			tarikh_akhir = '$tarikh_akhir', gaji = '$gaji', jawatan = '$jawatan', peranan = '$peranan', updated_by = '$sess_id', updated_at = CURRENT_TIMESTAMP
			WHERE id = '$exp_id'";
    return $conn->query($sql);
}

function staffExperienceDelete($exp_id){
    $conn = db();
    return $conn->query("DELETE FROM staff_experience WHERE id = '$exp_id'");
}

/* MAKLUMAT KEMAHIRAN ------------------------------------------------------------------------------------------------*/

function getSkillList($staff_no){
    $conn = db();
    return $conn->query("SELECT * FROM staff_skill WHERE no_staff = '$staff_no' ORDER BY id DESC");
}

function getSkillListById($skill_id){
    $conn = db();
    return $conn->query("SELECT * FROM staff_skill WHERE id = '$skill_id'");
}

function staffSkillAdd($staff_no,$skill,$level,$sess_id){
    $conn = db();
    $sql = "INSERT INTO staff_skill (skill, level, no_staff, updated_by, updated_at) VALUE ('$skill', '$level', '$staff_no','$sess_id',CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function staffSkillUpdate($skill_id,$skill,$level,$sess_id){
    $conn = db();
    $sql = "UPDATE staff_skill SET skill = '$skill', level = '$level', updated_by = '$sess_id', updated_at = CURRENT_TIMESTAMP WHERE id = '$skill_id'";
    return $conn->query($sql);
}

function staffSkillDelete($skill_id){
    $conn = db();
    return $conn->query("DELETE FROM staff_skill WHERE id = '$skill_id'");
}

/* MAKLUMAT KELUARGA -------------------------------------------------------------------------------------------------*/

function getFamilyList($staff_no){
    $conn = db();
    return $conn->query("SELECT * FROM staff_family WHERE no_staff = '$staff_no' ORDER BY id DESC");
}

function getFamilyListById($family_id){
    $conn = db();
    return $conn->query("SELECT * FROM staff_family WHERE id = '$family_id'");
}

function staffFamilyAdd($staff_no,$name,$work,$relationship,$phone,$sess_id){
    $conn = db();
    $sql = "INSERT INTO staff_family (no_staff, nama, phone, pekerjaan, hubungan, updated_by, updated_at) 
			VALUE ('$staff_no', '$name', '$phone', '$work', '$relationship','$sess_id',CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function staffFamilyUpdate($family_id,$name,$work,$relationship,$phone,$sess_id){
    $conn = db();
    $sql = "UPDATE staff_family SET nama = '$name', phone = '$phone', pekerjaan = '$work', hubungan = '$relationship', updated_by = '$sess_id', updated_at = CURRENT_TIMESTAMP 
			WHERE id = '$family_id'";
    return $conn->query($sql);
}

function staffFamilyDelete($family_id){
    $conn = db();
    return $conn->query("DELETE FROM staff_family WHERE id = '$family_id'");
}

/* MAKLUMAT REKOD JAWATAN --------------------------------------------------------------------------------------------*/

function getStaffRecordList($staff_no){
    $conn = db();
    $sql = "SELECT s.*, sr.id AS record_id, sr.tarikh_mula, sr.tarikh_akhir, sr.gaji, d.description, lc.nama AS nama_cawangan, 
       			sr.nama_bank, sr.no_akaun, sr.taraf_jawatan, dl.description AS nama_deptsub, sr.catatan FROM staff s 
			LEFT JOIN staff_record sr on sr.no_staff = s.noic
			LEFT JOIN department d on d.code_department = s.department_id
			LEFT JOIN lkp_cawangan lc on lc.cawangan_kod = s.cawangan_kod
			LEFT JOIN department_load dl ON dl.code_department = s.department_sub
			WHERE s.no_staff = '$staff_no'";
    return $conn->query($sql);
}

function getStaffRecordListById($record_id){
    $conn = db();
    return $conn->query("SELECT * FROM staff_record WHERE id = '$record_id'");
}

function staffRecordUpdate($record_id,$bank_name,$notes,$account_no,$salary){
    $conn = db();
    $sql = "UPDATE staff_record SET nama_bank = '$bank_name', no_akaun = '$account_no', gaji = '$salary', catatan = '$notes' WHERE id = '$record_id'";
    return $conn->query($sql);
}

function v02getShiftList($status = 'all'){
    $where_status = ($status == 'all') ? "" : "WHERE status = '$status'";
    $conn=db();
    $sql = "SELECT * FROM v02_workday_shift $where_status";
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

function dropdownCustomCompany(){
    $conn=db();
    $sql = "SELECT * FROM department WHERE code_department IN ('AGSHIMSB','MOCSB')";
    return $conn->query($sql);
}


