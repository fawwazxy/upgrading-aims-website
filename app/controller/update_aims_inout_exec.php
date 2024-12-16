<?php
	include "../model/aims_inout_function.php";
	
	//Sanitize the POST values
	//Stitle = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$date_mohon = clean($_POST['date_mohon']);
	
	$description = clean($_POST['description']);
	
	$time_in = clean($_POST['time_in']);
	$time_out = clean($_POST['time_out']);
	
	
	$result = updateaims_inout($date_mohon,$description,$time_in,$time_out,$id);
	
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