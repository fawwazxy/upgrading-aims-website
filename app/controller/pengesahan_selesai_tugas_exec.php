<?php

include "../model/project_management_function.php";
	
	

	$id = ($_GET['id']);
	 $no_staff = ($_GET['no_staff']); 
	// $tarikh_jawapan = ($_GET['tarikh']); 
	
	$result = updateStatusSelesaiKerja($id);
	
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_projek_yang_telah_selesai.php?no_staff=$no_staff';
            </script>");
		//header("location: ../view/senarai_projek_yang_telah_selesai.php?no_staff=$no_staff");
		exit();
	}else {
		die("Query failed");
	}
?>