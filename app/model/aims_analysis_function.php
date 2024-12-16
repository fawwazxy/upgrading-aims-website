<?php

require '../../lib/db/connection.php';
$action=clean($_POST['action']);

	date_default_timezone_set("Asia/Kuala_Lumpur");


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
	function getTotalBilling($tahun){
		$conn=db();
		$sql = "SELECT COUNT(id) AS total FROM aims_billing
		WHERE YEAR(date_prepared) = '$tahun'
		ORDER BY date_prepared DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalInvoice($tahun){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_invoice
	WHERE YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalReceivedPayment($payment_status,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE payment_status IN ('2', '1') AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalBillingSubmitted($tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE payment_status = '0' AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalInvoiceSubmitted($tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE payment_status = '0' AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalPaidClient($paid,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE paid >=0.01 AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalUnpaidClient($unpaid,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE unpaid >=0.01 AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalAmount($tahun){
		$conn=db();
		$sql = "SELECT SUM(total_invoice) as total FROM aims_billing
		WHERE YEAR(date_prepared) = '$tahun'
		ORDER BY date_prepared DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalInvoiceById($date_year){
		$conn=db();
		$sql = "SELECT SUM(total_invoice) as total FROM aims_invoice i
				INNER JOIN aims_billing b ON b.id = i.billing_id
				INNER JOIN aims_company c ON c.company_id = b.company_id
		WHERE c.company_id = '$company_id'";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalBillingByStatus($status,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_billing
		WHERE status_billing = '$status' AND YEAR(date_prepared) = '$tahun'
		ORDER BY date_prepared DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalTimely($status,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE status = 'TIMELY' AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalOverdue($status,$tahun){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice
		WHERE status = 'OVERDUE' AND YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalAmountInvoice($tahun){
		$conn=db();
		$sql = "SELECT SUM(total_invoice) AS total FROM aims_invoice
		WHERE  YEAR(date_submit) = '$tahun'
		ORDER BY date_submit DESC";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}

	function getTotalPending($status){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice WHERE status = '$status'";
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
					WHERE MONTH(date_submit)='$month'
					ORDER BY date_submit DESC";
			$result = $conn->query($sql);
			return $result;
	}
	
	function getAnalisaTotalJualanByYear($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(total_invoice),0) AS total_amount_year FROM aims_billing
   			WHERE DATE_FORMAT(date_prepared,'%Y') = '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

	function getAnalisaTotalJualanByMonth($value) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(total_invoice),0) AS total_amount_month FROM aims_billing
				WHERE DATE_FORMAT(date_prepared,'%Y%m') = '$value'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			
			 return $row[0];
		}else{
			return '';
		}
	}
	
	function getAnalisaTotalJualanByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(total_invoice),0) AS total_amount_week FROM aims_billing
   			WHERE DATE_FORMAT(date_prepared,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

	function getAnalisaTotalJualanByDay($date) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(total_invoice),0) AS total_amount_day FROM aims_billing
				WHERE DATE(date_prepared)='$date'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return $row[0];
		}else{
			return '';
		}
	}

	function getTotalUnpaid($tahun){
	$conn=db();
	$sql = "SELECT SUM(unpaid) AS total FROM aims_invoice 
	WHERE unpaid>=0.01 AND YEAR(date_submit) = '$tahun'
	ORDER BY date_submit DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalPaid($tahun){
	$conn=db();
	$sql = "SELECT SUM(paid) AS total FROM aims_invoice 
	WHERE paid>=0.01 AND YEAR(date_submit) = '$tahun'
	ORDER BY date_submit DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getPendingClient($year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,a.client_phone_no,b.payment_status,b.invoice_no,b.duedate,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE b.payment_status = '0' AND YEAR(b.date_submit) = '$year'
		ORDER BY b.duedate ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getReceivedClient($year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,a.client_phone_no,b.payment_status,b.invoice_no,b.duedate,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE b.payment_status = '1' AND YEAR(b.date_submit) = '$year'
		ORDER BY b.duedate ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getClosedClient($year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,a.client_phone_no,b.payment_status,b.invoice_no,b.duedate,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE b.payment_status = '3' AND YEAR(b.date_submit) = '$year'
		ORDER BY b.duedate ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getInvoiceListClosed() {
		$conn=db();
		$sql = "SELECT inv.*,a.job_no,c.client_name FROM aims_invoice inv
		LEFT JOIN aims_billing a ON inv.billing_id = a.id
		LEFT JOIN aims_client c ON a.client_id = c.client_id
		WHERE inv.payment_status='2'
		ORDER BY duedate DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getDropDownYear($selected) {
		$conn=db();
		
		 $sql = "SELECT YEAR(date_prepared) AS year FROM aims_billing
		 GROUP BY year ORDER BY year DESC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	function getInvoiceReport($company_id,$year){
		$conn=db();
		
		$sql = "SELECT i.*,SUM(i.total_invoice) AS total_invoice,SUM(i.paid) AS paid,SUM(i.unpaid) AS unpaid,
				b.company_id, c.company_id, l.* FROM aims_invoice i
				INNER JOIN aims_billing b ON b.id = i.billing_id
				INNER JOIN aims_company c ON c.company_id = b.company_id
				INNER JOIN aims_client l ON l.client_id = b.client_id
				WHERE c.company_id = '$company_id' AND YEAR(i.date_submit)= '$year' GROUP BY client_name ORDER BY total_invoice ";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getInvoiceUnpaid($client_id,$year){
		$conn=db();
		
		$sql = "SELECT i.*, SUM(i.unpaid) AS unpaid,
				b.client_id, c.client_id, l.* FROM aims_invoice i
				INNER JOIN aims_billing b ON b.id = i.billing_id
				INNER JOIN aims_client c ON c.client_id = b.client_id
				INNER JOIN aims_client l ON l.client_id = b.client_id
				WHERE i.unpaid >=0.01 AND YEAR(i.date_submit)= '$year' GROUP BY c.client_name,MONTH(i.date_submit)  ORDER BY client_name ";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getCompany($company_id){
		$conn=db();
		
		$sql = "SELECT company_name FROM aims_company 
				WHERE company_status = '1' AND company_id= '$company_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getPaidClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,a.client_phone_no,b.invoice_no,b.duedate, b.paid,b.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE b.paid >=0.01 AND YEAR(b.date_submit)= '$year'
		ORDER BY b.duedate ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getUnpaidClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,a.client_phone_no,b.invoice_no,b.duedate, b.unpaid,b.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE b.unpaid >=0.01 AND YEAR(b.date_submit)= '$year'
		ORDER BY b.duedate ASC";
		$result = $conn->query($sql);
		return $result;
	}
	

$conn->close();

?>