
<?php

include "../model/project_management_function.php";


	$id=$_GET['id'];
	// $peringkat_id=($_POST['agensi_rujukan']);
	//$id_peranan=($_POST['id_peranan']);
    $id_projek=($_POST['id_projek']);
    $nama_ahli=($_POST['nama_ahli']);
    $id_peranan=($_POST['id_peranan']);

    

    

    
   

	
    

	$result =  addAhliProjek($id_projek,$nama_ahli,$id_peranan);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_kumpulan_add.php?id=$id';
						</script>");
		//header("location: ../view/ahli_kumpulan_add.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>


