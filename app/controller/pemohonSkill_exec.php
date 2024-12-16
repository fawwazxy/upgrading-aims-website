<?php
   	include "../model/pemohon_functions.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$skill = ($_POST['skill']);
	$level = ($_POST['level']);
	
	
	$id = ($_POST['id']);

	$result = addSkill($skill,$level);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_family.php';
            </script>");
		//header("location: ../view/pemohon_family.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>