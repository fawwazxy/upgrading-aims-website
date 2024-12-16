<?php

require '../../lib/db/connection.php';
$action=clean($_POST['action']);


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
		$sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress, c.tel as ctel,c.email as cemail,c.logo_filename AS logo_filename FROM sys_setting s 
		LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
	return $result;
	}

	function getTotalAmount($tahun){
		$conn=db();
		$sql = "SELECT SUM(total_claim) as total FROM aims_lv_medical
		WHERE YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalMedical($tahun){
		$conn=db();
		$sql = "SELECT COUNT(id) AS total FROM aims_lv_medical
		WHERE YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalMedicalByStatus($status,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(a.id) AS total,a.medical_id,b.created_date
		FROM aims_lv_approve_medical a
		LEFT JOIN aims_lv_medical b ON a.medical_id = b.id
		WHERE ver_status = '$status' AND YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalAmountByStatus($status,$tahun){
		$conn=db();
		$sql = "SELECT SUM(a.total_claim) AS total,b.ver_status
		FROM aims_lv_medical a
		LEFT JOIN aims_lv_approve_medical b ON a.id = b.medical_id
		WHERE ver_status = '$status' AND YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getDropDownMonth($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) AS bulan FROM aims_billing
			GROUP BY bulan
			ORDER BY bulan DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

	function getTotalAmountbyMonth($month) {
			$conn=db();
			$sql = "SELECT *,DATE_FORMAT(created_date,'%d-%m-%Y') AS created_date_2 FROM aims_invoice
					WHERE MONTH(created_date)='$month'
					ORDER BY created_date DESC";
			$result = $conn->query($sql);
			return $result;
	}
	
	function getAnalisaTotalLvByYear($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
			LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
			WHERE DATE_FORMAT(a.date_lv_from,'%Y') = '$value'
			AND b.approvement IN ('APPROVE','COMPLETE')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return ''.$row[0];
	}else{
		return '';
	}
}

	function getAnalisaTotalJualanByMonth($value) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$value'
				AND b.approvement IN ('APPROVE','COMPLETE')";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return ''.$row[0];
		}else{
			return '';
		}
	}
	
	function getAnalisaTotalCutiByMonthAL($month) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$month'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'AL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;		
	}
	
	function getAnalisaTotalCutiByMonthMC($month) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$month'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'MC'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;		
	}
	
	function getAnalisaTotalCutiByMonthCL($month) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$month'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'CL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;		
	}
	
	function getAnalisaTotalCutiByMonthLP($month) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$month'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'LP'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;		
	}
	
	function getAnalisaTotalCutiByMonthURL($month) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE_FORMAT(a.date_lv_from,'%Y%m') = '$month'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'URL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;		
	}
	

	function getAnalisaTotalJualanByDay($date) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return ''.$row[0];
		}else{
			return '';
		}
	}
	
	function getAnalisaTotalCutiByDayAL($date) {
		$conn=db();
		$sql = "SELECT COUNT(a.id) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'AL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;
	}
	
	function getAnalisaTotalCutiByDayMC($date) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'MC'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;
	}
	
	function getAnalisaTotalCutiByDayCL($date) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'CL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;
	}
	
	function getAnalisaTotalCutiByDayLP($date) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'LP'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;
	}
	
	function getAnalisaTotalCutiByDayURL($date) {
		$conn=db();
		$sql = "SELECT IFNULL(COUNT(a.id),0) AS total_amount_year FROM aims_lv_form a
				LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
				WHERE DATE(a.date_lv_from)='$date'
				AND b.approvement IN ('APPROVE','COMPLETE')
				AND a.type_leave = 'URL'";
		$result = $conn->query($sql);
		return $result->fetch_object()->total_amount_year;
	}

$conn->close();

?>