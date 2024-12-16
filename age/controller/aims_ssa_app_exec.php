<?php
   	include "../model/aims_ssa_app_function.php";
    
	
	$id = ($_POST['id']);
	$app_name = ($_POST['app_name']);
	$app_status = ($_POST['app_status']);
	$app_design = ($_POST['app_design']);
	$app_on = ($_POST['app_on']);
	
	
	$result = appOn($app_name, $app_status, $app_design, $app_on, $id);
	
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







