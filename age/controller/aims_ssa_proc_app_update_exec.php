<?php
   	include "../model/aims_ssa_proc_app_function.php";
    
	
	$id = ($_POST['id']);
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
	$proc_name = ($_POST['proc_name']);
	$proc_status = ($_POST['proc_status']);
	$proc_design = ($_POST['proc_design']);
	
	
	$result = updateSSA($ssa_no, $date, $vessel, $location, $department, $ssa_raised, $aa, $bb, $cc, $dd, $document, $document_name, $fileType, $proc_name, $proc_status, $proc_design, $id);
	
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
						window.location.href='../view/aims5_ssa_list.php';
						</script>");-->







