<?php
   	include "../model/aims_travel_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$hod_approval = clean($_POST['hod_approval']);
	$hod_by = clean($_POST['hod_by']);
	
	
	$result = editTravel($id,$hod_approval,$hod_by);
	
	
	//Check whether the query was successful or not
	
	if($result!="" && $result > 0) 
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.history.back();
            </script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
?>


