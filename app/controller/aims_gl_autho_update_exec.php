<?php
session_start();
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	$id = clean($_GET['id']);
	$autho_by = clean($_GET['autho_by']);

	$result = AuthorizedBooking($id,$autho_by);
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_autho_list.php';
            </script>");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>