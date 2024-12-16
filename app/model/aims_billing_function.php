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
		$sql = "SELECT s.*,c.*,c.logo as clogo, c.logo_filename AS logo_filename FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}


	function getBillingList($year,$month,$client_name,$department_sub) {
		$conn=db();
		$department_id = $_SESSION['SESS_DEPARTMENT'];
	if ( $department_sub == 'COMMERCIAL' || $department_id == 'SYSTEM'){
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='0' $cond2
		$cond $cond3 ORDER BY bil.date_prepared DESC";
	}
	else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_billing_specialleavemessage.php';
						</script>");
	}
				
				
		$result = $conn->query($sql);
		return $result;
	}
	
		function getBillingListSubmitted($year,$month,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='4' $cond2
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getBillingListProcessed($year,$month,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='1' $cond2
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
	function getBillingListDelete($year,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='2'
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
		
	function getBillingListClosed($year,$month,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='3' $cond2
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getBillingList1($year,$month,$client_name,$department_sub) {
		$conn=db();
		$department_id = $_SESSION['SESS_DEPARTMENT'];
		if ( $department_sub == 'FINACC' || $department_id == 'SYSTEM'){
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='4' $cond2
		$cond $cond3 ORDER BY bil.date_prepared DESC";}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_invoice_specialleavemessage.php';
						</script>");
		}		
				
		$result = $conn->query($sql);
		return $result;
	}
	
	function getBillingListProcessed2($year,$month,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='1' $cond2
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
	function getBillingListDelete3($year,$client_name,$department_sub) {
		$conn=db();
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='2'
				$cond ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
		
	function getBillingListClosed4($year,$month,$client_name,$department_sub) {
		$conn=db();
		if($year=="0"){
		$cond3="";
		}else { 
		$cond3="AND YEAR(bil.date_prepared)='$year'";
		}
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND bil.client_id= '$client_name'";
		}
		if($month=="0"){
		$cond2="";
		}else { 
		$cond2="AND MONTH(bil.date_prepared)='$month'";
		}
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				WHERE bil.status_billing='3' $cond2
				$cond $cond3 ORDER BY bil.date_prepared DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getBillingById($id) {
		$conn=db();
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id
				WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addBilling($client_id,$company_id,$job_no,$job_description,$tin_no,$amount_to_invoice,$sst,$total_invoice,$created_by,$date_prepared,$vessel,$term_of_payment,$date_movement,$amount_credit_note,$amount_debit_note,$po_no,$do_no) {
		$conn=db();
		$sql = "INSERT into aims_billing (client_id, company_id, job_no, job_description, tin_no, amount_to_invoice, sst, total_invoice, created_by, date_prepared, vessel, term_of_payment, date_movement, amount_credit_note, amount_debit_note, po_no, do_no) values('$client_id','$company_id', '$job_no', '$job_description', '$tin_no', '$amount_to_invoice', '$sst', '$total_invoice', '$created_by', '$date_prepared', '$vessel', '$term_of_payment', '$date_movement', '$amount_credit_note', '$amount_debit_note', '$po_no', '$do_no')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateBilling($client_id,$company_id,$job_no,$job_description,$tin_no,$amount_to_invoice,$sst,$amount_credit_note,$amount_debit_note,$total_invoice,$updated_by,$term_of_payment,$po_no,$do_no, $id) {
		$conn=db();
		$sql = "UPDATE aims_billing SET client_id = '$client_id', company_id = '$company_id', job_no = '$job_no', job_description = '$job_description', tin_no = '$tin_no', amount_to_invoice = '$amount_to_invoice', sst = '$sst', amount_credit_note = '$amount_credit_note', amount_debit_note='$amount_debit_note',total_invoice = '$total_invoice', updated_by = '$updated_by', po_no='$po_no', do_no='$do_no', updated_date = CURRENT_TIMESTAMP, term_of_payment='$term_of_payment' WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function SubmitBilling($id){
    $conn=db();
    $sql="UPDATE aims_billing SET status_billing= '4 ' , created_date = CURRENT_TIMESTAMP
          WHERE id = '$id'";
    $result=$conn->query($sql);
    return $result; 
  }
	
	function deleteBilling($id){
	    $conn=db();
		 $sql = "DELETE FROM aims_billing WHERE id='$id'";
		 $result = $conn->query($sql);
	    
	    return $result;
	}
	
	function getDropDownBilling($selected) {
  	$conn=db();
  	$sql = "SELECT s.no_staff, CONCAT(no_staff,' - ',NAME),s.role_id FROM staff s
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
	
	function getDropDownClient($selected) {
		$conn=db();
		 $sql = "SELECT client_id,client_name FROM aims_client WHERE client_status = '1'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	function getDropDownCompany($selected) {
		$conn=db();
		 $sql = "SELECT company_id,company_name FROM aims_company WHERE company_status = '1'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}
	
	function getDropDownMonthInvoice($selected) {
		$conn=db();		
		$sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	function getBillingStatus($selected) {
		$conn=db();
		 $sql = "SELECT id,billing_status FROM aims_billing WHERE billing_status = '1'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
		function getDropDownPayment($selected) {
		$conn=db();
		 $sql = "SELECT days,description FROM aims_invoice_due ORDER BY description";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}

	function getTotalBilling($year){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_billing
		WHERE YEAR(date_prepared) = '$year'";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalInvoice($year){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_billing
		WHERE YEAR(date_prepared) = '$year' AND status_billing IN ('4', '1','3')";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalBillingByStatus($status,$year){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_billing WHERE status_billing = '$status'
		AND YEAR(date_prepared) = '$year'";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalBillingSubmitted(){
		$conn=db();
		$sql = "SELECT count(id) as total FROM aims_invoice WHERE payment_status = '0'";
		$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getBillingListPrint(){
		$conn=db();
		$sql = "SELECT bil.*,a.client_name,b.company_name FROM aims_billing bil
				LEFT JOIN aims_client a ON bil.client_id = a.client_id
				LEFT JOIN aims_company b ON bil.company_id = b.company_id 
				ORDER BY bil.created_date ASC";
		$result = $conn->query($sql);
	return $result;
	}
	
	function getNewClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,bil.job_no,a.client_phone_no,bil.status_billing,b.invoice_no,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE bil.status_billing = '0' AND YEAR(date_prepared) = '$year'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getSubmittedClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,bil.job_no,a.client_phone_no,bil.status_billing,b.invoice_no,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE bil.status_billing = '4' AND YEAR(date_prepared) = '$year' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getProcessedClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,bil.job_no,a.client_phone_no,bil.status_billing,b.invoice_no,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE bil.status_billing = '1' AND YEAR(date_prepared) = '$year' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getClosedClient($id,$year){
		$conn=db();
		$sql = "SELECT bil.client_id,a.client_name,bil.job_no,a.client_phone_no,bil.status_billing,b.invoice_no,bil.total_invoice
		FROM aims_billing bil
		LEFT JOIN aims_client a ON bil.client_id = a.client_id
		LEFT JOIN aims_invoice b ON bil.id = b.billing_id
		WHERE bil.status_billing = '3' AND YEAR(date_prepared) = '$year'";
		$result = $conn->query($sql);
		return $result;
	}
	
function getSales($client_name,$year,$month){
		$conn=db();
		if($client_name=="0"){
		$cond="";
		}else { 
		$cond="AND b.client_id= '$client_name'";
		}
		if($year=="0"){
			$cond2=" ";
		}else{
		$cond2 ="AND YEAR(b.date_prepared) = '$year'";
		}
		if($month=="0"){
			$cond3=" ";
		}else{
		$cond3 ="AND MONTH(b.date_prepared) = '$month'";
		}
		$sql = "SELECT b.*, SUM(b.total_invoice) AS total_invoice,
				c.client_id , l.*FROM aims_billing b
				INNER JOIN aims_client c ON c.client_id = b.client_id
				INNER JOIN aims_client l ON l.client_id = b.client_id
				WHERE b.total_invoice >=0.01 $cond $cond2 $cond3 GROUP BY b.job_no ORDER BY client_name ";
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
	$conn->close();
	
?>