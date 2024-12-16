<?php

include "../model/lawatan_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "pelawatAdd"){
		$nama=clean($_POST['nama']);
		$nokp=clean($_POST['nokp']);
		$notel=clean($_POST['notel']);
		$nokp_staff=clean($_POST['nokp_staff']);
		$nokp_pelawat=clean($_POST['nokp_pelawat']);
		$nama_company=clean($_POST['nama_company']);
		$kod_kad=clean($_POST['kod_kad']);
		$jenis_kenderaan=clean($_POST['jenis_kenderaan']);
		$no_kenderaan=clean($_POST['no_kenderaan']);

		$result =  pelawatAdd($nama,$nokp,$notel,$nokp_staff,$nokp_pelawat,$nama_company,$kod_kad,$jenis_kenderaan,$no_kenderaan);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lawatan_pelawat_senarai.php';
            </script>");
			//header("location: ../view/lawatan_pelawat_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "pelawatEdit"){
		$id_lawatan=clean($_POST['id_lawatan']);
		$nokp_staff=clean($_POST['nokp_staff']);
		$kod_kad=clean($_POST['kod_kad']);
		$jenis_kenderaan=clean($_POST['jenis_kenderaan']);
		$no_kenderaan=clean($_POST['no_kenderaan']);

		$result =  pelawatEdit($id_lawatan,$nokp_staff,$kod_kad,$jenis_kenderaan,$no_kenderaan);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lawatan_pelawat_senarai.php';
            </script>");
			//header("location: ../view/lawatan_pelawat_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "kadPelawatAddEdit"){
		$id_kad=clean($_POST['id_kad']);
		$kod_kad=clean($_POST['kod_kad']);
		$jenis_kad=clean($_POST['jenis_kad']);
		$nama_kad=clean($_POST['nama_kad']);

		$result = kadPelawatAddEdit($id_kad,$kod_kad,$jenis_kad,$nama_kad);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lawatan_kad_senarai.php';
            </script>");
			//header("location: ../view/lawatan_kad_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "kad_cetakan_pilihan"){
		
		if(isset($_POST['kad_pelawat_kods'])) {
			$kad_pelawat_kods = implode(',', $_POST['kad_pelawat_kods']);
			$checked_count = count($_POST['kad_pelawat_kods']);
			//echo "You have selected following ".$checked_count." option(s): <br/>";
			foreach($_POST['kad_pelawat_kods'] as $selected) {
				//echo "<p>".$selected ."</p>";
				echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lawatan_kad_cetak_senarai.php?id_kad=$kad_pelawat_kods';
            </script>");
				//header("location: ../view/lawatan_kad_cetak_senarai.php?id_kad=$kad_pelawat_kods");
				exit();
			}

			//$result = roleAccessInactive($role_code);
		}else{
			echo "<script type='text/javascript'>alert('Sila tanda pada kotak yang disediakan.');
			window.location.href='../view/lawatan_kad_cetak_pilihan.php'</script>";
	    	
			

		}
	}
	
?>