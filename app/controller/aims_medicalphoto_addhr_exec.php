<?php
include "../model/aims_lv_medical_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);

$id= clean($_POST['id']);
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

$result = Updatemedicalz($document_name,$document_type,$id);

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