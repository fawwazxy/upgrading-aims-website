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
	$role_id = ($_POST['role_id']);
	$status_pemohon = ($_POST['status_pemohon']);
	$martial_status = ($_POST['martial_status']);
	$tanggungan = ($_POST['tanggungan']);
	$gender = ($_POST['gender']);
	
	$company_id = ($_POST['company_id']);
	$pemohon_id = ($_POST['pemohon_id']);
	$iklan_id = ($_POST['iklan_id']);

	 $result = addPemohonPerjawatan($noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$role_id,$status_pemohon,$martial_status,$tanggungan,$company_id,$gender,$iklan_id );
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		 echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/permohonan_perjawatan_pendidikan.php?pemohon_id=$result';
            </script>");
		//header("location: ../view/permohonan_perjawatan_pendidikan.php?pemohon_id=$result");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









