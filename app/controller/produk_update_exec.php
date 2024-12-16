<?php
   	include "../model/surat_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
    $id = clean($_GET['id']); 	
	$code = clean($_POST['code']);
	$produk = clean($_POST['produk']);
	$penerangan = clean($_POST['penerangan']); 
	
    	
	
	
	//$id = ($_POST['id']);

	echo $result = updateProduk($id,$code,$produk,$penerangan);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_produk.php';
            </script>");
		//header("location: ../view/senarai_produk.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>