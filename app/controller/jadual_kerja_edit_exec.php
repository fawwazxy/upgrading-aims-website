
<?php
   	include "../model/project_management_function.php";


   $id=$_GET['id'];

   $id_projek=($_GET['id_projek']);
// $id_ahli=($_GET['id_ahli']);
$fasa=($_POST['fasa']);
    $mula=($_POST['mula']);
    $akhir=($_POST['akhir']);
    $mula_sebenar=($_POST['mula_sebenar']);
    $akhir_sebenar=($_POST['akhir_sebenar']);
    
	echo $result = editJadualProjek($fasa,$mula,$akhir,$mula_sebenar,$akhir_sebenar,$id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/jadual_kerja.php?id=$id_projek';
            </script>");
		//header("location: ../view/jadual_kerja.php?id=$id_projek");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>