<?php
   	include "../model/aims_invoice_functions.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$billing_id = clean($_POST['billing_id']);
	$job_no = clean($_POST['job_no']);
	$date_received = clean($_POST['date_received']);
	$invoice_no = clean($_POST['invoice_no']);
	$date_submit = clean($_POST['date_submit']);
	$submission = clean($_POST['submission']);
	$ses_no_received = clean($_POST['ses_no_received']);
	$term_of_payment = clean($_POST['term_of_payment']);
	$date_received_payment = clean($_POST['date_received_payment']);
	$payment_status = clean($_POST['payment_status']);
	$remarks = clean($_POST['remarks']);
	$created_by = clean($_POST['created_by']);
	$aging = clean($_POST['aging']);
	$total_invoice = clean($_POST['total_invoice']);
	$unpaid = clean($_POST['unpaid']);
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
				
					
					$myDateTime3 = DateTime::createFromFormat('Y-m-d', $date_submit);
					$datesubmit2 = $myDateTime3->format('Y-m-d');
					
					$duedate1 = date("Y-m-d", strtotime($datesubmit2.' + '.$term_of_payment.' days'));
					
					$myDateTime2 = DateTime::createFromFormat('Y-m-d', $duedate1);
					$duedate = $myDateTime2->format('Y-m-d');
	
	

	$result = addInvoice($billing_id,$job_no, $date_received,$invoice_no,$date_submit,$submission,$ses_no_received,$term_of_payment,$date_received_payment,$payment_status,$remarks,$created_by,$duedate,$aging, str_replace(',','',$total_invoice), $unpaid);
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_senarai_invoice.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>