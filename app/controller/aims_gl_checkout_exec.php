<?php
	include "../model/aims_gl_function.php";
	
	//Sanitize the POST values
	//Stitle = clean($_POST['title']);
	
	$id = ($_GET['id']);
	$pic_cout = ($_GET['pic_cout']);
	$room_id = ($_GET['room_id']);
	
	$result = checkout($id,$pic_cout,$room_id);
	
	if($result!='' && $result >0)
		 
	{
		echo ("<script LANGUAGE='JavaScript'>
		
		
			window.location.href='../view/aims_gl_booking_list.php';
			
			</script>");
			
			
			exit();
			
	}
	else
	{
		die("Query failed");
	}
	
?>