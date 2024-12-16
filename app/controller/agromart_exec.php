<?php

include "../model/agromart_functions.php";
	
	$action=clean($_POST['action']);
	//agromart agensi - start-
	if($action == "agensiAdd"){
		$id = clean($_POST['id']);
		$nama = clean($_POST['nama']);
		$no_pendaftaran = clean($_POST['no_pendaftaran']);
		$notel = clean($_POST['notel']);
		$email = clean($_POST['email']);
		$username = clean($_POST['username']);
		$password = clean($_POST['password']);
		$role = clean($_POST['role']);
		$alamat = clean($_POST['alamat']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
		$status = clean($_POST['status ']);
		$created_by = clean($_POST['created_by']);
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

		$result =  agensiAdd($id,$nama,$no_pendaftaran,$notel,$email,$username,$password,$role,$alamat,$daerah,$negeri,$status,$imgContent_doc,$logo_filename,$created_by);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_agensi_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "agensiEdit"){
		$id = clean($_POST['id']);
		$nama = clean($_POST['nama']);
		$no_pendaftaran = clean($_POST['no_pendaftaran']);
		$notel = clean($_POST['notel']);
		$email = clean($_POST['email']);
		$username = clean($_POST['username']);
		$password = clean($_POST['password']);
		$alamat = clean($_POST['alamat']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
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

		$result =  agensiEdit($id,$nama,$no_pendaftaran,$notel,$email,$username,$password,$alamat,$daerah,$negeri,$imgContent_doc,$logo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_agensi_senarai.php';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	//agromart agensi -end-

	//agromart operator -start-
	else if($action == "operatorAdd"){
		$id = clean($_POST['id']);
		$id_agencies = clean($_POST['id_agencies']);
		$nama = clean($_POST['nama']);
		$nokp = clean($_POST['nokp']);
		$notel = clean($_POST['notel']);
		$umur = clean($_POST['umur']);
		$alamat = clean($_POST['alamat']);
		$username = clean($_POST['username']);
		$password = clean($_POST['password']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
		$jantina = clean($_POST['jantina']);
		$status = clean($_POST['status ']);
		$created_by = clean($_POST['created_by']);
		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$photo_filename = $_FILES['photo']['name'];
		}
		else {
			$imgContent_doc = "";
			$photo_filename = "";
		}

		$result =  operatorAdd($id,$id_agencies,$nama,$nokp,$notel,$umur,$username,$password,$alamat,$daerah,$negeri,$jantina,$status,$imgContent_doc,$photo_filename,$created_by);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_operator_senarai.php?id=$id_agencies';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "operatorEdit"){
		$id = clean($_POST['id']);
		$id_agencies = clean($_POST['id_agencies']);
		$nama = clean($_POST['nama']);
		$nokp = clean($_POST['nokp']);
		$notel = clean($_POST['notel']);
		$umur = clean($_POST['umur']);
		$username = clean($_POST['username']);
		$password = clean($_POST['password']);
		$alamat = clean($_POST['alamat']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
		$jantina = clean($_POST['jantina']);
		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$photo_filename = $_FILES['photo']['name'];
		}
		else {
			$imgContent_doc = "";
			$photo_filename = "";
		}

		$result =  operatorEdit($id,$id_agencies,$nama,$nokp,$notel,$umur,$username,$password,$alamat,$daerah,$negeri,$jantina,$imgContent_doc,$photo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_operator_senarai.php?id=$id_agencies';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	//agromart operator -end-

	//agromart pembekal -start-
	else if($action == "pembekalAdd"){
		$id = clean($_POST['id']);
		$id_agencies = clean($_POST['id_agencies']);
		$nama = clean($_POST['nama']);
		$nokp = clean($_POST['nokp']);
		$notel = clean($_POST['notel']);
		$umur = clean($_POST['umur']);
		$alamat = clean($_POST['alamat']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
		$jantina = clean($_POST['jantina']);
		$status = clean($_POST['status ']);
		$created_by = clean($_POST['created_by']);
		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$photo_filename = $_FILES['photo']['name'];
		}
		else {
			$imgContent_doc = "";
			$photo_filename = "";
		}

		$result =  pembekalAdd($id,$id_agencies,$nama,$nokp,$notel,$umur,$alamat,$daerah,$negeri,$jantina,$status,$imgContent_doc,$photo_filename,$created_by);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_pembekal_senarai.php?id=$id_agencies';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}

	else if($action == "pembekalEdit"){
		$id = clean($_POST['id']);
		$id_agencies = clean($_POST['id_agencies']);
		$nama = clean($_POST['nama']);
		$nokp = clean($_POST['nokp']);
		$notel = clean($_POST['notel']);
		$umur = clean($_POST['umur']);
		$alamat = clean($_POST['alamat']);
		$daerah = clean($_POST['daerah']);
		$negeri = clean($_POST['negeri']);
		$jantina = clean($_POST['jantina']);
		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
			$documentAllowType = array('jpg','png','jpeg','gif');
			$imgContent_doc = addslashes(file_get_contents($image_document));
	    	$photo_filename = $_FILES['photo']['name'];
		}
		else {
			$imgContent_doc = "";
			$photo_filename = "";
		}

		$result =  pembekalEdit($id,$id_agencies,$nama,$nokp,$notel,$umur,$alamat,$daerah,$negeri,$jantina,$imgContent_doc,$photo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_pembekal_senarai.php?id=$id_agencies';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	//agromart pembekal -end-

	//agromart pembekal hasiltani -start-
	else if($action == "pembekalHasilTaniAddEdit"){
		$id = clean($_POST['id']);
		$id_agencies = clean($_POST['id_agencies']);
		$nokp_seller = clean($_POST['nokp_seller']);
		$barcode = clean($_POST['barcode']);
		$status = clean($_POST['status']);
		$created_by = clean($_POST['created_by']);

		deactivePembekalHasilTani($id_agencies,$nokp_seller);

        if(isset($_POST['hasiltani_ids'])){
	    	$checked_hasiltani = count($_POST['hasiltani_ids']);
			//echo "You have selected following ".$checked_hasiltani." option(s): <br/>";
			foreach($_POST['hasiltani_ids'] as $selected_hasiltani) {
				//echo "<p>".$selected_hasiltani." ~ Kuantiti : ".$_POST['kuantiti_vals'.$selected_hasiltani]."</p>";
				$result = pembekalHasilTaniAddEdit($selected_hasiltani,$id_agencies,$nokp_seller,$barcode,$_POST['harga_vals'.$selected_hasiltani],$status,$_POST['kuantiti_vals'.$selected_hasiltani],$created_by);
			}
    	}
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/agromart_admin_pembekal_hasiltani_senarai.php?id=$id&id_agencies=$id_agencies&nokp=$nokp_seller';
						</script>");
			//header("location: ../view/dashboard_projek_senarai.php");
			exit();
		}else {
			echo ("<script LANGUAGE='JavaScript'>
			alert('Sila tanda pada ruangan pilihan yang disediakan.');
			window.location.href='../view/agromart_admin_pembekal_hasiltani_tambah.php?id=$id&id_agencies=$id_agencies&nokp_seller=$nokp_seller';
			</script>");
			// die("Query failed");
		}
	}
	//agromart pembekal hasiltani -end-
	
?>