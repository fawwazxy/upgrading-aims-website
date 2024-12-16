<?php
include "../model/aims_others_claim_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);
$id = clean($_POST['id']);
$date_purchase = clean($_POST['date_purchase']);
$description = clean($_POST['description']);
$total_claim = clean($_POST['total_claim']);
$month_claim = clean($_POST['month_claim']);
$staff_record_id = clean($_POST['staff_record_id']);
$job_no = clean($_POST['job_no']);
$remark = clean($_POST['remark']);



if($_FILES['document']['size'] > 0) {

		$image_document = $_FILES['document']['tmp_name'];
		$documentAllowType = array('jpg','png','jpeg','gif','pdf');
		$document = addslashes(file_get_contents($image_document));
    	$document_name = $_FILES['document']['name'];
		$document_type = end((explode(".",$document_name)));
	}
	else {
		$document = "";
		$document_name = "";
		$document_type = "";
	}

$result = updateClaim($date_purchase,$description,$total_claim,$month_claim,$job_no,$document,$document_name,$document_type,$remark,$id);

//check wheter the query was succesful or not
if($result!="" && $result > 0)
{
	echo ("<script LANGUAGE='JavaScript'>
	
	window.location.href='../view/aims_others_claim_hr_list.php';
	</script>");
	exit();
}
else
{
	die("Query failed");
}