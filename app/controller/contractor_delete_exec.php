<?php
   	include "../model/contractor_function.php";
    
	
	
	$id = ($_GET['id']);
	$targetDir = "../../contractorphoto/";

	$sql="SELECT doc_name FROM contractor_company WHERE contractor_id='$id'";
	$getFileName = db()->query($sql)->fetch_assoc();
		unlink($targetDir.$getFileName['doc_name']);
	 $result =deleteContractor($id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
	    unlink($file);
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









