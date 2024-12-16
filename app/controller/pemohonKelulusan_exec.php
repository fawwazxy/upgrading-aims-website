<?php

include "../model/pemohon_functions.php";
    $act = $_GET['act'];
	$gaji_dipersetujui = ($_POST['gaji_dipersetujui']);
	$status_pemohon = ($_POST['status_pemohon']);
	$catatan = ($_POST['catatan']);
	$pemohon_id = ($_GET['pemohon_id']); 
	$tarikh_mula= ($_POST['tarikh_mula']);
	
	$no_rujukan = ($_POST['no_rujukan']);
	$tarikh_rujukan = ($_POST['tarikh_rujukan']);
	$nomatrik = ($_POST['nomatrik']);
	$program = ($_POST['program']);
	$tempoh = ($_POST['tempoh']);
	
	$result = updateKelulusan($pemohon_id,$gaji_dipersetujui,$status_pemohon,$catatan,$tarikh_mula,$no_rujukan,$tarikh_rujukan,$nomatrik,$program,$tempoh);
    

	//Create UPDATE query
	
	//Check whether the query was successful or not
	if($result) {
		if ($act=='bypass') {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pemohon_senarai.php?statact=IV';
            </script>");
		//header("location: ../view/pemohon_senarai.php?statact=IV");
		}
		else {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/kelulusan_pemohon.php?pemohon_id=$pemohon_id';
            </script>");
		//header("location: ../view/kelulusan_pemohon.php?pemohon_id=".$pemohon_id);
		}    
		exit();
	}else {
		die("Query failed");
	}
?>