<?php
   	include "../model/aims_departmentcompany_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$id = clean($_GET['id']);

	

	$result = deleteDepartment($id);
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_department_addlist.php';
            </script>");
		//header("location: ../view/aims_senarai_invoice.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>