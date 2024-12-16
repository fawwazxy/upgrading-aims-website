<?php

include "../model/aims_inout_function.php";

// upload background
	// path to store uploaded image 
	$PNG_TEMP_DIR='../../photos/inout_photo/';
	
	if (!file_exists($PNG_TEMP_DIR))
	mkdir($PNG_TEMP_DIR);

	
		$id=clean($_POST['id']);
		if($_FILES['document']['size'] > 0) {

		$image_document = $_FILES['document']['tmp_name'];
		$documentAllowType = array('jpg','png','jpeg','gif','pdf');
		$imgContent_doc = addslashes(file_get_contents($image_document));
    	$document_name = $_FILES['document']['name'];
		$fileType = end((explode(".",$document_name)));
	}
	else {
		$imgContent_doc = "";
		$document_name = "";
		$fileType = "";
	}

					$result = updateImage($id,$imgContent_doc, $document_name, $fileType);
					if($result) {

						echo "<script type='text/javascript'>alert('Success');
						window.location.href='../view/aims_inout_list.php';</script>";

						exit();
					
				}else {
					echo "<script type='text/javascript'>alert('File must be less than 2MB');
					window.location.href='../view/aims_inout_list.php';</script>";
				}
			

	


?>