<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	
	$status= clean($_POST['status']);
	$id = clean($_POST['id']);

	$result = getcarsummonupdate1($status,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{

		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carSummon_list.php';
            </script>");
		//header("location: ../view/aims_carSummon_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>