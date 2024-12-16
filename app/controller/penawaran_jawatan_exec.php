<?php

    include "../model/pemohon_functions.php";
	
	$company_id=($_POST['company_id']);
	$no_staff = ($_POST['no_staff']);
	$role=($_POST['role']);
    //$keterangan=($_POST['keterangan']);
	$keterangan=$_POST['catatancode'];
	$keterangan = str_replace('^)·(', '(', $keterangan);
    $keterangan = str_replace('=?¿¡12', '{', $keterangan);
    $keterangan = str_replace('++ççcsacsa', '<', $keterangan);
	$tarikh_mula=($_POST['tarikh_mula']);
    $tarikh_akhir=($_POST['tarikh_akhir']);
    //$status=$_POST['status'];
	//$id = $_POST['id'];
	
	$result =  addPenawaranJawatan2($role,$keterangan,$tarikh_mula,$tarikh_akhir,$company_id);
  

	//Create UPDATE query
	
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/penawaran_jawatan.php?no_staff=$no_staff';
            </script>");
		//header("location: ../view/penawaran_jawatan.php?no_staff=$no_staff");
		exit();
	} else {
		die("Query failed");
	}
	
	
?>
