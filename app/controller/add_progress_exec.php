<?php
   	include "../model/support_function.php";
    
	
	$id_support = ($_GET['id']);
 
	$tarikh = ($_POST['tarikh']);
	$catatan = ($_POST['catatan']);
	$created_by_progress = ($_POST['created_by_progress']);

	
	

	

	 $result =addProgress($id_support,$tarikh,$catatan,$created_by_progress);
	
	//Check whether the query was successful or not
	if($result)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/list_progress.php?id=$id_support';
						</script>");
		//header("location: ../view/list_progress.php?id=$id_support");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









