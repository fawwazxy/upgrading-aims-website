<?php

include "../model/gambar_functions.php";

$act=$_GET['act'];

// upload background
if ($act=='background_hadapan'){
	// path to store uploaded image 
	$PNG_TEMP_DIR='../../photos/background_card/';
	$target ="../../photos/background_card/temp_bg.png";
	
	if (!file_exists($PNG_TEMP_DIR))
	mkdir($PNG_TEMP_DIR);

	if(isset($_POST['uploadImage'])){

		if (($_FILES["image"]["type"] == "image/jpeg")
		|| ($_FILES["image"]["type"] == "image/png" )) {
			if ($_FILES["image"]["error"] > 0) {
				echo "Oh no! An error has occurred.";
				echo "Error Code: " . $_FILES["image"]["error"];
			}else {
				if ($_FILES["image"]["size"] <= 1048576*2 ){ 
					$image = $_FILES['image']['tmp_name'];
					$imgContent = addslashes(file_get_contents($image)); // gambar
					$image1 = $_FILES['image']['name']; // nama asal gambar

					move_uploaded_file($image,$target);

					$result = updateBackgroundImage('depan',$image1,$imgContent);
					if($result) {

						echo "<script type='text/javascript'>alert('Muat naik berjaya');
						window.location.href='../view/upload_bg_image.php';</script>";

						exit();
					}else{
						echo "<script type='text/javascript'>alert('Muat naik tidak berjaya.');
						window.location.href='../view/upload_bg_image.php';</script>";
					}
				}else {
					echo "<script type='text/javascript'>alert('Fail mesti kurang daripada 2MB');
					window.location.href='../view/upload_bg_image.php';</script>";
				}
			}
			 
			 
		} else {
					echo "<script type='text/javascript'>alert('Hanya format JPEG atau PNG sahaja');
						window.location.href='../view/upload_bg_image.php';</script>";
						
		}

	}
}

// upload background belakang
else if ($act=='background_belakang'){
	// path to store uploaded image 
	$PNG_TEMP_DIR='../../photos/background_card/';
	$target ="../../photos/background_card/temp_bg_back.png";
	
	if (!file_exists($PNG_TEMP_DIR))
	mkdir($PNG_TEMP_DIR);

	if(isset($_POST['uploadImage'])){

		if (($_FILES["image"]["type"] == "image/jpeg")
		|| ($_FILES["image"]["type"] == "image/png" )) {
			if ($_FILES["image"]["error"] > 0) {
				echo "Oh no! An error has occurred.";
				echo "Error Code: " . $_FILES["image"]["error"];
			}else {
				if ($_FILES["image"]["size"] <= 1048576*2 ){ 
					$image = $_FILES['image']['tmp_name'];
					$imgContent = addslashes(file_get_contents($image)); // gambar
					$image1 = $_FILES['image']['name']; // nama asal gambar

					move_uploaded_file($image,$target);

					$result = updateBackgroundImage('belakang',$image1,$imgContent);
					if($result) {

						echo "<script type='text/javascript'>alert('Muat naik berjaya');
						window.location.href='../view/upload_bg_image.php';</script>";

						exit();
					}else{
						echo "<script type='text/javascript'>alert('Muat naik tidak berjaya.');
						window.location.href='../view/upload_bg_image.php';</script>";
					}
				}else {
					echo "<script type='text/javascript'>alert('Fail mesti kurang daripada 2MB');
					window.location.href='../view/upload_bg_image.php';</script>";
				}
			}
			 
			 
		} else {
					echo "<script type='text/javascript'>alert('Hanya format JPEG atau PNG sahaja');
						window.location.href='../view/upload_bg_image.php';</script>";
						
		}

	}
}
?>