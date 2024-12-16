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
	$amount_credit_note = clean($_POST['amount_credit_note']);
	$amount_debit_note = clean($_POST['amount_debit_note']);
	$total_invoice = clean($_POST['total_invoice']);
	$updated_by = clean($_POST['updated_by']);
	$term_of_payment = clean($_POST['term_of_payment']);
	$po_no = clean($_POST['po_no']);
	$do_no = clean($_POST['do_no']);
	$id = clean($_POST['id']);

	$result = updateBilling($client_id,$company_id,$job_no,$job_description,$tin_no,$amount_to_invoice,$sst,$amount_credit_note,$amount_debit_note,str_replace(',','',$total_invoice),$updated_by,$term_of_payment,$po_no,$do_no,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
		window.history.back();
            window.location.href='../view/aims_billing_list.php';
            </script>");
		//header("location: ../view/aims_billing_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>