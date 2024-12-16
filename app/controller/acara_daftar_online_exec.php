<?php

include "../model/acara_functions.php";
	
	$action=clean($_POST['action']);
if($action == "daftarOnline"){                                
		$id_sesi = $_POST['id_sesi'];          
		$nokp = $_POST['nokp'];
		$nama = $_POST['nama'];
		$notel = $_POST['notel'];
		$jawatan = $_POST['jawatan'];
		$kumpulan = $_POST['kumpulan'];
		
		$targetDir = "../../acara/foto_peserta/";
		
		$photo_filename=$nokp.".png";
		$targetPath = $targetDir . $photo_filename;
		move_uploaded_file($_FILES["photo"]["tmp_name"],$targetPath);

		$result = pesertaDaftarOnline($id_sesi,$nokp,$nama,$notel,$kumpulan,$jawatan,$photo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_daftar_online.php?id_sesi=$id_sesi&act=SUCCESS';
						</script>");
			//header("location: ../view/acara_daftar_online.php?id_sesi=$id_sesi&act=SUCCESS");
			exit();
		}else {
			die("Query failed");
		}
		
	}
	
	
?>