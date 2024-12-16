<?php

include "../model/aims_others_claim_function.php";




$id=($_GET['id']);
 $result = getOClaimInfo($id)->fetch_object();
    $document_name =$result -> document_name;
    $dir = "../../othersclaimphoto/";
    $file = $dir . $document_name;

 //$id=($_GET['id']);

	$result =  DeletePassword($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
	    unlink($file);
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_others_claim_list.php';
						</script>");
		//header("location: ../view/ahli_kumpulan_add.php?id=$id_projek");
		exit();
	}else {
		die("Query failed");
	}
?>
