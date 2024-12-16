<?php
   	include "../model/cuti_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	//echo 'yuuu'.clean($_POST['name']);

	$id=clean($_GET['id']);
	$staff_record_id = clean($_POST['staff_record_id']);
	$alamat_cuti = clean($_POST['alamat_cuti']);
	$telepon = clean($_POST['telepon']);
	$cuti_dipohon = clean($_POST['cuti_dipohon']);
	$tarikh_mula = clean($_POST['tarikh_mula']);
	$tarikh_akhir = clean($_POST['tarikh_akhir']);
	$sebab = clean($_POST['sebab']);
	$jumlah_cuti = clean($_POST['jumlah_cuti']);
	$baki_cuti = clean($_POST['baki_cuti']);
	$document = clean($_POST['document']);




	
	$result = updateCutiPengguna($id,$staff_record_id,$alamat_cuti,$telepon,$cuti_dipohon,$tarikh_mula,$tarikh_akhir,$sebab,
		      $jumlah_cuti,$baki_cuti,$document);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/maklumat_cuti.php?id=$id';
            </script>");
		//header("location: ../view/maklumat_cuti.php?id=$id");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>