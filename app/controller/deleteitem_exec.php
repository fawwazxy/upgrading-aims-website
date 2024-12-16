<?php

include "../model/niaga_function.php";





 $id_sebut_harga=($_GET['id_sebut_harga']);

 $id=($_GET['id']);

	$result =  deleteSebutHarga($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/sebut_harga_add_item.php?id_sebut_harga=$id_sebut_harga';
						</script>");
		//header("location: ../view/sebut_harga_add_item.php?id_sebut_harga=$id_sebut_harga");
		exit();
	}else {
		die("Query failed");
	}
?>













?>