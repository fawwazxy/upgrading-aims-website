<?php
   	include "../model/aims_gl_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$id = clean($_POST['id']);
	$item = clean($_POST['item']);
	$code = clean($_POST['code']);
	

	$result = updateItemHk($item,$code,$id) ;
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_gl_hk_item.php';
            </script>");
		//header("location: ../view/aims_billing_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>