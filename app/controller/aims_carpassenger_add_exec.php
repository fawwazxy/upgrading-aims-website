<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$reserve_id = clean($_POST['reserve_id']);
	$name = clean($_POST['name']);
	$dep_date = clean($_POST['dep_date']);
    $purpose = clean($_POST['purpose']);
	$car_plate_no = clean($_POST['car_plate_no']);
	$name_passenger = clean($_POST['name_passenger']);
	$jawatan = clean($_POST['jawatan']);
	$description = clean($_POST['description']);	
	
	
	//$id = ($_POST['id']);

	$result = addpassenger($reserve_id,$name,$dep_date,$purpose,$car_plate_no,$name_passenger,$jawatan,$description);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carReserve_list.php';
            </script>");
		//header("location: ../view/aims_carReserve_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>