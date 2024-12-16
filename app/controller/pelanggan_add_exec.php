<?php
   	include "../model/niaga_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$action = ($_GET['act']);

	$name = ($_POST['lead_name']);
	$shrtname = ($_POST['lead_shrtname']);
	$address = ($_POST['lead_address']); 
	$telno = ($_POST['lead_telno']);
    $email = ($_POST['lead_email']); 
	$pic_name = ($_POST['pic_name']); 
	$pic_position = ($_POST['pic_position']); 
	$lokasi = ($_POST['lokasi']);
	$daerah = ($_POST['daerah']);
	$negeri = ($_POST['negeri']);
	$segmen = ($_POST['segmen']);
	$status = ($_POST['status']);
	$created_by = ($_POST['created_by']);
    	
	
	
	//$id = ($_POST['id']);

	echo $result = addPelanggan($name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi,$daerah,$negeri,$segmen,$status,$created_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		if($action == 'pelanggan'){
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_pelanggan.php';
						</script>");
			//header("location: ../view/senarai_pelanggan.php");
		}else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_pelanggan.php';
						</script>");
			//header("location: ../view/senarai_pelanggan.php");
		}
		
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>