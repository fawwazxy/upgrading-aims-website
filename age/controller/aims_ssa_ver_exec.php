<?php
   	include "../model/aims_ssa_ver_function.php";
    
	
	$id = ($_POST['id']);
	$ver_name = ($_POST['ver_name']);
	$ver_status = ($_POST['ver_status']);
	$ver_design = ($_POST['ver_design']);
	$ver_on = ($_POST['ver_on']);
	
	
	$result = verOn($ver_name, $ver_status, $ver_design, $ver_on, $id);
	
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







