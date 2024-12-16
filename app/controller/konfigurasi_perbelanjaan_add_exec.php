<?
	include "../model/perbelanjaan_functions.php";
	
	$description = ($_POST['description']);

	echo $result = addNamaPerbelanjaan($description);

	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_perbelanjaan.php';
            </script>");
		//header("location: ../view/konfigurasi_perbelanjaan.php");
		exit();
	}else
	{
		die("Query failed");
	}
?>