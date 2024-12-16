<?php
   	include "../model/support_function.php";
    
	
	$id = ($_GET['id']);
    $nama_projek= $_GET['nama_projek'];
	$developer = ($_POST['developer']);
	$result =addDeveloper($developer,$id);
	
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









