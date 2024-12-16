<?php

include "../model/projek_internal_task_functions.php";
	
$action=clean($_POST['action']);
if($action == "AddEditProjek"){
		$id=clean($_POST['id']);
		$kod_projek=clean($_POST['kod_projek']);
		$sub_projek=clean($_POST['sub_projek']);
		$tajuk=clean($_POST['tajuk']);
		$assigned_by=clean($_POST['assigned_by']);
		$assigned_to=clean($_POST['assigned_to']);
		$task_based=clean($_POST['task_based']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);
		$catatan=$_POST['catatancode'];
		$catatan = str_replace('^)·(', '(', $catatan);
        $catatan = str_replace('=?¿¡12', '{', $catatan);
        $catatan = str_replace('++ççcsacsa', '<', $catatan);
        //echo ''. $catatan . '';

		$slack=clean($_POST['slack']);
		
		
		$result = taskAddEdit($id,$kod_projek,$sub_projek,$tajuk,$assigned_by,$assigned_to,$task_based,$tarikh_mula,$tarikh_tamat,$catatan,$slack);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/projek_internal_senarai_task.php';
            </script>");
		//header("location: ../view/projek_internal_senarai_task.php");
		exit();
	}else {
		die("Query failed");
	}
}
else if($action == "catatan_progress"){
		$id=clean($_POST['id']);
		$jenis_catatan=clean($_POST['jenis_catatan']);
		$catatan=$_POST['catatancode'];
		$catatan = str_replace('^)·(', '(', $catatan);
        $catatan = str_replace('=?¿¡12', '{', $catatan);
        $catatan = str_replace('++ççcsacsa', '<', $catatan);
		



		$result = kemaskiniCatatanProgress($id,$catatan,$jenis_catatan);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/projek_internal_senarai_task.php';
            </script>");
		//header("location: ../view/projek_internal_senarai_task.php");
		exit();
	}else {
		die("Query failed");
	}
}
		
?>		
	