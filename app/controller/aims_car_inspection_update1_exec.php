<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$department_id = $_POST['department_id'];
	$car_plate_no = clean($_POST['car_plate_no']);
	$dep_date = clean($_POST['dep_date']);
    $fuel = clean($_POST['fuel']);
	$hd_vehicle = ($_POST['hd_vehicle']);
	$dep_milage = ($_POST['dep_milage']);
	$return_milage = ($_POST['return_milage']);
	$exterior_car = ($_POST['exterior_car']);
	$comment1 = clean($_POST['comment1']);
	$interior_car = ($_POST['interior_car']);
	$comment = clean($_POST['comment']);
	$chk=implode(',',$hd_vehicle);
	$chk1=implode(',',$exterior_car);
	$chk2=implode(',',$interior_car);
	$id = ($_POST['id']);
	$status = $_POST['status'];
	$name = $_POST['name'];
	$month = $_POST['month'];

	$result = updatecarinspection1($car_plate_no,$dep_date,$fuel,$chk,$dep_milage,$return_milage,$chk1,$comment1,$chk2,$comment,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0 && $status == 'admin') 
	
	{

		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carinspection_list_bycompany_admin.php?department_id=$department_id&month=$month';
            </script>");
		//header("location: ../view/aims_carinspection_list.php");
		exit();
	}
	else if($result!="" && $result > 0 && $status == 'staff') 
	
	{

		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carinspection_list_bycompany.php?name=$name&month=$month';
            </script>");
		//header("location: ../view/aims_carinspection_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>