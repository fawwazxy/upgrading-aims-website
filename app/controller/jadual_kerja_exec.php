
<?php

include "../model/project_management_function.php";


	$id=$_GET['id'];

    $id_projek=($_POST['id_projek']);
    $fasa=($_POST['fasa']);
    $mula=($_POST['mula']);
    $akhir=($_POST['akhir']);
	
    

	$result =  addJadual($id_projek,$fasa,$mula,$akhir);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/jadual_kerja.php?id=$id_projek';
            </script>");
		//header("location: ../view/jadual_kerja.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>


