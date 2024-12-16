<?php
   	include "../model/aims_lv_medical_function.php";
    
	
	$no_staff = clean($_POST['no_staff']);
	$medical_id = clean($_POST['medical_id']);
	$staff_record_id = clean($_POST['staff_record_id']);
	$baki_claim = clean($_POST['baki_claim']);
	$total_claim = clean($_POST['total_claim']);
	$jumlah_claim = clean($_POST['jumlah_claim']);
	$remarks = clean($_POST['remarks']);

	$result =addClaim($medical_id,$staff_record_id,$baki_claim,$total_claim,$jumlah_claim,$remarks);
	//Check whether the query was successful or not
	
if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_lv_medicalver_list.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>








