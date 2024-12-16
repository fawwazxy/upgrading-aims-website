<?php
   	include "../model/aims_lv_medicalver_function.php";
    
    $medical_id = clean($_POST['medical_id']);
    $id = clean($_POST['id']);
    $staff_record_id =clean($_POST['staff_record_id']);
	$ver_status = clean($_POST['ver_status']);
	$ver_name = clean($_POST['ver_name']);
	$total_claim =clean($_POST['total_claim']);
	
	$result =verifiedHR($staff_record_id,$total_claim,$ver_status,$ver_name,$medical_id,$id);
	
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


















