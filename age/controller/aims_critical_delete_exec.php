<?php
   	include "../model/aims_critical_function.php";
    
	
	
	$id = ($_GET['id']);
	
	

	$result = deleteStaff($id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









