<?php

include "../model/acara_functions.php";
	
$action=clean($_POST['action']);
if($action == "aturcaraAddEdit"){
		$id=clean($_POST['id']);
		$id_sesi=clean($_POST['id_sesi']);
		$tarikh=clean($_POST['tarikh']);
		$masa_mula=clean($_POST['masa_mula']);
		$masa_tamat=clean($_POST['masa_tamat']);
		$tajuk=clean($_POST['tajuk']);
		$kategori=clean($_POST['kategori']);
		$status_lagu_tema=clean($_POST['lagu_tema_status']);
		$rating=clean($_POST['rating']);
		$qna=clean($_POST['qna']);
		$created_by=clean($_POST['created_by']);
		
		$result = aturcaraAddEdit($id,$id_sesi,$tarikh,$masa_mula,$masa_tamat,$tajuk,$kategori,$status_lagu_tema,$rating,$qna,$created_by);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_aturcara.php?id_sesi=$id_sesi';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "add_youtube_link"){
		$id=clean($_POST['id_aturcara']);
		$id_sesi=clean($_POST['id_sesi']);
		$youtube_link=clean($_POST['youtube_link']);
		$result = youtubeLinkEdit($id,$id_sesi,$youtube_link);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_aturcara.php?id_sesi=$id_sesi';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "add_music"){
		$id=clean($_POST['id_aturcara']);
		$id_sesi=clean($_POST['id_sesi']);
		
		$targetDir = "../../acara/lagu_tema/";
		
		$music = basename($_FILES['lagu_tema']['name']);
		$targetPath = $targetDir . $music;
		move_uploaded_file($_FILES["lagu_tema"]["tmp_name"],$targetPath);
		
		$result = musicEdit($id,$id_sesi,$music);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_aturcara.php?id_sesi=$id_sesi';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}
		
?>		
	