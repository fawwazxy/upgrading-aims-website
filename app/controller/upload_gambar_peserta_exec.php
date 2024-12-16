<?

include "../model/acara_functions.php";
include "../../util/resizingImage.php";
	   
		$nokp = $_POST['nokp'];
		
		
		$targetDir = "../../acara/foto_peserta/";
		
		$photo_filename=$nokp.".png";
		$targetPath = $targetDir . $photo_filename;
		$image = new SimpleImage();
		$image->load($_FILES["photo"]["tmp_name"]);
		$image->resize(150, 180);
		$image->save($targetPath);
	
		

		$result = uploadGambarPeserta($nokp,$photo_filename);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/acara_foto_upload_peserta.php?nokp=$nokp';
                    </script>");
			//header("location: ../view/acara_foto_upload_peserta.php?nokp=$nokp");
			exit();
		}else {
			die("Query failed");
		}
		
?>