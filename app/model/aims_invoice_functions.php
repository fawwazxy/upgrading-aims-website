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
		$sql = "SELECT s.*,c.* FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}


	function getInvoiceList() {
		$conn=db();
		$sql = "SELECT inv.*,a.job_no,c.client_name FROM aims_invoice inv
		LEFT JOIN aims_billing a ON inv.billing_id = a.id
		LEFT JOIN aims_client c ON a.client_id = c.client_id
		ORDER BY created_date DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getInvoiceById($id) {
		$conn=db();
	    $sql = "SELECT inv.*,a.job_no,c.client_name FROM aims_invoice inv LEFT JOIN aims_billing a ON inv.billing_id = a.id
	    LEFT JOIN aims_client c ON a.client_id = c.client_id
	    WHERE inv.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addInvoice($billing_id,$date_received,$invoice_no,$date_submit,$submission,$ses_no_received,$term_of_payment,$date_received_payment,$note,$created_by,$duedate) {
		$conn=db();
		$sql = "INSERT into aims_invoice (billing_id,date_received, invoice_no, date_submit, submission, ses_no_received, term_of_payment, date_received_payment, note, created_by, duedate) values('$billing_id','$date_received','$invoice_no','$date_submit','$submission','$ses_no_received','$term_of_payment','$date_received_payment','$note','$created_by','$duedate')";
		$result = $conn->query($sql);
		
		$sql2 = "UPDATE aims_billing LEFT JOIN aims_invoice ON aims_billing.id = aims_invoice.billing_id SET aims_billing.status_billing = '1' WHERE 
		aims_billing.id = '$billing_id'";
	$result = $conn->query($sql2);
	return $result;
	}
	
	function deleteInvoice($id,$billing_id){
	    $conn=db();
		 $sql = "DELETE FROM aims_invoice WHERE id='$id'";
		 $result = $conn->query($sql);
		 
		 $sql2 = "UPDATE aims_billing LEFT JOIN aims_invoice ON aims_billing.id = aims_invoice.billing_id SET aims_billing.status_billing = '2' WHERE 
		aims_billing.id = '$billing_id'";
		 $result = $conn->query($sql2);
	    
	    return $result;
	}
	
	function editInvoice($id,$date_received,$invoice_no,$date_submit,$submission,$ses_no_received,$term_of_payment,$date_received_payment,$payment_status,$note,$status,$updated_by,$duedate) {
	$conn=db();
	$sql = "UPDATE aims_invoice SET date_received='$date_received', invoice_no='$invoice_no', date_submit='$date_submit', submission='$submission', ses_no_received='$ses_no_received', term_of_payment ='$term_of_payment', date_received_payment = '$date_received_payment', payment_status='$payment_status', note = '$note', status = '$status', updated_by = '$updated_by', updated_date = CURRENT_TIMESTAMP, duedate = '$duedate' WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
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
	
	function getDueDate($term_of_payment,$date_submit){
		$conn=db();
		 $sql = "INSERT into aims_invoice (due_date) values (DATEADD(DAY, '$term_of_payment', '$date_submit'))";
		 
		 $result2 = $conn->query($sql);
		 
		 return $result2;
	}

	function changeBillingStatus($billing_id){
		$conn=db();
		$sql = "UPDATE aims_billing LEFT JOIN aims_invoice ON aims_billing.id = aims_invoice.billing_id SET aims_billing.status_billing = '1'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTotalInvoiceSubmitted(){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_invoice WHERE payment_status = '0'
		GROUP BY YEAR(created_date)
		ORDER BY created_date DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	function getTotalReceivedPayment($payment_status){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_invoice WHERE payment_status = '$payment_status'
		GROUP BY YEAR(created_date)
		ORDER BY created_date DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
	}
	
	
	function getTotalInvoice(){
	$conn=db();
	$sql = "SELECT count(id) as total FROM aims_invoice
		GROUP BY YEAR(created_date)
		ORDER BY created_date DESC";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
   }

	function getInvoiceListPrint(){
		$conn=db();
		$sql = "SELECT inv.*,a.job_no,a.tin_no,a.job_description,a.total_amount,a.client_id,b.client_name FROM aims_invoice inv 
				LEFT JOIN aims_billing a ON inv.billing_id = a.id LEFT JOIN aims_client b ON a.client_id = b.client_id 
				ORDER BY inv.date_submit ASC";
		$result = $conn->query($sql);
	return $result;
	}
	
	function getInvoiceListClientPrint(){
		$conn=db();
		$sql = "SELECT bil.id,b.client_name,a.date_submit FROM aims_billing bil LEFT JOIN aims_client b ON bil.client_id = b.client_id 
		LEFT JOIN aims_invoice a ON bil.id = a.billing_id ORDER BY a.date_submit ASC";
		$result = $conn->query($sql);
		return $result;
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
	
	$conn->close();
	
?>