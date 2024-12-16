<?php
   	include "../model/pemohon_functions.php";
	
	


	$no_staff = $_GET['no_staff'];
	$code=clean($_POST['code']);
    $role=clean($_POST['role']);
    $id=clean($_GET['id']);
	$role_group_id=$_POST['role_group_id'];
	$slip_gaji=$_POST['slip_gaji'];
	$status_pelulus_cuti=$_POST['status_pelulus_cuti'];


	
	$result = editPeranan($id,$code,$role,$role_group_id,$slip_gaji,$status_pelulus_cuti);

	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/peranan_add.php?id=$id';
            </script>");
		//header("location: ../view/peranan_add.php?id=".$id);
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>