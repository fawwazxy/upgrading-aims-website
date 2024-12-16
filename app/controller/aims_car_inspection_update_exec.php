<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$status_incep = clean($_POST['status_incep']);
	$car_plate_no = clean($_POST['car_plate_no']);
	$dep_date = clean($_POST['dep_date']);
    $fuel = clean($_POST['fuel']);
	$hd_vehicle = ($_POST['hd_vehicle']);
	$exterior_car = ($_POST['exterior_car']);
	$comment1 = clean($_POST['comment1']);
	$interior_car = ($_POST['interior_car']);
	$comment = clean($_POST['comment']);
	$chk=implode(',',$hd_vehicle);
	$chk1=implode(',',$exterior_car);
	$chk2=implode(',',$interior_car);
	$id = ($_POST['id']);
	$reserve_id = ($_POST['reserve_id']);

	$result = updatecarinspection($reserve_id,$status_incep,$car_plate_no,$dep_date,$fuel,$chk,$chk1,$comment1,$chk2,$comment,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{

		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carinspection_list.php';
            </script>");
		//header("location: ../view/aims_carinspection_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>