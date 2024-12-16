<?php
   	include "../model/aims_travel_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_GET['id']);
	$hod_approval = clean($_GET['hod_approval']);
	$sbu_hod_app = clean($_GET['sbu_hod_app']);
	$hod_by = clean($_GET['hod_by']);
	
	
	$result = editTravelVehicle($id,$hod_approval,$hod_by,$sbu_hod_app);
	
	
	//Check whether the query was successful or not
	
	if($result!="" && $result > 0) 
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_requestlist.php?hod_approval=$hod_approval';
			</script>");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
?>