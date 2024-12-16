<?php
   	include "../model/support_function.php";
    
	
	
	$no_staff = ($_GET['no_staff']);

	$status_tindakan = ($_POST['status_tindakan']);

	$id = ($_GET['id']);

	
	

	 $result = updateStatusSelesai($status_tindakan,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/list_support_semakan_terakhir.php';
				            </script>");
		//header("location: ../view/list_support_selesai.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>
