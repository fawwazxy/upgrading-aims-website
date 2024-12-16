<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$booking_id = clean($_POST['booking_id']);
	$er_no = clean($_POST['er_no']);
	$room_pass = clean($_POST['room_pass']);
	$bed_pass = clean($_POST['bed_pass']);
	$locker_pass = clean($_POST['locker_pass']);
	$room_id = clean($_POST['room_id']);
	$bed_id = clean($_POST['bed_id']);
	$locker_id = clean($_POST['locker_id']);
	$reason = clean($_POST['reason']);
	$date_change = clean($_POST['date_change']);
	$action_by = clean($_POST['action_by']);
	
	//$id = ($_POST['id']);

	$result = addExchange($booking_id, $er_no, $room_pass, $bed_pass, $locker_pass, $room_id, $bed_id, $locker_id, $reason, $date_change, $action_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_exchange_list.php';
            </script>");
		//header("location: ../view/aims_gl_booking_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>