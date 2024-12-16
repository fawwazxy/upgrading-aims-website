<?php
   	include "../model/analisa_kehadiran_functions.php";
	
	$id = clean($_POST['id']);
	$nokp_staff = clean($_POST['nokp_staff']); 
	$sebab_kelewatan = clean($_POST['sebab_kelewatan']);



	
	$result =masukSebabKelewatan($id,$nokp_staff,$sebab_kelewatan);

	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/analisa_kehadiran_peribadi.php?';
            </script>");
		//header("location: ../view/aims_company_senarai.php?");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>