<?php
   	include "../model/aims_ot_function.php";
    
	
	
	$id = ($_GET['id']);
	$result = getOtDocInfo($id)->fetch_object();
    $document_name =$result -> document_name;
    $dir = "../../overtimephoto/";
    $file = $dir . $document_name;


	 $result =deleteOt($id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
	    unlink($file);
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









