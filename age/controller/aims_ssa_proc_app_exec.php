<?php
   	include "../model/aims_ssa_proc_app_function.php";
    
	
	$id = ($_POST['id']);
	$proc_name = ($_POST['proc_name']);
	$proc_status = ($_POST['proc_status']);
	$proc_design = ($_POST['proc_design']);
	$proc_on = ($_POST['proc_on']);
	
	
	$result = procApp($proc_name, $proc_status, $proc_design, $proc_on, $id);
	
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







