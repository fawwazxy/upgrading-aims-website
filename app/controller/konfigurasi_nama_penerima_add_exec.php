<?
	include "../model/perbelanjaan_functions.php";
	
	$nama_penerima = ($_POST['nama_penerima']);
	$notel_penerima = ($_POST['notel_penerima']);

	echo $result = addNamaPenerima($nama_penerima, $notel_penerima);

	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_nama_penerima.php';
            </script>");
		//header("location: ../view/konfigurasi_nama_penerima.php");
		exit();
	}else
	{
		die("Query failed");
	}
?>