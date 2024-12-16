
<?php

include "../model/pemohon_functions.php";
	
	$company_id=$_POST['company_id'];
	$no_staff = $_GET['no_staff'];
	$code=strtoupper($_POST['code']);
    $role=strtoupper($_POST['role']);
    $id = clean($_POST['id']);
	$role_group_id=$_POST['role_group_id'];
	
	
  
  

	echo $resultDuplicate = isRoleDplct($role);
	//echo ($resultdplct==0);
	if($resultDuplicate==0){

		$result =   $result = addPeranan($code,$role,$role_group_id);;
        if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/peranan_add.php';
            </script>");
		//header("location: ../view/peranan_add.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}

	}else {
		$fail 
		= 'Data sudah wujud';
		echo"<script> alert(\"$fail\"); location.href = '../view/peranan_add.php?duplic=1&xrole=".$role."';</script>";
		exit();
	}
?>