<?php
   	include "../model/aims_lv_medicalappcfo_function.php";
    
	
	$id = ($_POST['id']);
	
	
	$appcfo_status = ($_POST['appcfo_status']);

	$appcfo_name = ($_POST['appcfo_name']);
	
	 $result =updateStaff($appcfo_status,$appcfo_name,$id);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_lv_medicalappcfo_list.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









