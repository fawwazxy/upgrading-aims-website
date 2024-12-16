
<?php

include "../model/niaga_function.php";
	

	
	


$id_sebut_harga = ($_POST['id_sebut_harga']);
$ketua_projek=($_POST['ketua_projek']);




	echo $result = updateKetuaProjek($id_sebut_harga,$ketua_projek);


  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/niaga_sebut_harga.php';
            </script>");
		//header("location: ../view/niaga_sebut_harga.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>