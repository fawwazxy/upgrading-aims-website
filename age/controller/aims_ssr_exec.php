<?php
   	include "../model/aims_ssr_function.php";
    
	
	$ssr_no = clean($_POST['ssr_no']);
	$ssr_date = clean($_POST['ssr_date']);
	$vessel = clean($_POST['vessel']);
	$department = clean($_POST['department']);
	$location = clean($_POST['location']);
	$item = clean($_POST['item']);
	$status = clean($_POST['status']);
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
	  

	 $result = addStaff($ssr_no,$ssr_date,$vessel,$department,$location,$item,$status=1,$imgContent_doc,$document_name,$fileType);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
	
	
	
?>

