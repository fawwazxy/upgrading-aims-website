<?php
   	include "../model/aims_travel_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_GET['id']);
	$ceo_approval = clean($_GET['ceo_approval']);
	$ceo_app = clean($_GET['ceo_app']);
	$ceo_by = clean($_GET['ceo_by']);
	
	
	$result = editTravelVehicleCeo($id,$ceo_approval,$ceo_by,$ceo_app);
	
	
	//Check whether the query was successful or not
	
	if($result!="" && $result > 0) 
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_listCeo.php?ceo_approval=$ceo_approval';
			</script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
?>