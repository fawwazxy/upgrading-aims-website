<?php

include "../model/project_management_function.php";




$id_projek=($_GET['id_projek']);
 $id=($_GET['id']);

 //$id=($_GET['id']);

	$result =  deleteJadual($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/jadual_kerja.php?id=$id_projek';
						</script>");
		//header("location: ../view/jadual_kerja.php?id=$id_projek");
		exit();
	}else {
		die("Query failed");
	}
?>













?>