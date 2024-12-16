<?php
   	include "../model/aims_hr_function.php";
    
	
	//Sanitize the POST values
	
	$id=clean($_GET['id']);
    $result = getLibraryInfo($id)->fetch_object();
    $name =$result -> document_name;
    $dir = "../../hrform/";
    $file = $dir . $name;
	
	$result = deleteHrForm($id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	{
		
		unlink($file);

		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_hrform_list.php';
            </script>");
		exit();
	}
	else 
	{
		die("Query failed");
	}
?> 
