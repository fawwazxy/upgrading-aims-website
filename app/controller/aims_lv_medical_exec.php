<?php
   	include "../model/aims_lv_medical_function.php";
    
    $no_staff = $_POST['no_staff'];
	$staff_record_id = clean($_POST['staff_record_id']);
	$department_id = clean($_POST['department_id']);
	$role_id = clean($_POST['role_id']);
	$department_sub = clean($_POST['department_sub']);
	$mec_date = ($_POST['mec_date']);
	$description = ($_POST['description']);
	$total_claim = ($_POST['total_claim']);
	$targetDir = "../../medicalphoto/";
	if($_FILES['document']['size'] > 0) {
		
		$image_document = $_FILES['document']['tmp_name'];
	    $documentname = $_FILES['document']['name'];
	    $document_type = end((explode(".",$documentname)));
	    $document_name_only = array_shift(explode(".",$documentname));
	    date_default_timezone_set("Asia/Kuala_Lumpur");
	    $randomnum=rand(0,100000);
	    $rename= $document_name_only.date('Ymd').$randomnum;
	    $document_name=$rename.'.'.$document_type;
	    
	    $targetPath = $targetDir . $document_name;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$document_name = "";
	}

	$result =addStaff($staff_record_id,$department_id,$role_id,$department_sub,$mec_date,$description,$total_claim,$document_name,$document_type);
	//Check whether the query was successful or not
	
if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_lv_medical_list.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>








