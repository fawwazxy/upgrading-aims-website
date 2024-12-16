<?php
   	include "../model/aims_lv_medical_function.php";
    
	
	$no_staff=clean($_GET['no_staff']);
	$medical_id=clean($_GET['medical_id']);
	$staff_record_id =clean($_GET['staff_record_id']);
	$total_claim =clean($_GET['total_claim']);
	
	$result = getMedicalDocInfo($medical_id)->fetch_object();
    $document_name =$result -> document_name;
    $dir = "../../medicalphoto/";
    $file = $dir . $document_name;
	

	$result = deleteMedical($medical_id,$staff_record_id,$total_claim);
	
	//Check whether the query was successful or not
	if($result !="" && $result > 0)
	{
	    unlink($file);
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_lv_medical_list.php';
						</script>");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









