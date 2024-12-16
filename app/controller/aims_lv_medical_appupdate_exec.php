<?php
   	include "../model/aims_lv_medicalapp_function.php";
    
	
	$id = ($_POST['id']);
	
	
	$app_status = ($_POST['app_status']);

	$app_name = ($_POST['app_name']);
	
	 $result =updateStaff($app_status,$app_name,$id);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_lv_medicalapp_list.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









