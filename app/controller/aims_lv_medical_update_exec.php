<?php
   	include "../model/aims_lv_medical_function.php";
    
	
	$id = ($_POST['id']);
	
	
	$no_staff = $_POST['no_staff'];
	$staff_record_id = clean($_POST['staff_record_id']);
	

	$mec_date = ($_POST['mec_date']);
	$description = ($_POST['description']);
	$total = ($_POST['total']);
	
	if($_FILES['document']['size'] > 0) {

		$image_document = $_FILES['document']['tmp_name'];
		$documentAllowType = array('jpg','png','jpeg','gif','pdf');
		$imgContent_doc = addslashes(file_get_contents($image_document));
    	$document_name = $_FILES['document']['name'];
		$fileType = end((explode(".",$document_name)));
	}
	else {
		$imgContent_doc = "";
		$document_name = "";
		$fileType = "";
	}
		
	 $result =updateStaff($id,$mec_date,$description,$total,$imgContent_doc,$document_name,$fileType);
	 
	 	

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









