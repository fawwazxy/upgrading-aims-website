<?php
   	include "../model/aims_car_function.php";
    
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id =$_POST['id'];
	$car_status =$_POST['car_status'];
	$updated_by =$_POST['updated_by'];

	$result = updatecarbycompany($car_status,$updated_by,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carlist_bycompany.php';
            </script>");
		//header("location: ../view/aims_car_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>