<?php
   	include "../model/aims_billing_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$client_id = clean($_POST['client_id']);
	$company_id = clean($_POST['company_id']);
	$job_no = clean($_POST['job_no']);
	$job_description = clean($_POST['job_description']);
	$tin_no = clean($_POST['tin_no']);
	$amount_to_invoice = clean($_POST['amount_to_invoice']);
	$sst = clean($_POST['sst']);
	$total_invoice = clean($_POST['total_invoice']);
	$created_by = clean($_POST['created_by']);
	$date_prepared = clean($_POST['date_prepared']);
	$vessel = clean($_POST['vessel']);
	$term_of_payment = clean($_POST['term_of_payment']);
	$date_movement = clean($_POST['date_movement']);
	$amount_credit_note = clean($_POST['amount_credit_note']);
	$amount_debit_note=clean($_POST['amount_debit_note']);
	$po_no = clean($_POST['po_no']);
	$do_no = clean($_POST['do_no']);


	$result = addBilling($client_id,$company_id,$job_no,$job_description,$tin_no,$amount_to_invoice,$sst, str_replace(',','',$total_invoice), $created_by,$date_prepared,$vessel,$term_of_payment,$date_movement,$amount_credit_note,$amount_debit_note,$po_no,$do_no);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_billing_list.php';
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed ");
	}
	
?>