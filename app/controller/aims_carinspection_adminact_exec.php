<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$month = clean($_POST['month']);
	$admin_action = clean($_POST['admin_action']);
	$costing = clean($_POST['costing']);
	$description = clean($_POST['description']);

	$result =adminact($admin_action,$costing,$description,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carinspection_list_admin.php?month=$month';
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>