<?php
   	include "../model/aims_ssr_function.php";
    
	
	$id = ($_POST['id']);
	
	$ssr_no = ($_POST['ssr_no']);
	$ssr_date = ($_POST['ssr_date']);
	$vessel = ($_POST['vessel']);
	$department = ($_POST['department']);
	$location = ($_POST['location']);
	$item = ($_POST['item']);
	$status = ($_POST['status']);
	
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

	 $result = updateStaff($ssr_no,$ssr_date,$vessel,$department,$location,$item,$status=1,$imgContent_doc,$document_name,$fileType,$id);
	
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

<!--echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_list_ssr.php';
						</script>");-->







