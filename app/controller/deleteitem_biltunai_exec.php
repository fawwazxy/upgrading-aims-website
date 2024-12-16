<?php

include "../model/niaga_function.php";





 $id_bil_tunai=($_GET['id_bil_tunai']);

 $id=($_GET['id']);

	$result =  deleteBiltunai($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/bil_tunai_add_item.php?id_bil_tunai=$id_bil_tunai';
						</script>");
		//header("location: ../view/bil_tunai_add_item.php?id_bil_tunai=$id_bil_tunai");
		exit();
	}else {
		die("Query failed");
	}
?>













?>