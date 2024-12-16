<?php
	include "../model/aims_invoice_functions.php";

$id=clean($_POST['id']);
		$date_received_payment=clean($_POST['date_received_payment']);
		$status=clean($_POST['status']);
		$payment_status=clean($_POST['payment_status']);
		
		
		$result =  editPaymentStatusInvoice($id,$date_received_payment,$status,$payment_status);
		if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_senarai_invoice.php';
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
	
	
	?>