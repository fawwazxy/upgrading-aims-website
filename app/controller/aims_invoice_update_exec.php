<?php
	include "../model/aims_invoice_functions.php";

$id=clean($_POST['id']);
		$date_received=clean($_POST['date_received']);
		$invoice_no=clean($_POST['invoice_no']);
		$total_invoice=clean($_POST['total_invoice']);
		$paid=clean($_POST['paid']);
		$unpaid=clean($_POST['unpaid']);
		$date_submit=clean($_POST['date_submit']);
		$submission=clean($_POST['submission']);
		$ses_no_received=clean($_POST['ses_no_received']);
		$term_of_payment=clean($_POST['term_of_payment']);
		$remarks=clean($_POST['remarks']);
		$status=clean($_POST['status']);
		$updated_by=clean($_POST['updated_by']);
		$duedate=clean($_POST['duedate']);
		$aging=clean($_POST['aging']);
		
		

		$result =  editInvoice($id,$date_received,$invoice_no,$date_submit,$submission,$ses_no_received,$term_of_payment,$remarks,$updated_by,$duedate,$aging,  str_replace(',','',$total_invoice), str_replace(',','',$paid) ,   str_replace(',','',$unpaid));
		if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.history.go(-2);
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
	
	
	?>