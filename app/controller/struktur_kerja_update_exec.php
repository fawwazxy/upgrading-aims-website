
<?php
   	include "../model/project_management_function.php";


//    $id=$_GET['id'];

//    $id_projek=($_GET['id_projek']);
// // $id_ahli=($_GET['id_ahli']);
// $nama_ahli=($_POST['nama_ahli']);
//     $peranan_projek=($_POST['peranan_projek']);

     $id=$_GET['id'];

   $id_projek=($_GET['id_projek']);
 //$id_peranan=($_GET['id_peranan']);

    $nama_peranan=($_POST['nama_peranan']);
    $id_peringkat=($_POST['id_peringkat']);

    echo $result = editPerananProjek2($nama_peranan,$id_peringkat,$id);
	
    
	// echo $result = editAhliProjek($peranan_projek,$nama_ahli,$id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/struktur_kerja.php?id=$id_projek';
				            </script>");
		//header("location: ../view/struktur_kerja.php?id=$id_projek");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>