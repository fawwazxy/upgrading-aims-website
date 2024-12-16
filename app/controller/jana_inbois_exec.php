
<?php

include "../model/niaga_function.php";
	
    $id_sebut_harga=($_GET['id_sebut_harga']);
    
    $shortcode=($_GET['shortcode']);




	echo $result =getJanaInbois($id_sebut_harga,$shortcode);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/niaga_inbois.php';
            </script>");
		//header("location: ../view/niaga_inbois.php");
	exit();
	}else {
		die("Query failed");
	}
?>