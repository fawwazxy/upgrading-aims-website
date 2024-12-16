<?php

include "../model/ahli_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "kelabPersatuanAdd"){
		$nama = clean($_POST['nama']);
		$alamat = clean($_POST['alamat']);
		$tel = clean($_POST['tel']);
		$email = clean($_POST['email']);
		$nama_pengerusi = clean($_POST['nama_pengerusi']);
		$status = clean($_POST['status']);
		$nama_bank = clean($_POST['nama_bank']);
		$no_akaun = clean($_POST['no_akaun']);
		if($_FILES['logo']['size'] > 0) {
			$image_document = $_FILES['logo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$logo_filename = $_FILES['logo']['name'];
		}
		else {
			$imgContent_doc = "";
			$logo_filename = "";
		}

		$result =  kelabPersatuanAdd($nama,$alamat,$tel,$email,$nama_pengerusi,$status,$nama_bank,$no_akaun,$imgContent_doc,$logo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ahli_konfigurasi_kelab_persatuan.php';
            </script>");
			// //header("location: ../view/lawatan_pelawat_senarai.php");
			// exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "kelabPersatuanEdit"){
		$id = clean($_POST['id']);
		$nama = clean($_POST['nama']);
		$alamat = clean($_POST['alamat']);
		$tel = clean($_POST['tel']);
		$email = clean($_POST['email']);
		$nama_pengerusi = clean($_POST['nama_pengerusi']);
		$nama_bank = clean($_POST['nama_bank']);
		$no_akaun = clean($_POST['no_akaun']);
		if($_FILES['logo']['size'] > 0) {
			$image_document = $_FILES['logo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$logo_filename = $_FILES['logo']['name'];
		}
		else {
			$imgContent_doc = "";
			$logo_filename = "";
		}

		$result =  kelabPersatuanEdit($id,$nama,$alamat,$tel,$email,$nama_pengerusi,$nama_bank,$no_akaun,$imgContent_doc,$logo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ahli_konfigurasi_kelab_persatuan.php';
            </script>");
			//header("location: ../view/lawatan_pelawat_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	
?>