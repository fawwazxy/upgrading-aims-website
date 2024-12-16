<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_POST['id']);
	$arrival_date = clean($_POST['arrival_date']);
	$arrival_time = clean($_POST['arrival_time']);
	$departure_date = clean($_POST['departure_date']);
	$departure_time = clean($_POST['departure_time']);
	$room_id = clean($_POST['room_id']);
	$locker_id = clean($_POST['locker_id']);
	$bed_id = clean($_POST['bed_id']);
	
	
    	
	
	//$id = ($_POST['id']);

	$result = updateBooking($arrival_date, $arrival_time, $departure_date, $departure_time, $room_id, $locker_id, $bed_id,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_booking_list.php';
            </script>");
		//header("location: ../view/aims_gl_booking_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>