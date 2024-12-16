<?php
   	include "../model/surat_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
    $id = $_GET['id'];
	$name = clean($_POST['lead_name']);
	$shrtname = clean($_POST['lead_shrtname']);
	$address = clean($_POST['lead_address']); 
	$telno = clean($_POST['lead_telno']);
    $email = clean($_POST['lead_email']); 
	$pic_name = clean($_POST['pic_name']); 
	$pic_position = clean($_POST['pic_position']); 
	$lokasi = ($_POST['lokasi']); 
    	
	
	
	//$id = ($_POST['id']);

	echo $result = updatelead($id,$name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_lead_sebutharga.php';
            </script>");
		//header("location: ../view/senarai_lead_sebutharga.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>