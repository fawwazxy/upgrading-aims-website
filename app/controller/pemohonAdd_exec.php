<?php
   	include "../model/pemohon_functions.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$noic = ($_POST['noic']);
	$name = ($_POST['name']);
	$phone = ($_POST['phone']);
	$email = ($_POST['email']);
	$alamat_tetap = ($_POST['alamat_tetap']);
	$alamat_surat = ($_POST['alamat_surat']);
	$umur = ($_POST['umur']);
	$role = ($_POST['role']);
	$status_pemohon = ($_POST['status_pemohon']);
	$martial_status = ($_POST['martial_status']);
	$tanggungan = ($_POST['tanggungan']);
	$tarikh_mula = ($_POST['tarikh_mula']);
	$tarikh_tamat = ($_POST['tarikh_tamat']);
	$company_id = ($_POST['company_id']);
	$gender = ($_POST['gender']);
	$iklan_id = ($_POST['iklan_id']);
	
	
	$id = ($_POST['id']);

	echo $result = addPemohon($noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$role,$status_pemohon,$martial_status,$tanggungan,$tarikh_mula,$tarikh_tamat,$company_id,$gender,$iklan_id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_ed.php?pemohon_id=$result&act=update';
            </script>");
		//header("location: ../view/pemohon_ed.php?pemohon_id=$result&act=update");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>