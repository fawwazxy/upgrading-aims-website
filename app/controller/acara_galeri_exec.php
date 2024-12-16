<?php

include "../model/acara_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "add_galeri"){
			
			$id_sesi=clean($_POST['id_sesi']);
			$tajuk_folder=clean($_POST['tajuk_folder']);
			
			$result = addGaleriAcara($id_sesi,$tajuk_folder);
		
		if($result) {
			header("location: ../view/acara_senarai_galeri.php?id_sesi=$id_sesi");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "upload_gambar"){
			
			$id_sesi=clean($_POST['id_sesi']);
			$id_galeri=clean($_POST['id_galeri']);
			
			$data_galeri=getGaleriAcaraById($id_galeri)->fetch_assoc();
			
			
			
			$targetDir = "../../acara/galeri/".$data_galeri['folder_code']."/";
			$allowTypes = array('jpg','png','jpeg','gif');
				foreach($_FILES['photo']['name'] as $key=>$val){
					// File upload path
					$fileName = basename($_FILES['photo']['name'][$key]);
					$targetFilePath = $targetDir . $fileName;
					
					// Check whether file type is valid
					$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
					if(in_array($fileType, $allowTypes)){
						
						move_uploaded_file($_FILES["photo"]["tmp_name"][$key], $targetFilePath);
						
					}else{
						echo "file salah";
					}
				}
				echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_galeri.php?id_sesi=$id_sesi';
						</script>");
				//header("location: ../view/acara_senarai_galeri.php?id_sesi=$id_sesi");
				exit();
	}else if($action == "edit_galeri"){
			
			$id_sesi=clean($_POST['id_sesi']);
			$id_galeri=clean($_POST['id_galeri']);
			$tajuk_folder=clean($_POST['tajuk_folder']);
			
			$result = editGaleriAcara($id_galeri,$tajuk_folder);
		
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_senarai_galeri.php?id_sesi=$id_sesi';
						</script>");
			//header("location: ../view/acara_senarai_galeri.php?id_sesi=$id_sesi");
			exit();
		}else {
			die("Query failed");
		}
	}
		
		
	