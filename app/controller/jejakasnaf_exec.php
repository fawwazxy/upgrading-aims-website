<?php

include "../model/jejakasnaf_functions.php";
	
	$action=clean($_POST['action']);
	//jejakasnaf pentadbir - start-
	if($action == "pentadbirAdd"){
		$id = clean($_POST['id']);
		$nama = clean($_POST['nama']);
		$notel = clean($_POST['notel']);
		$emel = clean($_POST['emel']);
		$id_pengguna = clean($_POST['id_pengguna']);
		$katalaluan = clean($_POST['katalaluan']);
		$acc_type = clean($_POST['acc_type']);
		$jawatan = clean($_POST['jawatan']);
		$negeri = clean($_POST['negeri']);
		$daerah = clean($_POST['daerah']);
		$status = clean($_POST['status']);

		$result =  pentadbirAdd($id,$nama,$notel,$emel,$id_pengguna,$katalaluan,$acc_type,$jawatan,$negeri,$daerah,$status);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ja_pentadbir_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "pentadbirEdit"){
		$id = clean($_POST['id']);
		$nama = clean($_POST['nama']);
		$notel = clean($_POST['notel']);
		$emel = clean($_POST['emel']);
		$id_pengguna = clean($_POST['id_pengguna']);
		$katalaluan = clean($_POST['katalaluan']);
		$acc_type = clean($_POST['acc_type']);
		$jawatan = clean($_POST['jawatan']);
		$negeri = clean($_POST['negeri']);
		$daerah = clean($_POST['daerah']);

		$result =  pentadbirEdit($id,$nama,$notel,$emel,$id_pengguna,$katalaluan,$acc_type,$jawatan,$negeri,$daerah);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ja_pentadbir_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	//jejakasnaf pentadbir -end-
	
?>