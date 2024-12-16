<?php
require '../../lib/db/connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
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

function getStaffPhotoUrl($id){
    $conn=db();
    $sql="SELECT nama_photo FROM staff WHERE id = '$id'";
    return $conn->query($sql)->fetch_object()->nama_photo;
}

function getCompanyDetails($sys_id) {
    $conn=db();
    $sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
    $result = $conn->query($sql);
    return $result;
}

function login($username,$password) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password' AND status='BEKERJA'";
    $result = $conn->query($sql);
    return $result;
}

function getAnnouncementList(){
    $conn=db();
    $sql = "SELECT * FROM announcements WHERE CURRENT_DATE >= start_date AND CURRENT_DATE <= end_date";
    return $conn->query($sql);
}

function getLogUser($com_id) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
    $result = $conn->query($sql);
    return $result;
}

//tugasan peribadi begin
function getBilTaskByCategory($id_category,$nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='$id_category' AND pt.assigned_to='$nokp' ";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getBilTaskDoneByCurDate($nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getBilTaskDoneByCurWeek($nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getBilTaskDoneByCurMonth($nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getBilTaskDoneByCurYear($nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getBilTaskOverdue($nokp) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.tarikh_tamat < CURRENT_TIMESTAMP  AND pt.assigned_to='$nokp' AND pt.id_category NOT IN('DONE')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}
//tugasan peribadi end

//kalendar aktiviti begin
function getActivitiesComing($no_staff){
    $conn=db();
    $sql = "SELECT COUNT(*) AS bilangan FROM  events 
				WHERE id_staff LIKE '%$no_staff%' AND DATE_FORMAT(start,'%Y%m%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d')
				AND STATUS NOT IN ('BATAL','SELESAI')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bilangan;
}
//kalendar aktiviti end

//bilangan support begin
function getCountByStatus($no_staff){
    $conn=db();
    if($no_staff==''){
        $sql = "SELECT COUNT(*) AS nilai FROM support s
                    WHERE s.status_tindakan='BH' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
    }else{
        $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE sd.developer='$no_staff' AND s.status_tindakan='DP' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
    }
    $result=$conn->query($sql)->fetch_object()->nilai;
    return $result;
}
//bilangan support end

//kehadiran peribadi begin
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

function getAnalisaKehadiran($nokp,$status_kehadiran) {
    $conn = db();
    $sql = "SELECT COUNT(*) AS kehadiran FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL 
				AND s.status = 'BEKERJA' 
				AND k.nokp_staff = '$nokp' 
				AND k.status_kehadiran = '$status_kehadiran'
				AND DATE_FORMAT(k.created_date,'%Y-%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->kehadiran;
}
//kehadiran peribadi end
//bulan bekerja
function getBulanKehadiran($no_staff,$thn) {
    $conn = db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%b') AS bulan,DATE_FORMAT(tarikh,'%m') AS bln FROM tarikh_bekerja WHERE DATE_FORMAT(tarikh,'%Y') ='$thn' AND no_staff='$no_staff'
		GROUP BY bulan
		ORDER BY bln ASC";
    $result = $conn->query($sql) or die($conn->error);
    return $result;
}
function getAnalisaJumlahHariBekerjaTahunan($nokp,$no_staff,$thn,$bln) {
    $conn = db();
    $sql = "SELECT COUNT(*) AS jumlah_hari_bekerja FROM tarikh_bekerja tb 
			WHERE tb.status = '1' 
			AND tb.sys_id = (SELECT c.id FROM company c LEFT JOIN staff s ON c.id = s.company_id WHERE s.noic = '$nokp' AND s.status = 'BEKERJA')
			AND DATE_FORMAT(tb.tarikh,'%Y-%m') = CONCAT('$thn','-','$bln') AND tb.no_staff='$no_staff'";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->jumlah_hari_bekerja;
}

function getAnalisaJumlahKehadiranTahunan($nokp_staff,$thn,$bln) {
    $conn = db();
    $sql = "SELECT COUNT(*) AS jumlah_kehadiran FROM kehadiran k
		        LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE k.nokp_staff = '$nokp_staff' AND s.status = 'BEKERJA'
				AND DATE_FORMAT(k.created_date,'%Y-%m') = CONCAT('$thn','-','$bln')";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->jumlah_kehadiran;
}

function getAnalisaJumlahKehadiranTepat($nokp_staff,$thn,$bln) {
    $conn = db();
    $sql = "SELECT COUNT(*) AS kehadiran FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL 
				AND s.status = 'BEKERJA' 
				AND k.nokp_staff = '$nokp_staff' 
				AND (k.status_kehadiran = 'AWAL' OR k.status_kehadiran = 'TEPAT')
				AND DATE_FORMAT(k.created_date,'%Y-%m')=CONCAT('$thn','-','$bln')";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->kehadiran;
}

function getAnalisaJumlahKehadiranLewat($nokp_staff,$thn,$bln) {
    $conn = db();
    $sql = "SELECT COUNT(*) AS kehadiran FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL 
				AND s.status = 'BEKERJA' 
				AND k.nokp_staff = '$nokp_staff' 
				AND k.status_kehadiran = 'LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m')=CONCAT('$thn','-','$bln')";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->kehadiran;
}

// 	noti leave approval

//HOD
function gettotalbaharucuti($department_sub,$no_staff) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub='$department_sub'
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.no_staff<>'$no_staff'
		AND s.department_sub <> 'OPERATION-AGMHESB'";
    $result = $conn->query($sql);
    return $result;
}

