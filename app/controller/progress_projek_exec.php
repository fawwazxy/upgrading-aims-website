
<?php

include "../model/project_management_function.php";


	$id=$_GET['id'];
	$no_staff=$_GET['no_staff'];
    $id_projek=($_POST['id_projek']);
    $jadual_projek_id=($_POST['jadual_projek_id']);
    $tarikh=($_POST['tarikh']);
    $perkembangan=($_POST['perkembangan']);
    $created_by = ($_POST['created_by']);
  
	
    

	$result =  addProgress($id_projek,$tarikh,$perkembangan,$jadual_projek_id,$created_by);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/perkembangan_kerja_individu.php?id=$id&no_staff=$no_staff';
            </script>");
		//header("location: ../view/perkembangan_kerja_individu.php?id=$id&no_staff=$no_staff");
		exit();
	}else {
		die("Query failed");
	}
?>


