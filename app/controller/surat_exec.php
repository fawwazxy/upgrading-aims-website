<?php
   	include "../model/surat_function.php";
	
	
    $word=clean($_POST['surat']);
	$produk=clean($_POST['produk']);
	$lead=clean($_POST['lead']);
    
				
				$surat = getSuratInformation($word);
	

    echo $result = addsurat($word,$produk,$lead);
	
	
	
	if($result)
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/senarai_surat_janaan.php';
				            </script>");
	//header("location: ../view/senarai_surat_janaan.php");
	exit();
	}
	
	{
		die("Query failed");
	}
	
?>