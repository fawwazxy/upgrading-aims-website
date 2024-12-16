<?php

include "../model/claim_function.php";





 $id_projek=($_GET['id_projek']);

 $id=($_GET['id']);

	$result =  deleteTuntutan($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/nama_tuntutan.php';
						</script>");
		//header("location: ../view/nama_tuntutan.php");
		exit();
	}else {
		die("Query failed");
	}
?>













?>