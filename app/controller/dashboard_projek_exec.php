<?php

include "../model/dashboard_projek_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "projekAdd"){
		$kod_projek=clean($_POST['kod_projek']);
		$nama_projek=clean($_POST['nama_projek']);
		$jenis_projek=clean($_POST['jenis_projek']);
		$kod_projek_parent=clean($_POST['kod_projek_parent']);
		$nama_client=clean($_POST['nama_client']);
		$negeri=clean($_POST['negeri']);
		$negara=clean($_POST['negara']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);
		$catatan=clean($_POST['catatan']);
		$created_by=clean($_POST['created_by']);

		$result =  projekAdd($kod_projek,$nama_projek,$jenis_projek,$kod_projek_parent,$nama_client,$negeri,$negara,$tarikh_mula,$tarikh_tamat,$catatan,$created_by);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/dashboard_projek_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "projekEdit"){
		$id_projek=clean($_POST['id_projek']);
		$nama_projek=clean($_POST['nama_projek']);
		$jenis_projek=clean($_POST['jenis_projek']);
		$kod_projek_parent=clean($_POST['kod_projek_parent']);
		$nama_client=clean($_POST['nama_client']);
		$negeri=clean($_POST['negeri']);
		$negara=clean($_POST['negara']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);
		$catatan=clean($_POST['catatan']);

		$result =  projekEdit($id_projek,$nama_projek,$jenis_projek,$kod_projek_parent,$nama_client,$negeri,$negara,$tarikh_mula,$tarikh_tamat,$catatan);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/dashboard_projek_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	
?>