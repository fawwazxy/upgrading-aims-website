<?php
   	include "../model/aims_carReserve_function.php";
    
	
	
	$id = ($_GET['id']);
	$targetDir = "../../fuel_photo/";

	$sql="SELECT document_name, file_name FROM aims_car_fuel WHERE id='$id'";
	$getFileName = db()->query($sql)->fetch_assoc();
		unlink($targetDir.$getFileName['document_name']);
		unlink($targetDir.$getFileName['file_name']);
	 $result =deletefuel($id);
	
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









