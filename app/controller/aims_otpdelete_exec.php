<?php
   	include "../model/aims_ot_function.php";
    
	
	
	$id = ($_GET['id']);
	


	 $result =deleteOtPermission($id);
	
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









