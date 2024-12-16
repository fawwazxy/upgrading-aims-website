<?php
   	include "../model/aims_billing_function.php";

	$id= clean($_GET['id']);
	
		$result = deleteBilling($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_billing_list.php';
            </script>");
		//header("location: ../view/aims_billing_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>