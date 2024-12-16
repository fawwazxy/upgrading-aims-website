<?php
   	include "../model/aims_ot_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$working_hours = clean($_POST['working_hours']);
	$hod_remark = clean($_POST['hod_remark']);
	$id = clean($_POST['id']);
	
	
	$result = updateOtHod($working_hours,$hod_remark,$id);
	
	
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