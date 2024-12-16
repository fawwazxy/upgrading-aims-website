<?php

   	include "../model/claim_function.php";
	

	$no_staff=$_POST['no_staff'];
	$default_id=$_POST['default_id'];
	$jumlah_tuntutan=$_POST['jumlah_tuntutan'];
	 //$document=$_FILES['document'];
	 $image = $_FILES['document']['tmp_name'];
     $imgContent = addslashes(file_get_contents($image));
     $nama_document=$_FILES['document']['name'];
	$pelulus=$_POST['pelulus'];
	$catatan=$_POST['catatan'];
	$jenis_tuntutan=$_POST['jenis_tuntutan'];
   

	$result = UpdateTuntutanDefault($default_id,$jumlah_tuntutan,$pelulus,$catatan,$jenis_tuntutan,$imgContent,$nama_document);
	
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