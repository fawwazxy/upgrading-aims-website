<?php
include "../model/aims_hr_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);
$form_name = clean($_POST['form_name']);
$created_by = clean($_POST['created_by']);
$company_name = clean($_POST['company_name']);

$targetDir = "../../hrform/";
	if($_FILES['document']['size'] > 0) {
		
		$document_size = $_FILES['document']['size'];
		$image_document = $_FILES['document']['tmp_name'];
	    $document_name = $_FILES['document']['name'];
		$document_type = end((explode(".",$document_name)));
		$document_name_only = array_shift(explode(".",$document_name));

		date_default_timezone_set("Asia/Kuala_Lumpur");

		$randomnum=rand(0,100000);
		$rename= $document_name_only.date('Ymd').$randomnum;

		$documentname=$rename.'.'.$document_type;


	    $targetPath = $targetDir . $documentname;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$documentname = "";
	}

	$result = addForm($documentname,$document_type,$document_size,$company_name,$created_by,$form_name);

	//check wheter the query was succesful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
	
	window.location.href='../view/aims_hrform_list.php';
	</script>");
	exit();
}
else
{
	die("Query failed");
}
?> 