//OPERATION MANAGER
function gettotalbaharucutiOperationManager($no_staff) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.leave_approval='$no_staff'
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.no_staff <> '$no_staff'
		AND s.department_sub <> 'OPERATION-AGMHESB'";
    $result = $conn->query($sql);
    return $result;
}

//HOD HR
function gettotalbaharucutihod1($name,$department_sub) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    if($role_id == 'HOD' && $department_sub == 'HR'){
        $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('HR-SEA','HR')
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    }
    $result = $conn->query($sql);
    return $result;
}

// HOD AGMA
function gettotalbaharucutihod2($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

// HOD COMMERCIAL
function gettotalbaharucutihod4($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('COMMERCIAL', 'COMMERCIAL-AVSB')
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    return $conn->query($sql);
}

// 	HOD TECHOPERATION
function gettotalbaharucutihod3($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approvement,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND b.approvement= 'IN PROGRESS'
		AND b.support= 'APPROVE'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//leave_approvel
function gettotalbaharucuti2($leave_approval,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS kira FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.leave_approval='$leave_approval'
		AND b.support= 'APPROVE'
		AND b.approvement = 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//approve leave end

// 	support

//HOD finacc n operation AGMHESB n normal support
function gettotalbaharucuti1($department_sub,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub='$department_sub'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}
// 		AND s.department_sub<>'OPERATION-AVSB'

//kak ida support
function gettotalbaharucutiHRAVSB($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('HR','SECRETARY-AVSB')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//staff finacc n operation AGMHESB
function gettotalbaharucutifiop($department_sub,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub='$department_sub'
		AND s.role_id = 'HOD'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

// EXECUTIVE & SUPERVISOR AVSB 
function gettotalbaharucuti3($department_sub,$name) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    if ($role_id == 'EXECUTIVEAVSB'){
        $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'";
    }
    else if ($role_id == 'SUPERVISORAVSB'){
        $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id = 'EXECUTIVEAVSB'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    }
    $result = $conn->query($sql);
    return $result;
}

// EXECUTIVE & SUPERVISOR TKSB 
// 	function gettotalbaharucuti4($name) {
// 		$conn=db();
// 		$sql = "SELECT role_id FROM staff WHERE name='$name'";
//         $role_id=$conn->query($sql)->fetch_object()->role_id;

//         if ($role_id == 'EXECUTIVETKSB'){
// 		$sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
// 		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
// 		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
// 		LEFT JOIN staff s ON s.no_staff = sr.no_staff
// 		WHERE s.department_sub IN ('OPERATION-TKSB')
// 		AND b.support= 'IN PROGRESS'";
// 	    }
// 	    else if ($role_id == 'SUPERVISORTKSB'){
// 	    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
// 		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
// 		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
// 		LEFT JOIN staff s ON s.no_staff = sr.no_staff
// 		WHERE s.role_id = 'EXECUTIVETKSB'
// 		AND b.support= 'IN PROGRESS'
// 		AND s.name <> '$name'";   
// 	    }
// 		$result = $conn->query($sql);
// 		return $result;
// 	}

// executiveTKSB
function gettotalbaharucutiEXTKSB($department_sub,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('OPERATION-TKSB')
		AND s.role_id = 'MANAGING-DIRECTOR'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'";
    $result = $conn->query($sql);
    return $result;
}

// SUPERVISORTKSB
function gettotalbaharucutiSVTKSB($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id = 'EXECUTIVETKSB'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

// 	HR AGMA
function gettotalbaharucuti5($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('HR-AGMA','OPERATION-AGMSB')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

// HOD HR
function gettotalbaharucuti6($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('ECOFFICE', 'HR')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

// CAPTAIN	
function gettotalbaharucuti7() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE b.support= 'IN PROGRESS'
		AND s.no_staff = '810415035497'
		AND s.status <> 'BERHENTI'";
    $result = $conn->query($sql);
    return $result;
}

// 	MANAGING-DIRECTOR
function gettotalbaharucuti8() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'";
    $result = $conn->query($sql);
    return $result;
}

// 	EXECUTIVE-DIRECTOR
function gettotalbaharucuti9() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id = 'MANAGING-DIRECTOR'
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'";
    $result = $conn->query($sql);
    return $result;
}

//support nazri
function gettotalbaharucuti10() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals, b.support,s.department_sub FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		AND b.support= 'IN PROGRESS'
		AND s.status <> 'BERHENTI'";
    $result = $conn->query($sql);
    return $result;
}

//support syafiq hisyamuddin
function gettotalbaharucuti11(){
    $conn=db();
    $sql="SELECT COUNT(ha.id) as totals FROM approve_holiday ha 
        	    LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id 
        	    LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
        	    LEFT JOIN staff s ON s.no_staff= sr.no_staff 
        	    LEFT JOIN role r ON sr.peranan=r.code 
        	    WHERE ha.support<>'PENDING' AND ha.support = 'IN PROGRESS' 
        	    AND s.status = 'BEKERJA' 
        	    AND s.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB') 
        	    AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')";
    return $conn->query($sql);
}

//noti inout

function gettotalbaharucutiinout($department_sub,$no_staff) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub='$department_sub'
		AND b.approve= 'PENDING'
		AND b.verified= 'APPROVE'
		AND s.no_staff<>'$no_staff'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucutihod1inout($name,$department_sub) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    if($role_id=='HOD' && $department_sub=='HR'){
        $sql = "SELECT COUNT(a.id) AS total, b.approve,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('HR-SEA','HR')
		AND b.approve= 'PENDING'
		AND b.verified= 'APPROVE'
		AND s.name <> '$name'";
    }
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucutihod2inout($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND b.approve= 'PENDING'
		AND b.verified= 'APPROVE'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti1inout($department_sub,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub='$department_sub'
		AND s.department_sub<>'OPERATION-AVSB'
		AND b.verified= 'PENDING'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti2inout($leave_approval,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.leave_approval='$leave_approval'
		AND b.verified= 'APPROVE'
		AND b.approve = 'PENDING'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//executive inout noti
function gettotalbaharucuti3inout($department_sub,$name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE  b.verified= 'PENDING'
		AND s.no_staff IN ('640508035251','940417115584')
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//supervisor inout noti
function gettotalbaharucuti4inout($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
		AND b.verified= 'PENDING'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti5inout($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('HR-AGMA','OPERATION-AGMSB')
		AND b.verified= 'PENDING'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti6inout($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('ECOFFICE', 'HR','MARKETING&BUSINESS-DEV')
		AND b.verified= 'PENDING'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti7inout() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE b.verified= 'PENDING'
		AND s.no_staff = '810415035497'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti8inout() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id = 'EXECUTIVE-DIRECTOR'
		AND b.verified= 'PENDING'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti9inout() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.role_id = 'MANAGING-DIRECTOR'
		AND b.verified= 'PENDING'";
    $result = $conn->query($sql);
    return $result;
}

function gettotalbaharucuti10inout() {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS total, b.approve,b.verified,s.department_sub FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		AND b.verified= 'PENDING'";
    $result = $conn->query($sql);
    return $result;
}

//noti special leave

function gettotalbaharucutiSpecial($name) {
    $conn=db();
    $sql = "SELECT COUNT(a.id) AS totals FROM aims_lv_form a
		LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.no_staff = sr.no_staff
		WHERE b.support= 'TIADA'
		AND b.approvement='IN PROGRESS'
		AND s.name <> '$name'";
    $result = $conn->query($sql);
    return $result;
}

//NOTIFICATION INOUT VERIFY
function getaims_verified_approvelisitbaharu($department_sub,$name){
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ( $role_id == 'SUPERVISORAVSB' ) {

        $sql = "SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
		AND d.role_id = 'EXECUTIVETKSB'
		AND d.name <> '$name'
		ORDER BY a.date_mohon DESC";

    }

    else if ( $role_id == 'EXECUTIVEAVSB' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ( $role_id == 'SUPERVISORTKSB' ) {

        $sql = "SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
		AND d.role_id = 'EXECUTIVETKSB'
		AND d.name <> '$name'
		ORDER BY a.date_mohon DESC";

    }

    else if ( $role_id == 'EXECUTIVETKSB' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.department_sub IN ('OPERATION-TKSB')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ( $role_id == 'EXECUTIVE-DIRECTOR' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.role_id = 'MANAGING-DIRECTOR'
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ( $role_id == 'MANAGING-DIRECTOR' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ( $role_id == 'HOD' && $department_sub == 'HR' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND (d.department_sub = 'ECOFFICE' OR d.no_staff ='911011115100')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ( $department_sub == 'FINACC' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
        AND d.status = 'BEKERJA'
		AND d.role_id='HOD'
		AND d.department_sub = 'FINACC '
		AND d.name <> '$name'
        ORDER BY a.date_mohon DESC";
    }

    else if ( $department_sub == 'OPERATION-AGMHESB' && ( $role_id == 'STAFF' || $role_id == 'CONTRACT')){
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
        AND d.status = 'BEKERJA'
		AND d.role_id='HOD'
		AND d.department_sub = 'OPERATION-AGMHESB '
		AND d.name <> '$name'
        ORDER BY a.date_mohon DESC";
    }

    else if ( $department_sub == 'HR-AGMA' ) {
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
    }

    else if ($name == 'MOHD TARMIZI BIN MEJAM'){
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.no_staff = '810415035497'
              ORDER BY a.date_mohon DESC";

    }

    else if ($no_staff == '940331025617'){
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY a.date_mohon DESC";

    }

    else if ($no_staff == '911011115100'){
        $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.department_sub IN ('HR','SECRETARY-AVSB')
              ORDER BY a.date_mohon DESC";

    }

    else {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
		AND d.status = 'BEKERJA'
		AND d.department_sub='$department_sub'
		AND d.department_sub <> 'OPERATION-AGMSB'
		AND d.department_sub <> 'MANAGEMENT'
		AND d.department_sub <>'MOORING-GANG'
		AND d.department_sub <>'PILOT-BOAT'
		AND d.department_sub <>'OPERATION-AVSB'
		AND d.name <> '$name'
		ORDER BY a.date_mohon DESC";
    }
    $result = $conn->query($sql);
    return $result;
}

//NOTIFICATION APPROVE INOUT
/*function getaims_approvelistbaharu($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  if($role_id == 'HOD' && $department_sub == 'FINACC'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'FINACC'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHSB'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'OPERATION-AGMHSB'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('HR', 'HR-SEA', 'MARKETING&BUSINESS-DEV')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub <> 'FINACC'
		AND d.department_sub <> 'OPERATION-AGMHESB'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else{
		  
		  $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.leave_approval = '$leave_approval'
		ORDER BY a.date_mohon DESC";
        
	  }
	  $result=$conn->query($sql);
       return $result; 
  } */

//NOTIFICATION TRAVEL FORM
//VERIFY TAF
function getNotiPemohonTravelBaharu($department_sub,$name){
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ( $role_id == 'MANAGING-DIRECTOR' ) {
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND (s.role_id IN ('OPERATIONMANAGER','HOC') OR s.department_sub = 'SECRETARY-AVSB')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }

    else if ( $role_id == 'OPERATIONMANAGER' ) {
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND t.department_id IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB',
			  'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','LOGISTIC')
			  AND s.name <> '$name'
			  AND s.no_staff <> '901118115427'
              ORDER BY t.created_date DESC";
    }

    else if ( $role_id == 'HOC' ) {
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.department_id = 'TKSB'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }

    else if ( $role_id == 'ASSISTANT-MANAGER' ) {
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.no_staff = '901118115427'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }


    else if ( $role_id == 'HOD' && $department_sub == 'HR') {

        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id IN ('ECOFFICE', 'HR','HR-SEA')
			  AND s.role_id IN ('STAFF','CONTRACT','INTERN')
              AND s.name <> '$name'
              ORDER BY t.created_date DESC";

    }

    //noic itu adalah milik fazrol bunker
    else if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.name <> '$name'
			  AND (t.department_id IN ('OPERATION-AGMSB', 'HR-AGMA')
			  OR t.no_staff = '910619115673')
			  AND s.department_id <> 'SYSTEM'
			  ORDER BY t.created_date DESC";

    }

    //utk personal staff yg perlu verify
    //ayie support pilot n mooring-gang
    else if ($no_staff == '940331025617'){
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY t.created_date DESC";

    }
    //fazrol staff biasa verify bunker team
    else if ($no_staff == '910619115673'){
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id = 'OPERATION-BUNKER'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";

    }

    //03-08-21 Verification assistant EnAlias
    else if ($no_staff == '810415035497'){
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id = 'MARKETING&BUSINESS-DEV'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";

    }

    else if($role_id == 'HOD'){
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND t.department_id = '$department_sub'
			  AND t.department_id <> 'OPERATION-AGMSB'
			  AND t.department_id <> 'MANAGEMENT'
			  AND t.department_id <> 'MOORING-GANG'
			  AND t.department_id <> 'OPERATION-BUNKER'
		      AND t.department_id <> 'PILOT-BOAT'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }



    $result=$conn->query($sql);
    return $result;
}

//VERIFY BY CEO TAF
function getNotiPemohonTravelBaharuCeo($department_sub,$name){
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
        $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
                  LEFT JOIN staff s ON s.no_staff = t.no_staff
                  WHERE t.hod_approval<>'APPROVED'
                  AND t.hod_approval = 'PENDING'
                  AND s.status = 'BEKERJA'
    			  AND s.role_id IN ('HOD','MANAGER','CFO')
    			  AND s.name <> '$name'
                  ORDER BY t.created_date DESC";
    }



    $result=$conn->query($sql);
    return $result;
}

//APPROVEMENT BY CEO/EC
function getTravelNotiBaharuCeo($department_sub,$name) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;


    if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
        $sql = "SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }

    else if ( $name == 'AMINUDIN BIN MAT YUSOF' ){
        $sql = "SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
    }



    $result = $conn->query($sql);
    return $result;
}

// procurement approve ssr n ssa

function approveprossr() {
    $conn=db();
    $sql = "SELECT COUNT(id) AS jumlah FROM aims_operationlist
				WHERE app_pro_status = '0'
				AND approved_status = '1'
				AND verified_status <> '0'
				AND status ='1'";
    $result = $conn->query($sql);
    return $result;
}

function approveprossa() {
    $conn=db();
    $sql = "SELECT COUNT(id) AS jumlah FROM aims_ssa
				WHERE proc_status = '0'
				AND app_status = '1'
				AND ver_status <> '0'
				AND status ='1'";
    $result = $conn->query($sql);
    return $result;
}

//notification approve ssr n ssa

function approvessr() {
    $conn=db();
    $sql = "SELECT COUNT(id) AS jumlah FROM aims_operationlist
				WHERE approved_status = '0'
				AND verified_status <> '0'
				AND status ='1'";
    $result = $conn->query($sql);
    return $result;
}

function approvessa() {
    $conn=db();
    $sql = "SELECT COUNT(id) AS jumlah FROM aims_ssa
				WHERE app_status = '0'
				AND ver_status <> '0'
				AND status ='1'";
    $result = $conn->query($sql);
    return $result;
}


//NOTOFICATION OVERTIME

//OT PERMISSION APPROVED VIEW
function notiOtPermission($department_sub,$leave_approval){
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;


    if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub = 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";

    }

    else if( $role_id == 'MANAGING-DIRECTOR' ) {
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff IN ('860620295410','850126115526','930128016820','690615115252')
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
    }
    //Operation manager
    else if( $role_id == 'OPERATIONMANAGER' ) {
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND (b.leave_approval = '$leave_approval' OR b.no_staff IN ('INDEEP0311'))
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
    }
// 		AND (b.department_sub IN ('OPERATION-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))

    //otp kak rini approved
    else if( $role_id == 'HOC' ) {
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_id = 'TKSB'
		AND b.no_staff NOT IN ('$leave_approval','901118115427')
		ORDER BY otp.created_date DESC";
    }

    //otp assistant manager approved   IC tu ic syahin commercial tksb
    else if( $role_id == 'ASSISTANT-MANAGER' ) {
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff = '901118115427'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
    }

    //en alias
    else if ($leave_approval == '810415035497'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
        AND b.department_sub = 'MARKETING&BUSINESS-DEV'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";

    }

    //otpermission ceo approve
    else if($leave_approval == '751206035485'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER','OPERATIONMANAGER','HOC')
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";

    }

    else if($role_id == 'CFO'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD')
		AND b.department_sub = 'FINACC'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";

    }

    else if($role_id == 'HOD' && $department_sub == 'HR'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
		ORDER BY otp.created_date DESC";

    }

    else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY otp.created_date DESC";

    }

    else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY otp.created_date DESC";

    }

    else if($role_id == 'HOD'){
        $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub='$department_sub'
		AND b.no_staff <> '$leave_approval'
		AND b.no_staff <> 'INDEEP0311'
		AND b.department_sub <> 'HR'
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.department_sub <> 'TECHOPERATION'
		AND b.department_sub <> 'PILOT-BOAT'
		AND b.department_sub <> 'MOORING-GANG'
		ORDER BY otp.created_date DESC";

    }

    else{

        /*	  $sql="SELECT COUNT(otp.id) AS total
            FROM aims_ot_permission otp
            LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
            LEFT JOIN staff b ON b.no_staff = otp.no_staff
            LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
            WHERE a.approved_status='PENDING'
            AND a.approved_status <> 'APPROVED'
            AND b.leave_approval = '$leave_approval'
            ORDER BY otp.created_date DESC";
        */
    }
    $result=$conn->query($sql);
    return $result;
}

//noti verify ot
function notiOtForHod($department_sub,$leave_approval) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;


    //cfo verify ot form
    if($role_id == 'CFO'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'FINACC' AND s.no_staff <> 'INDEEP0311'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    else if( $role_id == 'MANAGING-DIRECTOR' ) {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff IN ('860620295410','850126115526','930128016820', '690615115252')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    else if( $role_id == 'OPERATIONMANAGER' ) {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND (s.leave_approval = '$leave_approval' OR s.no_staff IN ('INDEEP0311'))
			AND s.no_staff NOT IN ('$leave_approval','901118115427')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    /*	else if( $role_id == 'HOC' ) {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
            FROM staff s
            LEFT JOIN staff_record st ON s.no_staff = st.no_staff
            LEFT JOIN aims_ot a ON a.staff_record_id = st.id
            LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
            WHERE ap.verify_status = 'PENDING'
            AND ap.verify_status <> 'VERIFIED'
            AND (s.department_sub IN ('OPERATION-TKSB','QR&D-TKSB') OR s.no_staff = '901118115427')
            AND s.no_staff <> '$leave_approval'
            GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
        } */

    //en alias
    else if ($leave_approval == '810415035497'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
            AND s.department_sub = 'MARKETING&BUSINESS-DEV'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";

    }

    else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    //ot form ceo verify
    else if($leave_approval == '751206035485'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    else if($role_id == 'HOD' && $department_sub == 'HR'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('HR', 'HR-SEA')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";

    }

    else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";

    }

    else if($role_id == 'HOD'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = '$department_sub'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub <> 'HR'
			AND s.department_sub <> 'FINACC'
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.department_sub <> 'TECHOPERATION'
			AND s.department_sub <> 'PILOT-BOAT'
			AND s.department_sub <> 'MOORING-GANG'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
    }

    else{
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.leave_approval = '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";

    }

    $result = $conn->query($sql);
    return $result;
}

//noti review ot
function notiOtHrNew($department_code,$department_sub) {
    $conn=db();

    if ( $department_sub == 'HR' ) {
        $sql = "SELECT COUNT(s.id) AS total
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'PENDING'
			ORDER BY a.created_date DESC";
    }
    else{
    }

    $result = $conn->query($sql);
    return $result;
}

//noti approve ot
function notiOtForCeo($company_id,$leave_approval) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;


    //ceo approved ot form
    if($leave_approval == '751206035485'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.review_status = 'REVIEWED' 
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND s.no_staff <> '$leave_approval'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')) aims_ot";
    }
    //chairman
    else if($leave_approval == '660512115105'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.review_status = 'REVIEWED'
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '000701110342')
			AND s.no_staff <> '$leave_approval') aims_ot";
    }

    $result = $conn->query($sql);
    return $result;
}

//claimVerify notification

function notiClaimforVerify($leave_approval,$department_sub) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')) aims_others_claim";
    }

    else if ( $role_id == 'HOD' && $department_sub == 'HR') {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('HR', 'HR-SEA')) aims_others_claim";
    }

    else if ( $leave_approval == '860620295410') {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND (s.department_sub IN ('OPERATION-TKSB', 'QR&D') OR s.no_staff = '941003115183')) aims_others_claim";
    }

    else if ( $role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')) aims_others_claim";
    }

    else if ( $role_id == 'HOD' && $department_sub == 'COMMERCIAL') {
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('COMMERCIAL', 'COMMERCIAL-AVSB')) aims_others_claim";
    }

    else if ($role_id == 'OPERATIONMANAGER'){
        $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.leave_approval = '$leave_approval') aims_others_claim";
    }

    else if ($role_id == 'HOD'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub = '$department_sub'
	        AND s.no_staff <> '$leave_approval'
			AND s.department_sub NOT IN (
			'FINACC', 'TECHOPERATION', 'PILOT-BOAT','MOORING-GANG',
			'OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER',
			'HR', 'HR-SEA', 'COMMERCIAL', 'COMMERCIAL-AVSB'))
			aims_others_claim";
    }

    //hj verified
    else if ($leave_approval == '660512115105'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.role_id IN ('SUPERADMIN')) aims_others_claim";
    }

    //capt verified
    else if ($leave_approval == '751206035485'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.role_id IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')) aims_others_claim";
    }

    else {
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
	        WHERE ap.hod_review_status = 'PENDING'
			AND s.leave_approval = '$leave_approval'
			AND s.no_staff !='$leave_approval'
			ORDER BY a.date_created DESC) aims_others_claim";
    }

    $result = $conn->query($sql);
    return $result;
}

