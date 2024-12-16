
<?php

include "../model/niaga_function.php";
	



    $id_sebut_harga=($_GET['id_sebut_harga']);

    $jumlah_sebut_harga=($_GET['jumlah_sebut_harga']);
  


	echo $result = updateTotalSebutHarga($jumlah_sebut_harga,$id_sebut_harga);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/niaga_sebut_harga.php';
                    </script>");
		//header("location: ../view/niaga_sebut_harga.php");
	exit();
	}else {
		die("Query failed");
	}
?>