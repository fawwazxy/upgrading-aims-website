<?php
	include "../model/aims_inout_function.php";
	
	//Sanitize the POST values
	//Stitle = clean($_POST['title']);
	
	$aims_inout_id =($_POST['aims_inout_id']);
	$approve = ($_POST['approve']);
	$approve_name = ($_POST['approve_name']);
	$approve_by = ($_POST['approve_by']);
	$reason= ($_POST['reason']);

	
	$result = addaims_verified_approve($aims_inout_id,$approve_name,$approve,$approve_by,$reason);
	
	if($result!='' && $result >0)
		 
	{
		echo ("<script LANGUAGE='JavaScript'>
		
		
			window.location.href='../view/aims_list_approveinout.php';
			
			</script>");
			
			
			exit();
			
	}
	else
	{
		die("Query failed");
	}
	
?>