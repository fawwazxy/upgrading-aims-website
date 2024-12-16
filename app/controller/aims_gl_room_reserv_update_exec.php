<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_POST['id']);
	$ref_no = clean($_POST['ref_no']);
	$reserv_date = clean($_POST['reserv_date']);
	

	$result = updateRoomReserv($id,$ref_no, $reserv_date);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_room_reserv_list.php';
            </script>");
		//header("location: ../view/aims_billing_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>