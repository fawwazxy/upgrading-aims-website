<?php
   	include "../model/aims_departmentcompany_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$description = clean($_POST['description']);
	$code_department = clean($_POST['code_department']);
	

	

	$result = addDepartment($description,$code_department);
	
	
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