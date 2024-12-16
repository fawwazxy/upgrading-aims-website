<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_POST['id']);
	$location = clean($_POST['location']);
	$date_purchase = clean($_POST['date_purchase']);
	$item = clean($_POST['item']);
	$unit = clean($_POST['unit']);
	$price = clean($_POST['price']);
	$total = clean($_POST['total']);
	
	
    	
	
	//$id = ($_POST['id']);

	$result = updateHkExpenses($location,$date_purchase,$item,$unit,$price,$total,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_hk_expenses.php';
            </script>");
		//header("location: ../view/aims_gl_booking_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>