//claim for HR Reviewed


function  notiClaimforReview() {
    $conn=db();

    $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'PENDING') aims_others_claim";

    $result = $conn->query($sql);
    return $result;
}

//claim approvement capt n haji

function notiClaimforApprove($leave_approval){
    $conn=db();

    //haji
    if ($leave_approval == '660512115105'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.no_staff = '000701110342')
			AND s.no_staff != '660512115105') aims_others_claim";
    }

    //capt
    else if ($leave_approval == '751206035485'){
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')
			AND s.no_staff !='000701110342'
			AND s.no_staff != '751206035485') aims_others_claim";
    }

    else {
        $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND (s.no_staff != '000701110342'
			OR s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO'))
			AND s.no_staff != '751206035485') aims_others_claim";
    }

    $result = $conn->query($sql);
    return $result;
}

//Transport notification

function getcarRequestHodBaharu($department_sub,$name) {
    $conn=db();
    $sql = "SELECT role_id FROM staff WHERE name='$name'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'HR') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('HR', 'HR-SEA')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'CORPADMIN') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('IT', 'CORPADMIN')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $role_id == 'CFO' ) {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'FINACC'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '751206035485' ) {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.role_id = 'HOD'
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '660512115105' ) {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }


    else if ( $role_id == 'HOD' ) {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = '$department_sub'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
    }

    else if ( $role_id == 'HODAGM' ) {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'OPERATION-AGMSB'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
    }

    else{
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.leave_approval = '$no_staff'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
    }


    $result = $conn->query($sql);
    return $result;
}

