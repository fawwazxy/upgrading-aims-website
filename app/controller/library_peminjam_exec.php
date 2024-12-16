<?php

include "../model/library_functions.php";
	
$action=clean($_POST['action']);

if($action == "addEditPeminjam"){
		$status=clean($_POST['status']);
		$id_library=clean($_POST['id_library']);
		$id_peminjam=clean($_POST['id_peminjam']);
		$nokp=clean($_POST['nokp']);
		$nama=clean($_POST['nama']);
		$notel=clean($_POST['notel']);
		$tarikh_pinjam=clean($_POST['tarikh_pinjam']);
		$bil_hari_pinjam=clean($_POST['bil_hari_pinjam']);
		$created_by=clean($_POST['created_by']);
		
		if($status == 1){
			$tarikh_hantar=clean($_POST['tarikh_hantar']);
		}
		else {
			$tarikh_hantar = '';
		}
		$result = peminjamAddEdit($id_peminjam,$id_library,$nokp,$nama,$notel,$tarikh_pinjam,$tarikh_hantar,$bil_hari_pinjam,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_pinjaman_senarai.php';
            </script>");
		//header("location: ../view/library_pinjaman_senarai.php");
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "tempahanAddPinjaman"){
	$id_tempahan=clean($_POST['id_tempahan']);
	$id_naskah=clean($_POST['id_naskah']);
	$nokp=clean($_POST['nokp']);
	$tarikh_pinjam=clean($_POST['tarikh_pinjam']);
	$bil_hari_pinjam=clean($_POST['bil_hari_pinjam']);
	$created_by=clean($_POST['created_by']);
	$result = tempahanAddPinjaman($id_tempahan,$id_naskah,$nokp,$tarikh_pinjam,$bil_hari_pinjam,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_tempahan_pinjam.php';
            </script>");
		//header("location: ../view/library_tempahan_pinjam.php");
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "updateTarikhHantar"){
		$status=1;
		$tarikh_hantar=clean($_POST['tarikh_hantar']);
		$id_pinjaman=clean($_POST['id_pinjaman']);
		$created_by=clean($_POST['created_by']);
		
		$result = updateTarikhHantar($id_pinjaman,$tarikh_hantar,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_pemulangan_senarai.php?status=$status';
            </script>");
		//header("location: ../view/library_pemulangan_senarai.php?status=$status");
		exit();
	}else {
		die("Query failed");
	}
}
?>