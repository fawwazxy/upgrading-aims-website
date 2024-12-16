<?php
   	include "../model/aims_invoice_functions.php";

	$id= clean($_GET['id']);
	$billing_id= clean($_GET['billing_id']);
	
		$result = deleteInvoice($id,$billing_id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_senarai_invoice.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>