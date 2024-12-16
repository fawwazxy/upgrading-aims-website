<?php

include "../model/tarikh_bekerja_functions.php";
	
	$action=clean($_GET['action']);
	
	if($action == "editStatus"){
		$tarikh_ids=$_POST['tarikh_ids'];
		$no_staff=clean($_GET['no_staff']);
		$id=clean($_GET['id']);
		$shift_code=clean($_GET['shift_code']);
			foreach($tarikh_ids as $tarikh_id){
				
				$result = updateShift($tarikh_id,$shift_code);
			}


		
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/penentuan_shift_bekerja_staf.php?id=$id&no_staff=$no_staff';
				            </script>");
		//header("location: ../view/penentuan_tarikh_bekerja.php");
		exit();
		
	}else if($action == "editStatusByBahagian"){
		$tarikh_ids=$_POST['tarikh_ids'];
		$kod_bahagian=clean($_GET['bahagian']);
		$id=clean($_GET['id']);
		$shift_code=clean($_GET['shift_code']);
			foreach($tarikh_ids as $tarikh_id){
				
				$result = updateShiftBahagian($tarikh_id,$shift_code,$kod_bahagian);
			}


		
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/penentuan_shift_bekerja_bahagian.php?id=$id';
				            </script>");
		//header("location: ../view/penentuan_tarikh_bekerja.php");
		exit();
		
	}