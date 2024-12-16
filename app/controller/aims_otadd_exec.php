<?php
include "../model/aims_ot_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);
$staff_name = clean($_POST['staff_name']);
$icno = clean($_POST['icno']);
$company_id = clean($_POST['company_id']);
$position = clean($_POST['position']);
$month_claim = clean($_POST['month_claim']);
$date_ot = clean($_POST['date_ot']);
$day_ot = clean($_POST['day_ot']);
$start_ot = clean($_POST['start_ot']);
$end_ot = clean($_POST['end_ot']);
$working_hours = clean($_POST['working_hours']);
$type_claim = clean($_POST['type_claim']);
$description_ot = clean($_POST['description_ot']);
$no_staff = clean($_POST['no_staff']);
$staff_record_id = clean($_POST['staff_record_id']);

$current_date = clean($_POST['current_date']);

date_default_timezone_set("Asia/Kuala_Lumpur");
$mm = date('m',strtotime($month_claim));
$d = date("d");
$m = date("m");
$Y = date("Y");

$limit_date = "2022-".$mm."-21"; //2021-1-21

$dec = $Y."-12-21"; //2021-12-21

	if(strtotime($current_date) > strtotime($dec)){
	
			$targetDir = "../../overtimephoto/";
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

			$result = addOt($staff_name,$icno,$company_id,$position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,
			$description_ot,$no_staff,$staff_record_id,$document_name,$document_type,$document_size);


			//check wheter the query was succesful or not
			if($result!="" && $result > 0)
			{
				
				echo ("<script LANGUAGE='JavaScript'>
				
				window.location.href='../view/aims_ot_list.php';
				</script>");
				exit();
				
			}
			else
			{
				die("Query failed");
			}
	}

	else if (strtotime($current_date) > strtotime($limit_date)) {
		echo ("<script LANGUAGE='JavaScript'>
						
			alert('Claim for this month already closed. Please choose next month as Month Claim!');
			window.history.back();
			</script>");
		exit();
	}
 
	else {
			$targetDir = "../../overtimephoto/";
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

			$result = addOt($staff_name,$icno,$company_id,$position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,
			$description_ot,$no_staff,$staff_record_id,$document_name,$document_type,$document_size);


					//check wheter the query was succesful or not
					if($result!="" && $result > 0)
					{
						
						echo ("<script LANGUAGE='JavaScript'>
						
						window.location.href='../view/aims_ot_list.php';
						</script>");
						exit();
						
					}
					else
					{
						die("Query failed");
					}
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