<?php

include "../model/kehadiran_functions.php";
	
	 $id=clean($_POST['id']);
    $act=clean($_POST['act']);
    $masa_bekerja=clean($_POST['masa_bekerja']);
    //$the_time = date('h:i A', strtotime($masa_bekerja));
    if($act=="add"){
	$result =  addMasaBekerja($masa_bekerja);
    }
	else{
	$result =  updateMasaBekerja($id,$masa_bekerja);	
	}
	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/masa_mula_bekerja.php';
            </script>");
		//header("location: ../view/masa_mula_bekerja.php?");
		exit();
	}else {
		die("Query failed");
	}
?>