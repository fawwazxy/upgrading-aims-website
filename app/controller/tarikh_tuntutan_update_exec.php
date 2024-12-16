
<?php

include "../model/claim_function.php";
	
	
    $tarikh_mula_tuntutan=clean($_POST['tarikh_mula_tuntutan']);
    $tarikh_akhir_tuntutan=clean($_POST['tarikh_akhir_tuntutan']);
\


	$result =  updateTarikhTuntutan($tarikh_mula_tuntutan,$tarikh_akhir_tuntutan);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/tarikh_tuntutan.php';
                    </script>");
		//header("location: ../view/tarikh_tuntutan.php?");
		exit();
	}else {
		die("Query failed");
	}
?>