<?php

include "../model/project_management_function.php";




$id_projek=($_GET['id_projek']);
 $id_peranan=($_GET['id_peranan']);

 //$id=($_GET['id']);

	$result =  deletePerananProjek($id_peranan);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/struktur_kerja.php?id=$id_projek';
						</script>");
		//header("location: ../view/struktur_kerja.php?id=$id_projek");
		exit();
	}else {
		die("Query failed");
	}
?>













?>