<?php
   	include "../model/aims_ot_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	
	$approved_by = clean($_POST['approved_by']);
	$approved_status = clean($_POST['approved_status']);
	$id = clean($_POST['id']);
	
	
	$result = approveOtPermission($id,$approved_by,$approved_status);
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_otpermission_approve.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>