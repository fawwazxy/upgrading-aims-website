<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	
	$name_passenger = clean($_POST['name_passenger']);
	$jawatan = clean($_POST['jawatan']);
	$description = clean($_POST['description']);	
	$id = clean($_POST['id']);
	
	//$id = ($_POST['id']);

	$result = updatecarpassenger($name_passenger,$jawatan,$description,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carpassenger_list.php';
            </script>");
		//header("location: ../view/aims_carReserve_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>