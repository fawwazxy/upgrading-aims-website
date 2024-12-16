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
	
	function getTotalMedicalPending($status,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(a.id) AS total,a.medical_id,b.created_date
		FROM aims_lv_approve_medical a
		LEFT JOIN aims_lv_medical b ON a.medical_id = b.id
		WHERE ver_status = '$status'
		AND YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalMedicalByStatus($status,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(a.id) AS total,a.medical_id,b.created_date
		FROM aims_lv_approve_medical a
		LEFT JOIN aims_lv_medical b ON a.medical_id = b.id
		WHERE ver_status IN ('$status','COMPLETE','DISAPPROVED') 
		AND YEAR(created_date) = '$tahun'
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalAmountPending($status,$tahun){
		$conn=db();
		$sql = "SELECT SUM(a.total_claim) AS total,b.ver_status
		FROM aims_lv_medical a
		LEFT JOIN aims_lv_approve_medical b ON a.id = b.medical_id
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
		WHERE ver_status IN ('$status', 'COMPLETE','DISAPPROVED')
		AND YEAR(created_date) = '$tahun'
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
	
	function getAnalisaTotalJualanByYear($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(total_claim),0) AS total_amount_year FROM aims_lv_medical
   			WHERE DATE_FORMAT(created_date,'%Y') = '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

	function getAnalisaTotalJualanByMonth($value) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(total_claim),0) AS total_amount_month FROM aims_lv_medical
				WHERE DATE_FORMAT(created_date,'%Y%m') = '$value'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return 'RM'.$row[0];
		}else{
			return '';
		}
	}
	
	function getAnalisaTotalJualanByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(total_claim),0) AS total_amount_week FROM aims_lv_medical
   			WHERE DATE_FORMAT(created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

	function getAnalisaTotalJualanByDay($date) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(total_claim),0) AS total_amount_day FROM aims_lv_medical
				WHERE DATE(created_date)='$date'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return 'RM'.$row[0];
		}else{
			return '';
		}
	}

$conn->close();

?>