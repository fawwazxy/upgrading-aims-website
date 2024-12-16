<?
	include "../model/perbelanjaan_functions.php";

	$id = ($_POST['id']);

	$nama_penerima = ($_POST['nama_penerima']);
	$notel_penerima = ($_POST['notel_penerima']);


	echo $result = editNamaPenerima($nama_penerima, $notel_penerima, $id);
  

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