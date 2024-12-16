<?php
   	include "../model/aims_critical_function.php";
    
	
	$id = ($_POST['id']);
	
	$part_name = ($_POST['part_name']);
	$minimum = ($_POST['minimum']);
	$balance = ($_POST['balance']);
	$used = ($_POST['used']);
	$supply = ($_POST['supply']);
	$rob = ($_POST['rob']);
	$vessel = ($_POST['vessel']);
	
	
	

	 $result = updateStaff($part_name,$minimum,$balance,$used,$supply,$rob,$vessel,$id);
	
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
	
?>









