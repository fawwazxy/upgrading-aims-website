<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$booking_id = clean($_POST['booking_id']);
	$ref_no = clean($_POST['ref_no']);
	$reserv_date = clean($_POST['reserv_date']);
	$to = clean($_POST['to']);
	$fax = clean($_POST['fax']);
	$attend = clean($_POST['attend']);
	$client_company_id = clean($_POST['client_company_id']);
	$arrival_date = clean($_POST['arrival_date']);
	$room_id = clean($_POST['room_id']);
	$bed_id = clean($_POST['bed_id']);
	$confirm_by = clean($_POST['confirm_by']);
	$confirm_company = clean($_POST['confirm_company']);
	

	$result = AddRoomReserv($booking_id,$ref_no, $reserv_date, $to, $fax, $attend, $client_company_id,$arrival_date,$room_id,$bed_id,$confirm_by,$confirm_company);
	
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