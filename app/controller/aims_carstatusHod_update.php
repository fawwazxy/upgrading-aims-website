<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_POST['id']);
	$approve_by = clean($_POST['approve_by']);
	$sbu_hod_app = clean($_POST['sbu_hod_app']);
	
	//$id = ($_POST['id']);

	$result = updatecarbyHod($approve_by,$sbu_hod_app,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_car_hod_list.php?sbu_hod_app=$sbu_hod_app';
            </script>");
		//header("location: ../view/aims_hod_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>