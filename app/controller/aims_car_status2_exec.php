<?php
   	include "../model/aims_car_function.php";
	

    $id=clean($_GET['id']);
    $status_2=clean($_GET['status_2']);

	
	$result = status2_maintenance($id,$status_2);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
	//header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}