//Transport notification

function getcarRequestpic($name) {
    $conn=db();
    $sql = "SELECT a.vehicle_access FROM aims_access a
        LEFT JOIN staff s ON a.no_staff = s.no_staff
        WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ($vehicle_access == '1') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		WHERE c.app_status = 'PENDING'
		AND (b.car_pic = '$name' OR b.car_pic2 = '$name')
		AND a.sbu_hod_app = 'APPROVE'";
    }
    $result = $conn->query($sql);
    return $result;
}

function getcarRequestAdmin($name) {
    $conn=db();
    $sql = "SELECT a.vehicle_access FROM aims_access a
        LEFT JOIN staff s ON a.no_staff = s.no_staff
        WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;

    $sql = "SELECT no_staff FROM staff WHERE name='$name'";
    $no_staff=$conn->query($sql)->fetch_object()->no_staff;

    if ($vehicle_access == '2') {
        $sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
        LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		WHERE c.app_status = 'PENDING'
		AND a.sbu_hod_app = 'APPROVE'";
    }

    $result = $conn->query($sql);
    return $result;
}

function programRegisterAddOrUpdate($id, $staff_id, $description){
    $conn=db();
    if ($id != ''){
        $sql = "UPDATE program_register SET description = '$description' WHERE id = '$id'";
    }else{
        $sql = "INSERT INTO program_register (staff_id, description, created_at) VALUE ('$staff_id', '$description', CURRENT_TIMESTAMP)";
    }

    return $conn->query($sql) or die($conn->error);
}

