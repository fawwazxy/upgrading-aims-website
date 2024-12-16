<?php

include "../model/project_management_function.php";




$id_projek=($_GET['id_projek']);
 $id_peranan=($_GET['id_peranan']);

 //$id=($_GET['id']);

	$result =  deleteAhliProjek($id_peranan);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_kumpulan_add.php?id=$id_projek';
						</script>");
		//header("location: ../view/ahli_kumpulan_add.php?id=$id_projek");
		exit();
	}else {
		die("Query failed");
	}
?>













?>