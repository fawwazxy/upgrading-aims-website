<?php
   	include "../model/staff_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);

	$pemohon_id= ($_GET['id']);
	$shortcode=($_GET['shortcode']);
	
	
	
    $result = addNewStaff($pemohon_id,$shortcode);
      
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/staff_info.php';
						</script>");
		//header("location: ../view/staff_info.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>