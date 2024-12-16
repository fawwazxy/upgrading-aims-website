<?php
   	include "../model/aims_ssa_function.php";
    
	
	
	$ssa_no = ($_POST['ssa_no']);
	$date = ($_POST['date']);	
	$vessel = ($_POST['vessel']);	
	$location = ($_POST['location']);	
	$department = ($_POST['department']);	
	$ssa_raised = ($_POST['ssa_raised']);	
	$aa = ($_POST['aa']);	
	$bb = ($_POST['bb']);	
	$cc = ($_POST['cc']);	
	$dd = ($_POST['dd']);
	$status = ($_POST['status']);
	$remark = ($_POST['remark']);
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

	 $result =addSSA($ssa_no, $date, $vessel, $location, $department, $ssa_raised, $aa, $bb, $cc, $dd,$status=1, $imgContent_doc,$document_name,$fileType,$remark);
	
	//Check whether the query was successful or not
	
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_ssa_list.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
?>








