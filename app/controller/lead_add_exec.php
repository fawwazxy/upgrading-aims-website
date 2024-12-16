<?php
   	include "../model/surat_function.php";
    
	
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
    	
	
	
	//$id = ($_POST['id']);

	echo $result = addlead($name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		if($action == 'sh'){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_lead_sebutharga.php';
            </script>");
			//header("location: ../view/senarai_lead_sebutharga.php");
		}else{
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_lead.php';
            </script>");
			//header("location: ../view/senarai_lead.php");
		}
		
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>