function getProgramRegistered($staff_id = null){
    $conn=db();
    $where = ($staff_id != null) ? "WHERE staff_id = '$staff_id'" : "";

    $sql="SELECT p.*, s.name, s.no_staff, s.department_id, s.department_sub, s.phone, s.email, s.cawangan_kod
            FROM program_register p
            LEFT JOIN staff s ON s.id = p.staff_id $where
            ORDER BY p.created_at DESC";
    return $conn->query($sql);
}

function countRegisteredUser(){
    $conn=db();
    $sql="SELECT COUNT(id) as total FROM program_register";
    return $conn->query($sql)->fetch_object()->total;
}

function getCompanyName($department_id){
    $conn=db();
    $sql="SELECT description FROM department WHERE code_department = '$department_id'";
    return $conn->query($sql)->fetch_object()->description;
}

function isBirthday($staff_id, $today){
    $conn=db();
    $sql="SELECT count(id) as exist FROM staff WHERE id = '$staff_id' AND umur LIKE '%$today%'";
    return $conn->query($sql)->fetch_object()->exist > 0;
}

function getStaffsBornToday($today){
    $conn=db();
    $sql="SELECT name,department_sub from staff WHERE umur LIKE '%$today%'";
    return $conn->query($sql);
}

/*Updated at 13062023*/
function getStaffById($id){
    $conn=db();
    return $conn->query("SELECT * FROM staff WHERE id = '$id'");
}
function updateEmail($id,$email,$phone_no){
    $conn=db();
    return $conn->query("UPDATE staff SET email = '$email', phone = '$phone_no' WHERE id = '$id'");
}