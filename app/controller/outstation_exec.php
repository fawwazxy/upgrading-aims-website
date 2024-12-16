<?php

include "../model/kehadiran_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "tambahOutstation"){
		$nokp_staff=clean($_POST['nokp_staff']);
		$lokasi=clean($_POST['lokasi']);
		$latitude=clean($_POST['latitude']);
		$longitude=clean($_POST['longitude']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);

		$result=tambahOutstation($nokp_staff,$lokasi,$latitude,$longitude,$tarikh_mula,$tarikh_tamat);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/staff_outstation_senarai.php';
						</script>");
			//header("location: ../view/staff_outstation_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "kemaskiniOutstation"){
		$id=clean($_POST['id']);
		$nokp_staff=clean($_POST['nokp_staff']);
		$lokasi=clean($_POST['lokasi']);
		$latitude=clean($_POST['latitude']);
		$longitude=clean($_POST['longitude']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);

		$result=kemaskiniOutstation($id,$nokp_staff,$lokasi,$latitude,$longitude,$tarikh_mula,$tarikh_tamat);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/staff_outstation_senarai.php';
						</script>");
			//header("location: ../view/staff_outstation_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	
?>