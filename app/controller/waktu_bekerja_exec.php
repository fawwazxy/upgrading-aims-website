<?php
   	include "../model/kehadiran_functions.php";
    
	
	//Sanitize the POST values
$action = ($_GET['act']);

if ($action == "waktu_bekerja_add"){
	$masa_bekerja = $_POST['masa_bekerja'];
	$shift_code = $_POST['shift_code'];
	$description = $_POST['description'];
	
	$result = addWaktuBekerja($masa_bekerja,$shift_code,$description);

	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/masa_mula_bekerja.php';
                    </script>");
		//header("location: ../view/masa_mula_bekerja.php");
		exit();
	}else {
		die("Query failed");
	}

} 

else if ($action == "waktu_bekerja_update"){
	$masa_bekerja = clean($_POST['masa_bekerja']);
	$shift_code = clean($_POST['shift_code']);
	$description = clean($_POST['description']);	
	$id_masa_kehadiran = clean($_POST['id_masa_kehadiran']);	
	
	$result = editWaktuBekerja($masa_bekerja,$shift_code,$description,$id_masa_kehadiran);

		if($result > 0){
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/masa_mula_bekerja.php';
                    </script>");
			//header("location: ../view/masa_mula_bekerja.php");
			exit();
		}else{
		die("Query failed");
}

}
else if ($action=='waktu_bekerja_delete'){
	$id_masa_kehadiran=($_GET['id_masa_kehadiran']);
	$result =  deleteWaktuBekerja($id_masa_kehadiran);

	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/masa_mula_bekerja.php';
                    </script>");
		//header("location: ../view/masa_mula_bekerja.php");
		exit();
	}else {
		die("Query failed");
	}
}

	
?>