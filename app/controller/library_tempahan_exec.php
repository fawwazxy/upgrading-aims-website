<?php

include "../model/library_functions.php";
	
$action=clean($_POST['action']);

if($action == "addEditTempahan"){
		$status=clean($_POST['status']);
		$id_library=clean($_POST['id_library']);
		$id_tempahan=clean($_POST['id_tempahan']);
		$nokp=clean($_POST['nokp']);
		$nama=clean($_POST['nama']);
		$notel=clean($_POST['notel']);
		$status_urgent=clean($_POST['status_urgent']);
		$anggaran_tarikh_tempah=clean($_POST['anggaran_tarikh_tempah']);
		
		
		$result = tempahanAddEdit($id_tempahan,$id_library,$nokp,$nama,$notel,$status_urgent,$anggaran_tarikh_tempah);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_tempahan_senarai.php?status=$status';
            </script>");
		//header("location: ../view/library_tempahan_senarai.php?status=$status");
		exit();
	}else {
		die("Query failed");
	}
}else 
if($action == "tempahanTambah"){
		$id_library=clean($_POST['id_library']);
		$status=clean($_POST['status']);
		$nokp=clean($_POST['nokp']);
		$status_urgent=clean($_POST['status_urgent']);
		$anggaran_tarikh_tempah=clean($_POST['anggaran_tarikh_tempah']);
		$result = tempahanTambah($id_library,$status,$nokp,$status_urgent,$anggaran_tarikh_tempah);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_pinjaman_senarai.php';
            </script>");
		//header("location: ../view/library_pinjaman_senarai.php");
		exit();
	}else {
		die("Query failed");
	}
}
?>