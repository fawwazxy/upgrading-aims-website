<?php
   	include "../model/aims_gl_function.php";

	$id= clean($_GET['id']);
	$room_id= clean($_GET['room_id']);
	$bed_id= clean($_GET['bed_id']);
	$locker_id= clean($_GET['locker_id']);
	
		$result = deleteBooking($id,$room_id,$bed_id,$locker_id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_booking_list.php';
            </script>");
		//header("location: ../view/aims_billing_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>