<?php
   	include "../model/aims_travel_function.php";
	
	//Sanitize the POST values
	$id = clean($_POST['id']);
	$company_id = clean($_POST['company_id']);
	$department_id = clean($_POST['department_id']);
	
	
	$name = clean($_POST['name']);
	$no_staff = clean($_POST['no_staff']);
	$staff_designation = clean($_POST['staff_designation']);
	$noic = clean($_POST['noic']);
	
	$travel_mode_id = clean($_POST['travel_mode_id']);
	
	$job_no = clean($_POST['job_no']);
	$travel_purpose = clean($_POST['travel_purpose']);
	
	$departure_time = clean($_POST['departure_time']);
	$departure_date = clean($_POST['departure_date']);
	$return_date = clean($_POST['return_date']);
	$return_time = clean($_POST['return_time']);
	
	$request_hotel = clean($_POST['request_hotel']);
	$hotel_duration = clean($_POST['hotel_duration']);
	$check_in = clean($_POST['check_in']);
	$check_out = clean($_POST['check_out']);
	
	$transport_fairport = clean($_POST['transport_fairport']);
	$transport_tairport = clean($_POST['transport_tairport']);
	
	$request_driver = clean($_POST['request_driver']);
	$destination = clean($_POST['destination']);
	
	$advance_required = clean($_POST['advance_required']);
	$travel_advance = clean($_POST['travel_advance']);
	
	$created_by = clean($_POST['created_by']);
	$created_date = clean($_POST['created_date']);
	
	
	
	$result = updateTravelList($company_id,$department_id,$no_staff,$name,$noic,$staff_designation,$destination,$travel_mode_id,
	$departure_date,$departure_time,$return_date,$return_time,$request_hotel,$hotel_duration,$check_in,$check_out,$job_no,
	$travel_purpose,$transport_fairport,$transport_tairport,$request_driver,$advance_required,$travel_advance,$id);
	
	
	//Check whether the query was successful or not
	
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_travel_list.php';
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
?>



