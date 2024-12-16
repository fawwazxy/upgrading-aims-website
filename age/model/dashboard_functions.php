<?php

	require '../../lib/db/connection.php';
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
	function getAnalisaJumlahHariBekerja($nokp) {
		$conn = db();
		$sql = "SELECT COUNT(*) AS jumlah_hari_bekerja FROM tarikh_bekerja tb 
				WHERE tb.status = '1' 
				AND tb.sys_id = (SELECT c.sys_id FROM company c LEFT JOIN staff s ON c.id = s.company_id WHERE s.noic = '$nokp' AND s.status = 'BEKERJA')
				AND DATE_FORMAT(tb.tarikh,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
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
	
	//noti for expired
	function countexpa1() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 < CURDATE()
				AND CURDATE() >= date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA1'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countexpa2() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 < CURDATE()
				AND CURDATE() >= date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA2'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countexpa3() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 < CURDATE()
				AND CURDATE() >= date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA3'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countexpa4() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 < CURDATE()
				AND CURDATE() >= date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA4'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countexpa5() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 < CURDATE()
				AND CURDATE() >= date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA5'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	//noti for 1 month exp
	
	function countonea1() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 <= CURDATE()
				AND CURDATE() < date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA1'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countonea2() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 <= CURDATE()
				AND CURDATE() < date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA2'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countonea3() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 <= CURDATE()
				AND CURDATE() < date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA3'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countonea4() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 <= CURDATE()
				AND CURDATE() < date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA4'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countonea5() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp1 <= CURDATE()
				AND CURDATE() < date_in
				AND CURDATE() > date_exp
				AND vessel_code ='AA5'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	//expired 2 month
	
	function countwoa1() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp <= CURDATE()
				AND CURDATE() < date_exp1
				AND vessel_code ='AA1'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countwoa2() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp <= CURDATE()
				AND CURDATE() < date_exp1
				AND vessel_code ='AA2'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countwoa3() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp <= CURDATE()
				AND CURDATE() < date_exp1
				AND vessel_code ='AA3'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countwoa4() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp <= CURDATE()
				AND CURDATE() < date_exp1
				AND vessel_code ='AA4'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countwoa5() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE date_exp <= CURDATE()
				AND CURDATE() < date_exp1
				AND vessel_code ='AA5'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	// noti active
	
	function countaca1() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE CURDATE() < date_in
				AND CURDATE() < date_exp
				AND CURDATE() < date_exp1
				AND vessel_code ='AA1'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countaca2() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE CURDATE() < date_in
				AND CURDATE() < date_exp
				AND CURDATE() < date_exp1
				AND vessel_code ='AA2'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countaca3() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE CURDATE() < date_in
				AND CURDATE() < date_exp
				AND CURDATE() < date_exp1
				AND vessel_code ='AA3'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countaca4() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE CURDATE() < date_in
				AND CURDATE() < date_exp
				AND CURDATE() < date_exp1
				AND vessel_code ='AA4'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	function countaca5() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_vesselcertificate
				WHERE CURDATE() < date_in
				AND CURDATE() < date_exp
				AND CURDATE() < date_exp1
				AND vessel_code ='AA5'";
		$result = $conn->query($sql);
		return $result->fetch_object()->jumlah;
	}
	
	//notification verified ssr n ssa
	function verifiedssr() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_operationlist
				WHERE verified_status = '0'
				AND status ='1'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function verifiedssa() {
		$conn=db();
		$sql = "SELECT COUNT(id) AS jumlah FROM aims_ssa
				WHERE ver_status = '0'
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
	
	$conn->close();
	
?>