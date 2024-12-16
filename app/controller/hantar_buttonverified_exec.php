<?php
	include "../model/aims_inout_function.php";
	
	//Sanitize the POST values
	//Stitle = clean($_POST['title']);
	
	$aims_inout_id = ($_GET['aims_inout_id']);
	$verified_name = ($_GET['verified_name']);
	
	$result = aims_verified_inout($aims_inout_id,$verified_name);
	
	if($result!='' && $result >0)
		 
	{
		echo ("<script LANGUAGE='JavaScript'>
		
		
			window.location.href='../view/aims_list_verified_approve.php';
			
			</script>");
			
			
			exit();
			
	}
	else
	{
		die("Query failed");
	}
	
?>