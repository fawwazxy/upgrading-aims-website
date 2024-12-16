<?php
   	include "../model/aims_car_function.php";

	//Sanitize the POST values
	$id = $_POST['id'];
	$car_id = $_POST['car_id'];
	$km_read = $_POST['km_read'];
	$odom_read = $_POST['odom_read'];
	$date = $_POST['date'];
	$job_desc = $_POST['job_desc'];
	$item_desc = $_POST['item_desc'];
	$place_service = $_POST['place_service'];
	$invoice_no = $_POST['invoice_no'];
	$duration = $_POST['duration'];
	$issue = $_POST['issue'];

	$result = update_maintenance($km_read,$odom_read,$date,$job_desc,$item_desc,$duration,$place_service,$invoice_no,$car_id,$id,$issue);

	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>