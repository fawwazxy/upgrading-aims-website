<?php

include "../model/niaga_function.php";
	
	

	$id = ($_GET['id']);
	$status_jawapan = ($_GET['status']); 
	$tarikh_jawapan = ($_GET['tarikh']); 
	
	$result = updateStatusPenerimaanBiltunai($id,$status_jawapan,$tarikh_jawapan);
	
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../template/biltunai.php?id=$id';
            </script>");
		//header("location: ../template/biltunai.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>