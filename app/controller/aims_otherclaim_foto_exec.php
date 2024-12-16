<?php
include "../model/aims_others_claim_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);

$id= clean($_POST['id']);
$month= clean($_POST['month_claim']);
$staff_record_id= clean($_POST['staff_record_id']);
$status= clean($_POST['status']);
$tahun= clean($_POST['tahun']);
$targetDir = "../../othersclaimphoto/";
	if($_FILES['document']['size'] > 0) {
		
		$image_document = $_FILES['document']['tmp_name'];
	    $document_name = $_FILES['document']['name'];
	    $document_type = end((explode(".",$document_name)));
	    $targetPath = $targetDir . $document_name;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$document_name = "";
	}

$result = UpdateClaimsz($document_name,$document_type,$id);

//check wheter the query was succesful or not
if($result!="" && $result > 0)
{
	echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
	exit();
}
else
{
	die("Query failed");
}