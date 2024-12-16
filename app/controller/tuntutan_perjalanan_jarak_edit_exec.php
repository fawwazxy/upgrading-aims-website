<?php

   	include "../model/claim_function.php";
	

	$no_staff=$_POST['no_staff'];
	$perjalanan_tuntutan_id=$_POST['perjalanan_tuntutan_id'];
	$tarikh_pohon=$_POST['tarikh_pohon'];
	$tempat_from=$_POST['tempat_from'];
	$tempat_to=$_POST['tempat_to'];
	$tarikh_journey=$_POST['tarikh_journey'];
	$jumlah_jarak=$_POST['jumlah_jarak'];
	$jumlah_tuntutan=$_POST['jumlah_tuntutan'];
	//$document=$_FILES['document'];
	 $image = $_FILES['document']['tmp_name'];
     $imgContent = addslashes(file_get_contents($image));
     $nama_document=$_FILES['document']['name'];
	$pelulus=$_POST['pelulus'];
	$catatan=$_POST['catatan'];
	$status=$_POST['status'];
	$jarak_id=$_POST['jarak_id'];
	$jenis_tuntutan=$_POST['jenis_tuntutan'];
   

	$result = UpdateTuntutanJarak($perjalanan_tuntutan_id,$tempat_from,$tempat_to,$tarikh_journey,$jumlah_jarak,$jumlah_tuntutan,$pelulus,                          $catatan,$jarak_id,$jenis_tuntutan,$imgContent,$nama_document);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/senarai_tuntutan_belum_diluluskan.php?no_staff=$no_staff';
                    </script>");
		//header("location: ../view/senarai_tuntutan_belum_diluluskan.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>