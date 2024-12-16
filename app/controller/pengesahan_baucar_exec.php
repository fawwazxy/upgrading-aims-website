<?php

include "../model/perbelanjaan_functions.php";
	
	

	$id = ($_GET['id']);
	$status_jawapan = ($_GET['status']); 
	
	$result =  updateStatusPenerimaanBaucarBayaran($id,$status_jawapan);
	
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../template/baucar_bayaran.php?id=$id';
            </script>");
		//header("location: ../template/baucar_bayaran.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>