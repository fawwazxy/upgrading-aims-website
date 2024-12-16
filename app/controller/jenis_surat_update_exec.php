<?php
   	include "../model/surat_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
    $id =$_GET['id'];
	$code = clean($_POST['code']);
	$surat = clean($_POST['surat']);
	
	
	
	
    	
	
	
	//$id = ($_POST['id']);

	echo $result = updateJenisSurat($id,$code,$surat);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_jenis_surat.php';
            </script>");
		//header("location: ../view/senarai_jenis_surat.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>