<?php
   	include "../model/aims_ot_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$no_staff = clean($_POST['no_staff']);
	$staff_name = clean($_POST['staff_name']);
	$hod_name = clean($_POST['hod_name']);
	$otp_date = clean($_POST['otp_date']);
	$code_department = clean($_POST['code_department']);
	$otp_description = clean($_POST['otp_description']);
	

	
	
	
	$result = addOtPermission($no_staff,$staff_name,$hod_name,$code_department,$otp_date,$otp_description);
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_otpermission_list.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>