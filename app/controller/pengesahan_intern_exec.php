<?php

include "../model/pemohon_functions.php";
	
	

	$id = ($_GET['id']);
	$status_jawapan = ($_GET['status']); 
	$tarikh_jawapan = ($_GET['tarikh']); 
	
	$result = updateStatusJawapan($id,$status_jawapan,$tarikh_jawapan);
	
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../template/surat_offer_intern_draft.php?id=$id';
            </script>");
		//header("location: ../template/surat_offer_intern_draft.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>