<?php
	include "../model/aims_inout_function.php";
	
	//Sanitize the POST values
	//Stitle = clean($_POST['title']);
	
	$id = clean($_GET['id']);

	
	$result = deleteaims_inout($id);
	
	if($result!='' && $result >0)
		 
	{
		echo ("<script LANGUAGE='JavaScript'>
		
		
			window.location.href='../view/aims_inout_list.php';
			
			</script>");
			
			
			exit();
			
	}
	else
	{
		die("Query failed");
	}
	
?>