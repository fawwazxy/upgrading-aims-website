
<?php
   	include "../model/project_management_function.php";


   $id=$_GET['id'];

   $id_projek=($_GET['id_projek']);
// $id_ahli=($_GET['id_ahli']);
$nama_ahli=($_POST['nama_ahli']);
    $id_peranan=($_POST['id_peranan']);
    
	echo $result = editAhliProjek($id_peranan,$nama_ahli,$id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_kumpulan_add.php?id=$id_projek';
						</script>");
		//header("location: ../view/ahli_kumpulan_add.php?id=$id_projek");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>