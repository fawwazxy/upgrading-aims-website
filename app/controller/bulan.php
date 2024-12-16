<?php
   	include "../model/tolak_gaji.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$jan = ($_POST['jan']);
	$feb = ($_POST['feb']);
	$mac = ($_POST['mac']);
	$apr = ($_POST['apr']);
	$mei = ($_POST['mei']);
	$jun = ($_POST['jun']);
	$jul = ($_POST['jul']);
	$ogos = ($_POST['ogos']);
	$sep = ($_POST['sep']);
	$okt = ($_POST['okt']);
	$nov = ($_POST['nov']);
	$dec = ($_POST['dis']);
	
	$id = ($_POST['id']);

	echo $result = addPemohon($jan,$feb,$mac,$apr,$mei,$jun,$jul,$ogos,$sep,$okt,$nov,$dis);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/pemohon_ed.php?pemohon_id=$result&act=update';
						</script>");
		//header("location: ../view/pemohon_ed.php?pemohon_id=$result&act=update");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>