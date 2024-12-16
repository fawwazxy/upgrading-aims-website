<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$code_company = clean($_POST['code_company']);
	$company_name = clean($_POST['company_name']);
	$status = clean($_POST['status']);
	

	$result = updateClientCompany($code_company,$company_name,$status,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_client_company.php';
            </script>");
		//header("location: ../view/aims_billing_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>