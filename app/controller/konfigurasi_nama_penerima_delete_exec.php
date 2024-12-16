<?
	include "../model/perbelanjaan_functions.php";

	$id = ($_GET['id']);


	echo $result = deleteNamaPenerima($id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_nama_penerima.php';
            </script>");
		//header("location: ../view/konfigurasi_nama_penerima.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>