<?php
   	include "../model/aims_ot_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	
	$hod_name = clean($_POST['hod_name']);
	$otp_date = clean($_POST['otp_date']);
	$otp_description = clean($_POST['otp_description']);
	$id = clean($_POST['id']);
	

	
	
	
	$result = updateOtPermission($hod_name,$otp_date,$otp_description,$id);
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.history.back();
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>