<?php
   	include "../model/support_function.php";
    
	
	
	$no_staff = ($_GET['no_staff']);

	$status_tindakan = ($_POST['status_tindakan']);

	$id = ($_GET['id']);

	
	

	 $result = updateStatusST($status_tindakan,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/developer_support_belum_selesai.php?no_staff=$no_staff';
            </script>");
		//header("location: ../view/developer_support_belum_selesai.php?no_staff=$no_staff");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>
