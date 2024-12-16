<?php
   	include "../model/niaga_function.php";
    
	
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
	$negeri = ($_POST['negeri']);
	$daerah = ($_POST['daerah']);
	$segmen = ($_POST['segmen']);
	$status = ($_POST['status']);
	$created_by = ($_POST['created_by']);
    	
	
	
	//$id = ($_POST['id']);

	echo $result = updatePelanggan($id,$name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi,$negeri,$daerah,$segmen,$status,$created_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_pelanggan.php';
						</script>");
		//header("location: ../view/senarai_pelanggan.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>