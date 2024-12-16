<?php

include "../model/pemohon_functions.php";
	
	$noic = ($_POST['noic']);
	$name = ($_POST['name']);
	$phone = ($_POST['phone']);
	$email = ($_POST['email']);
	$alamat_tetap = ($_POST['alamat_tetap']);
	$alamat_surat = ($_POST['alamat_surat']);
	$umur = ($_POST['umur']);
	$status_pemohon = ($_POST['status_pemohon']);
	$martial_status = ($_POST['martial_status']);
	$tanggungan = ($_POST['tanggungan']);

	$pemohon_id = ($_POST['id']);  
	
	$result = updatePemohon($pemohon_id,$noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$status_pemohon,$martial_status,$tanggungan);
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_senarai.php?statact=DLMPOHON';
            </script>");
		//header("location: ../view/pemohon_senarai.php?statact=DLMPOHON");
		exit();
	}else {
		die("Query failed");
	}
?>