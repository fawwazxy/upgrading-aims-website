<?php
   	include "../model/aims_access_function.php";
    
	
	//Sanitize the POST values
	
	
	$no_staff = clean($_POST['no_staff']);
	$vehicle_access = clean($_POST['vehicle_access']);
	$gl_access = clean($_POST['gl_access']);
	

	$result = addAccess($no_staff,$vehicle_access,$gl_access);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_access_form.php';
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?> 