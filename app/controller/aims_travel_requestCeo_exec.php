<?php
   	include "../model/aims_travel_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$ceo_approval = clean($_POST['ceo_approval']);
	$ceo_by = clean($_POST['ceo_by']);
	
	
	$result = editTravelCeo($id,$ceo_approval,$ceo_by);
	
	
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


