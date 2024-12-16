
<?php

include "../model/niaga_function.php";
	



    $id_bil_tunai=($_GET['id_bil_tunai']);

    $jumlah_bil_tunai=($_GET['jumlah_bil_tunai']);
  


	$result = updateTotalBiltunai($jumlah_bil_tunai,$id_bil_tunai);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/niaga_bil_tunai.php';
                    </script>");
		//header("location: ../view/niaga_bil_tunai.php");
	exit();
	}else {
		die("Query failed");
	}
?>