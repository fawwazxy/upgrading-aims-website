<?php

include "../model/contractor_function.php";
	
	

	$name = clean($_POST['name']);
	$noic = clean($_POST['no_staff']);
	$umur = clean($_POST['umur']);
	$gender = clean($_POST['gender']);
	$phone = clean($_POST['phone']);
	$email = clean($_POST['email']);
  //  $status = $_POST['status'];
	
	
	//pakai column role_id
	$category_id = clean($_POST['category_id']);
	
	//tambah db contractor syarikat di db
	$syarikat = clean($_POST['syarikat']);
	$purpose = clean($_POST['purpose']);
	
//	$company_id = $_POST['company_id'];

	$status_qrcode = "1";
	$status_swafoto = "1";
	$status_tag = "0";
	
	$targetDir = "../../contractorphoto/";
				if($_FILES['document']['size'] > 0) {
					
					$document_size = $_FILES['document']['size'];
					$image_document = $_FILES['document']['tmp_name'];
					$documentname = $_FILES['document']['name'];
					$document_type = end((explode(".",$documentname)));
					$document_name_only = array_shift(explode(".",$documentname));
            	    date_default_timezone_set("Asia/Kuala_Lumpur");
            	    $randomnum=rand(0,100000);
            	    $rename= $document_name_only.date('Ymd').$randomnum;
            	    $document_name=$rename.'.'.$document_type;
					$targetPath = $targetDir . $document_name;
					
					if($document_type == 'JPG' || $document_type == 'JPEG' || $document_type == 'PNG' || $document_type == 'gif'){
						$compressedImage = compressImage($image_document, $targetPath, 60); 
					}
					else {
						move_uploaded_file($image_document,$targetPath);
					}
				}
				else {
					$document_name = "";
				}
	
	
	$result = addContactor($name,$noic,$umur,$gender,$phone,$email,$syarikat,$category_id,$status_qrcode,$status_swafoto,$status_tag,$purpose,$document_name,$document_type,$document_size);
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../../contractor_redirect/index.html';
                    </script>");
		exit();
	}else {
		die("Query failed");
	}
	
	
	 function compressImage($source, $destination, $quality) { 
				// Get image info 
				$imgInfo = getimagesize($source); 
				$mime = $imgInfo['mime']; 
				 
				// Create a new image from file 
				switch($mime){ 
					case 'image/jpeg': 
						$image = imagecreatefromjpeg($source); 
					   imagejpeg($image, $destination, $quality);
						break; 
					case 'image/png': 
						$image = imagecreatefrompng($source); 
						imagepng($image, $destination, $quality);
						break; 
					case 'image/gif': 
						$image = imagecreatefromgif($source); 
						imagegif($image, $destination, $quality);
						break; 
					default: 
						$image = imagecreatefromjpeg($source); 
					   imagejpeg($image, $destination, $quality);
				} 
						// Return compressed image 
						return $destination; 
					} 
?>