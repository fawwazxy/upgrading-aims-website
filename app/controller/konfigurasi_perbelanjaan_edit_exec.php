<?
	include "../model/perbelanjaan_functions.php";

	$id = ($_POST['id']);

	$description = ($_POST['description']);


	echo $result = editNamaPerbelanjaan($description, $id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_perbelanjaan.php';
            </script>");
		//header("location: ../view/konfigurasi_perbelanjaan.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>