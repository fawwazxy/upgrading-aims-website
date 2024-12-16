<?php
   	include "../model/aims_ssa_function.php";
    
	
	
	$id = ($_GET['id']);
	


	 $result =deleteSSA($id);
	
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









