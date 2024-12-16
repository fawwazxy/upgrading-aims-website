<?php
   	include "../model/aims_billing_function.php";
	
	$id= clean($_GET['id']);
	
	$result = SubmitBilling($id);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
			echo ("<script LANGUAGE='JavaScript'>
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