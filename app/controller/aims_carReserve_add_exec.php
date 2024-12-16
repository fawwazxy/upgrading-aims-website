<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$name = clean($_POST['name']);
	$jawatan = clean($_POST['jawatan']);
	$department_name = clean($_POST['department_name']);
	$drivername = clean($_POST['drivername']);
    $purpose = clean($_POST['purpose']);
	$destination = clean($_POST['destination']);
	$company_name = clean($_POST['company_name']);
	$car_type = clean($_POST['car_type']);
	$no_passengers = clean($_POST['no_passengers']);
	$car_plate_no = clean($_POST['car_plate_no']);
	$dep_date = clean($_POST['dep_date']);
	$dep_time = clean($_POST['dep_time']);
	$dep_milage = clean($_POST['dep_milage']);
	$return_date = clean($_POST['return_date']);
	$return_time = clean($_POST['return_time']);
	$return_milage = clean($_POST['return_milage']);
	$created_by = clean($_POST['created_by']);
	$healty_status = $_POST['healty_status'];
	$illness = $_POST['illness'];
	$taf_id = ($_POST['taf_id']);

	$result = addcarRequest($taf_id,$name,$jawatan,$department_name,$drivername,$purpose,$destination,$company_name,$car_type,$no_passengers,$car_plate_no,$dep_date,$dep_time,$dep_milage,$return_date,$return_time,$return_milage,$created_by,$healty_status,$illness);
	
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