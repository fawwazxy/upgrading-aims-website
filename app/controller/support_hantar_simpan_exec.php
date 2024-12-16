<?php
   	include "../model/support_function.php";
    
	
  
	
	$status_tindakan = ($_POST['status_tindakan']);
	$id = ($_GET['id']);

	
	

	 $result = updateStatusSupportHantarSimpan($status_tindakan,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/list_support_belum_disahkan.php';
				            </script>");
		//header("location: ../view/list_support_belum_disahkan.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









