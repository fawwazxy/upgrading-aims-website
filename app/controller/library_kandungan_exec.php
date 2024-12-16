<?php

include "../model/library_functions.php";
	
$action=clean($_POST['action']);
if($action == "libraryAddEdit"){
	$id=clean($_POST['id']);
	$id_jenis=clean($_POST['id_jenis']);
	$nama=clean($_POST['nama']);
	$topik=clean($_POST['topik']);
	$subtopic=clean($_POST['subtopic']);
	$keterangan=clean($_POST['keterangan']);
	$penerbit=clean($_POST['penerbit']);
	$tahun_terbitan=clean($_POST['tahun_terbitan']);
	$pengarang=clean($_POST['pengarang']);
	$isbn=clean($_POST['isbn']);
	$bil_naskah_hardcopy=clean($_POST['bil_naskah_hardcopy']);
	$lokasi_fizikal_hardcopy=clean($_POST['lokasi_fizikal_hardcopy']);
	$created_by=clean($_POST['created_by']);
	$bilangan=clean($_POST['bilangan']);
	$status_naskah=clean($_POST['status_naskah']);
	$status_pinjam=clean($_POST['status_pinjam']);
	$status_naskah_sebelum=clean($_POST['status_naskah_sebelum']);
	//upload frontpage
	$targetFrontpage = "../../elibrary/frontpage/";
	$frontpageAllowType = array('jpg','png','jpeg','gif');
	$frontpageName = basename($_FILES['frontpage_cover_file']['name']);
	$targetFrontpagePath = $targetFrontpage . $frontpageName;
	$frontpageType = pathinfo($targetFrontpagePath,PATHINFO_EXTENSION);
	$frontpage_filename=$id.".".$frontpageType;
	$targetPathFrontpage = $targetFrontpage . $frontpage_filename;
	//upload document file
	$targetDir = "../../elibrary/document/";
	$allowTypes = array('pdf');
	$fileName = basename($_FILES['document_file']['name']);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$document_filename=$id.".".$fileType;
	$targetPath = $targetDir . $document_filename;


	if($id>0){

		if($frontpageName==""){
			$frontpage_filename="";
		}else{
			move_uploaded_file($_FILES["frontpage_cover_file"]["tmp_name"],$targetPathFrontpage);
		}
		if($fileName==""){
			$document_filename="";
		}else{
			move_uploaded_file($_FILES["document_file"]["tmp_name"],$targetPath);
		}
	}else{
		$upload_frontpage = $_FILES["frontpage_cover_file"]["tmp_name"];
		$upload_document = $_FILES["document_file"]["tmp_name"];

	}
	
	$result = libraryAddEdit($id,$id_jenis,$nama,$topik,$subtopic,$keterangan,$penerbit,$tahun_terbitan,$pengarang,$isbn,$bil_naskah_hardcopy,$lokasi_fizikal_hardcopy,$created_by,$bilangan,$status_naskah,$status_pinjam,$frontpage_filename,$document_filename,$targetFrontpage,$targetDir,$upload_frontpage,$upload_document,$frontpageType,$fileType,$status_naskah_sebelum);

	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_kandungan_senarai.php';
            </script>");
		//header("location: ../view/library_kandungan_senarai.php");
		exit();
	}else {
		die("Query failed");
	}

}else if($action == "choosen_print"){
	$id_elibrary=clean($_POST['id_elibrary']);
	//$naskah_ids="";
	
	if(isset($_POST['naskah_ids'])) {
		$naskah_ids = implode(',', $_POST['naskah_ids']);
		$checked_count = count($_POST['naskah_ids']);
		//echo "You have selected following ".$checked_count." option(s): <br/>";
		foreach($_POST['naskah_ids'] as $selected) {
			//echo "<p>".$selected ."</p>";
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_label_cetak.php?id=$id_elibrary&naskah_id=$naskah_ids';
            </script>");
			//header("location: ../view/library_label_cetak.php?id=$id_elibrary&naskah_id=$naskah_ids");
			exit();
		}
		
		//header("location: ../view/library_label_pilihan.php?id=$id_elibrary");

		//$result = roleAccessInactive($role_code);
	}else{
		echo "<script type='text/javascript'>alert('Sila tanda pada kotak yang disediakan.');
		window.location.href='../view/library_label_pilihan.php?id=$id_elibrary'</script>";
    	
		

	}
}else if($action == "upload_terjemahan"){
	$id_elibrary=clean($_POST['id_elibrary']);
	$language_=clean($_POST['language_']);
	//upload document file
	$targetDir = "../../elibrary/document/";
	$allowTypes = array('pdf');
	$fileName = basename($_FILES['document_file']['name']);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$document_filename=$id.".".$fileType;
	$targetPath = $targetDir . $document_filename;

	$upload_document = $_FILES["document_file"]["tmp_name"];
	
	$result = upload_terjemahan($id_elibrary,$language_,$document_filename,$targetDir,$upload_document,$fileType);

	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_kandungan_senarai.php';
            </script>");
		//header("location: ../view/library_kandungan_senarai.php");
		exit();
	}else {
		die("Query failed");
	}

}
		
?>		
	