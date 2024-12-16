<?php
   	include "../model/support_function.php";
    
	
	
	
	$status_aduan = ($_POST['status_aduan']);
		$status_aduan = ($_POST['status_developer']);

	$id = ($_GET['id']);

	
	

	 $result = updateStatusTerima($status_aduan,$status_developer,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/developer_support.php?no_staff=$no_staff';
                    </script>");
		//header("location: ../view/developer_support.php?no_staff=$no_staff");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>
