<?php
   	include "../model/aims_access_function.php";
    
	
	//Sanitize the GET values
	
	$id = clean($_GET['id']);
	

	$result = deleteAccess($id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_access_form.php';
            </script>");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?> 