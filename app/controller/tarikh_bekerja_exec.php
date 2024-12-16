<?php

include "../model/tarikh_bekerja_functions.php";
	
	$action=clean($_GET['action']);
	$no_staff=clean($_GET['no_staff']);
	$id=clean($_GET['id']);
	if($action == "jana_tarikh"){
		
		$date = date('Y').'-01-01';
		
		$end_date = date('Y').'-12-31';
		$sys_id='1';
	    
	     janaHujungMinggu($sys_id,$no_staff);

		while (strtotime($date) <= strtotime($end_date)) {
			$hari=date("l", strtotime($date));
			$hari_minggu = getStatusHujungMinggu($hari,$no_staff)->fetch_assoc();
			if($hari_minggu['status']=='1'){
				$status='0';
			}else{
				$status='1';
			}
					$result = janaTarikh($sys_id,$date,$status,$no_staff);
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/penentuan_tarikh_bekerja_staff.php?id=$id&no_staff=$no_staff';
				            </script>");
			//header("location: ../view/penentuan_tarikh_bekerja.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "editStatus"){
		$tarikh_ids=$_POST['tarikh_ids'];
		$no_staff=clean($_GET['no_staff']);
		$id=clean($_GET['id']);
		if(empty($tarikh_ids)) {
			$result = tarikhBekerjaInactive(date('Y'),$no_staff);
		}else {
			
			tarikhBekerjaInactive(date('Y'),$no_staff);

			foreach($tarikh_ids as $tarikh_id){
				
				$result = tarikhBekerjaActive($tarikh_id);
			}


		}
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/penentuan_tarikh_bekerja_staff.php?id=$id&no_staff=$no_staff';
				            </script>");
		//header("location: ../view/penentuan_tarikh_bekerja.php");
		exit();
		
	}else if($action == "editStatusHujungMinggu"){
		$hari_ids=$_POST['hari_ids'];
		$no_staff=clean($_GET['no_staff']);
		$id=clean($_GET['id']);
		$endDate = date(Y).'-12-31';
		if(empty($hari_ids)) {
			$result = tarikhHujungMingguInactive($no_staff);
		}else {
			
			tarikhHujungMingguInactive($no_staff);
			updateStatusHariBekerjaActive($endDate,$no_staff);

			foreach($hari_ids as $hari_id){
				$hari=getHariById($hari_id);
				updateStatusHariBekerjaInactive($hari,$endDate,$no_staff);
				$result = tarikhHujungMingguActive($hari_id);
			}


		}
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/penentuan_tarikh_bekerja_staff.php?id=$id&no_staff=$no_staff';
				            </script>");
		//header("location: ../view/penentuan_hujung_minggu.php");
		exit();
		
	}else if($action == "jana_tarikh_semua"){
		$cawangan_kod=clean($_GET['cawangan_kod']);
		$jabatan_kod=clean($_GET['jabatan_kod']);
		
		$sys_id='1';
	    $data_staff = getStafTarikhBekerja($cawangan_kod,$jabatan_kod) ;
		while($row_data_staff = $data_staff->fetch_assoc()) {
	     janaHujungMinggu($sys_id,$row_data_staff['no_staff']);
	     $date = date('Y').'-01-01';
		 $end_date = date('Y').'-12-31';

		while (strtotime($date) <= strtotime($end_date)) {
			$hari=date("l", strtotime($date));
			$hari_minggu = getStatusHujungMinggu($hari,$row_data_staff['no_staff'])->fetch_assoc();
			if($hari_minggu['status']=='1'){
				$status='0';
			}else{
				$status='1';
			}
					$result = janaTarikh($sys_id,$date,$status,$row_data_staff['no_staff']);
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}
	}
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/konfigurasi_tarikh_bekerja.php';
				            </script>");
			//header("location: ../view/penentuan_tarikh_bekerja.php");
			exit();
		}else {
			die("Query failed");
		}
	}