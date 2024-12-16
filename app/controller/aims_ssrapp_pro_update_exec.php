<?php
   	include "../model/aims_ssrapp_pro_function.php";
    
	
	$id = ($_POST['id']);
	
	$app_pro_name = ($_POST['app_pro_name']);
	$app_pro_status = ($_POST['app_pro_status']);
	
	$app_pro_date = ($_POST['app_pro_date']);
	
	
	

	 $result = updateInfo($app_pro_name,$app_pro_status,$app_pro_date,$id);
	
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
	
	if($result!="" && $result > 0)

	
?>









