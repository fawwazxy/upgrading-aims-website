<?php
   	include "../model/aims_carReserve_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = $_POST['id'];
	$status_remark = $_POST['status_remark'];
	$remark = $_POST['remark'];
	$costing = $_POST['costing'];
	$remark_name = $_POST['remark_name'];

	$result =update_remark($status_remark,$remark,$costing,$remark_name,$id);
	
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