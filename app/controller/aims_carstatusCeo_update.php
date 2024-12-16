<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_POST['id']);
	$ceo_app = clean($_POST['ceo_app']);
	$app_by = clean($_POST['app_by']);
	
	//$id = ($_POST['id']);

	$result = updatecarbyCeo($app_by,$ceo_app,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carReserve_ceoList.php';
            </script>");
		//header("location: ../view/aims_carReserve_ceoList.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>