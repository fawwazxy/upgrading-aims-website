<?php
   	include "../model/pemohon_functions.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$pencapaian = ($_POST['pencapaian']);
	$tempat = ($_POST['tempat']);
	$tahun_mula = ($_POST['tahun_mula']);
	$tahun_akhir = ($_POST['tahun_akhir']);
	$keputusan = ($_POST['keputusan']);
	
	
	
	$id = ($_POST['id']);

	$result = addEducation($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_experience.php';
            </script>");
		//header("location: ../view/pemohon_experience.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>