<?php
   	include "../model/aims_car_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$car_model = $_POST['car_model'];
	$dep_date = $_POST['dep_date'];
	$interior_car1 = $_POST['interior_car1'];
	$exterior_car1 = $_POST['exterior_car1'];
	$km_read = $_POST['km_read'];
	$odom_read = $_POST['odom_read'];
	$costing = $_POST['costing'];
	$date = $_POST['date'];
	$job_desc = $_POST['job_desc'];
	$item_desc = $_POST['item_desc'];
	$place_service = $_POST['place_service'];
	$invoice_no = $_POST['invoice_no'];
	$duration = $_POST['duration'];
	$issue = $_POST['issue'];
	$id = $_POST['id'];
	
	if ($id > 0){
	$result = update_maintenance($car_model,$dep_date,$interior_car1,$exterior_car1,$km_read,$odom_read,$costing,$date,$job_desc,$item_desc,$place_service,$invoice_no,$duration,$issue,$id);	
	}
	else {
	$result = add_maintenance($car_model,$dep_date,$interior_car1,$exterior_car1,$km_read,$odom_read,$costing,$date,$job_desc,$item_desc,$place_service,$invoice_no,$duration,$issue);
	}
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