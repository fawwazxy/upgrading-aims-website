<?php

include "../model/acara_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "add_sesi"){
			$nama=clean($_POST['nama']);
			$lokasi=clean($_POST['lokasi']);
			$tarikh_mula=clean($_POST['tarikh_mula']);
			$tarikh_tamat=clean($_POST['tarikh_tamat']);
			$tahun=clean($_POST['tahun']);
			$created_by=clean($_POST['created_by']);
			
			$result = addSesiAcara($nama,$lokasi,$tarikh_mula,$tarikh_tamat,$tahun,$created_by);
		
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_acara.php';
						</script>");
			//header("location: ../view/acara_senarai_acara.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "edit_sesi"){
			$id=clean($_POST['id_sesi']);
			$nama=clean($_POST['nama']);
			$lokasi=clean($_POST['lokasi']);
			$tarikh_mula=clean($_POST['tarikh_mula']);
			$tarikh_tamat=clean($_POST['tarikh_tamat']);
			$tahun=clean($_POST['tahun']);
			$created_by=clean($_POST['created_by']);
			
			$result = editSesiAcara($id,$nama,$lokasi,$tarikh_mula,$tarikh_tamat,$tahun,$created_by);
		
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_acara.php';
						</script>");
			//header("location: ../view/acara_senarai_acara.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "upload_gambar"){
			
				$id_sesi=clean($_POST['id_sesi']);
				$targetDir = "../../acara/design_pasmasuk/";
				$allowTypes = array('jpg','png','jpeg','gif');
				$fileName = basename($_FILES['photo']['name']);
				$targetFilePath = $targetDir . $fileName;
				$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
				$pasmasuk_filename=$id_sesi.".".$fileType;
				$targetPath = $targetDir . $pasmasuk_filename;
				
				// Check whether file type is valid
				
				if(in_array($fileType, $allowTypes)){
					
					
					move_uploaded_file($_FILES["photo"]["tmp_name"],$targetPath);
					$result = editPasMasukFilename($id_sesi,$pasmasuk_filename);
		
					if($result) {
						echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_acara.php';
						</script>");
						//header("location: ../view/acara_senarai_acara.php");
						exit();
					}else {
						die("Query failed");
					}	
				}else{
					echo "file salah";
				}
			
	}