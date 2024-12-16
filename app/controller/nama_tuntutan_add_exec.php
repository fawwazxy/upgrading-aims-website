
<?php

include "../model/claim_function.php";
	
    $nama_tuntutan=($_POST['nama_tuntutan']);
    $code=($_POST['code']);

	$result =  addTuntutan($nama_tuntutan,$code);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/jenis_tuntutan.php';
						</script>");
		//header("location: ../view/jenis_tuntutan.php");
		exit();
	}else {
		die("Query failed");
	}
?>


