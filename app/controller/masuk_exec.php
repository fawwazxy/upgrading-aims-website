<?php

include "../model/kehadiran_functions.php";
	
	

	$nokp = ($_POST['nokp_staff']);
	$act = ($_POST['action']);
	
	$lokasi=($_POST['id_lkp_lokasi']);
	$cawangan=($_POST['id_lkp_cawangan']);
	
	$result = true;	
	if($act=="masuk"){
	
	    $result = addkehadiranByLokasi($lokasi,$nokp,$cawangan);
	}
	else{
		$result = updatekehadiranByLokasi($lokasi,$nokp);
	}
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/log_kehadiran.php';
            </script>");
		//header("location: ../view/log_kehadiran.php");
		exit();
	}else {
		die("Query failed");
	}
?>