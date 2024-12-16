<?
include "../model/ahli_functions.php";
	
$action=clean($_POST['action']);
if($action == "addEditPengumuman"){
		$id=clean($_POST['id']);
		$tajuk=clean($_POST['tajuk']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_tamat=clean($_POST['tarikh_tamat']);
		$kategori = clean($_POST['kategori']);
		$keterangan=clean($_POST['keterangan']);
		$created_by=clean($_POST['created_by']);
		
		$targetDir = "../../iahli/lampiran/";

		if($_FILES['dokumen']['size'] > 0) {
			$image_document = $_FILES['dokumen']['tmp_name'];
	    	$dokumen_filename = $_FILES['dokumen']['name'];
	    	$targetFilePath = $targetDir . $dokumen_filename;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		}
		else {
			$dokumen_filename = "";
			$fileType = "";
		}
		
		
		$result = addEditPengumuman($id,$tajuk,$tarikh_mula,$tarikh_tamat,$kategori,$keterangan,$created_by,$dokumen_filename,$fileType);
if($_FILES['dokumen']['size'] > 0) {
			$filename=$result.".".$fileType;
			$targetPath = $targetDir . $filename;
			move_uploaded_file($image_document,$targetPath);
		}

	
	if($result>0) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_senarai_pengumuman.php';
						</script>");
		// //header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}
?>