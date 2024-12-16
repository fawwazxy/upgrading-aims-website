
<?php

include "../model/project_management_function.php";


	$id=$_GET['id'];

    $id_projek=($_POST['id_projek']);
    $nama_peranan=($_POST['nama_peranan']);
    $id_peringkat=($_POST['id_peringkat']);

	
    

	$result =  addPerananProjek($id_projek,$nama_peranan,$id_peringkat);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/struktur_kerja.php?id=$id';
				            </script>");
		//header("location: ../view/struktur_kerja.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>


