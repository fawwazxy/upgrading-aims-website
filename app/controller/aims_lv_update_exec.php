<?php
   	include "../model/cuti_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$no_staff = clean($_POST['no_staff']);
	$staff_holiday_id = clean($_POST['staff_holiday_id']);
	$staff_record_id = clean($_POST['staff_record_id']);
	$date_fill = clean($_POST['date_fill']);
	$dic_leave = clean($_POST['dic_leave']);
	$date_lv_from = clean($_POST['date_lv_from']);
	$date_lv_to = clean($_POST['date_lv_to']);
	$day_lv_from = clean($_POST['day_lv_from']);
	$day_lv_to = clean($_POST['day_lv_to']);
	$type_leave = clean($_POST['type_leave']);
	$reason_leave = clean($_POST['reason_leave']);
	$descrip = clean($_POST['descrip']);
	$baki_cuti_pohon = $_POST['baki_cuti_pohon'];
	$total_lv_req = clean($_POST['total_lv_req']);
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
	
	

	$result =updateCuti($staff_record_id,$staff_holiday_id,$no_staff,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$document,$document_name,$fileType,$baki_cuti_pohon);               

	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_lv.php';
            </script>");
		//header("location: ../view/aims_billing_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>