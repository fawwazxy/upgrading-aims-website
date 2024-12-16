<?php
   	include "../model/aims_ssrverified_function.php";
    
	
	$id = ($_POST['id']);
	
	
	$verified_name = ($_POST['verified_name']);
	$verified_designation = ($_POST['verified_designation']);
	$verified_status= ($_POST['verified_status']);
	
	

	 $result = updateInfo($verified_name,$verified_designation,$verified_status,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
	if($result!="" && $result > 0)

	
?>









