<?php
   	include "../model/aims_lv_medical_function.php";
	

    $id=clean($_GET['app_id']);

	
	$result = dload($id);
	
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