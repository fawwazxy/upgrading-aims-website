<?php
   	include "../model/support_function.php";
    
	
	$id = ($_GET['id']);
    $nama_projek= $_GET['nama_projek'];

	$level_aduan = ($_POST['level_aduan']);

	
	

	

	 $result =addLevel($level_aduan,$id);
	
	//Check whether the query was successful or not
	if($result)

	
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
