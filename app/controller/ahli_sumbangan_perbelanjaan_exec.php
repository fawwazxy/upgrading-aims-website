<?php

include "../model/ahli_functions.php";
	
$action=clean($_POST['action']);
if($action == "addEditSumbangan"){
		$id=clean($_POST['id']);
		$tarikh=clean($_POST['tarikh']);
		$keterangan=clean($_POST['keterangan']);
		$penyumbang=clean($_POST['penyumbang']);
		$diterima_oleh=clean($_POST['diterima_oleh']);
		$no_rujukan=clean($_POST['no_rujukan']);
		$jumlah=clean($_POST['jumlah']);
		$created_by=clean($_POST['created_by']);
		

		$result = addEditSumbangan($id,$tarikh,$keterangan,$penyumbang,$diterima_oleh,$no_rujukan,$jumlah,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_rekod_sumbangan.php';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}

}else if($action == "addEditPerbelanjaan"){
		$id=clean($_POST['id']);
		$tarikh=clean($_POST['tarikh']);
		$keterangan=clean($_POST['keterangan']);
		$penerima=clean($_POST['penerima']);
		$diuruskan_oleh=clean($_POST['diuruskan_oleh']);
		$no_rujukan=clean($_POST['no_rujukan']);
		$jumlah=clean($_POST['jumlah']);
		$created_by=clean($_POST['created_by']);
		

		$result = addEditPerbelanjaan($id,$tarikh,$keterangan,$penerima,$diuruskan_oleh,$no_rujukan,$jumlah,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_rekod_perbelanjaan.php';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}

}
?>		
	