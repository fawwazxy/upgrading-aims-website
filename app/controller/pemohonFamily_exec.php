<?php
   	include "../model/pemohon_functions.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$nama = ($_POST['nama']);
	$phone = ($_POST['phone']);
	$pekerjaan = ($_POST['pekerjaan']);
	$hubungan = ($_POST['hubungan']);
	
	
	$id = ($_POST['id']);

	$result = addFamily($nama,$phone,$pekerjaan,$hubungan);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_senarai.php';
            </script>");
		//header("location: ../view/pemohon_senarai.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>