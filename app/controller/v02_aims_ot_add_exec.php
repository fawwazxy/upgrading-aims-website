<?php
session_start();
include "../model/v02_aims_ot_function.php";

$staff_id = $_SESSION['SESS_ID'];
$ot_permission_id = clean($_POST['ot_permission_id']);
$month_claim = clean($_POST['month_claim']);
$date_ot = clean($_POST['date_ot']);
$start_ot = clean($_POST['start_ot']);
$end_ot = clean($_POST['end_ot']);
$total_hours = clean($_POST['total_hours']);

//Declare variable
$document_name = "";
$document_size = "";
$error_text = "";
$targetDir = "../../overtimephoto/";

if (!is_numeric($total_hours) || $total_hours < 0.01){
    echo "<script>
        alert('System cannot read total working hours. PLEASE TRY AGAIN or TRY USING DIFFERENT DEVICE. If this issue still occurs, contact IT department (Programming).');
        window.history.back();
    </script>";
    exit();
}

if(otPermissionIsClaimed($ot_permission_id)){
    echo "<script>
        alert('System has detected duplicated entry for permission ID ".$ot_permission_id.". Please see your Overtime list to check if your OT Claim has been submitted');
        window.history.back();
    </script>";
    exit();
}

if($_FILES['document']['size'] > 0) {
    $document_size = $_FILES['document']['size'];
    $tmp_name = $_FILES['document']['tmp_name'];
    $documentName = $_FILES['document']['name'];

    $array2 = explode(".", $documentName);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.$documentName;
    $targetPath = $targetDir . $document_name;
    $extensions= array('JPG','JPEG','PNG','GIF','PDF','jpg','jpeg','png','gif','pdf');

    if(in_array($document_type,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    if($document_size > 4194304){
        $errors[]='File size must be below 4 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($tmp_name,$targetPath);
    }else{
        $error_text = '';
        foreach ($errors as $error){
            $error_text .= "- ".$error."<br>";
        }
    }
}

$result = v02addOt($staff_id,$ot_permission_id,$month_claim,$date_ot,$start_ot,$end_ot,$total_hours,$document_name,$document_size);

if($result) {
    echo ("<script>
            alert('Successfully add new overtime claim');
			window.location.href='../view/v02_aims_ot_list_month.php';
			</script>");
    exit();
} else {
    echo ("<script>
            alert('Failed! '.$error_text);
			window.history.back();
			</script>");
    exit();
}

//function compressImage($source, $destination, $quality) {
//    // Get image info
//    $imgInfo = getimagesize($source);
//    $mime = $imgInfo['mime'];
//
//    // Create a new image from file
//    switch($mime){
//        case 'image/jpeg':
//            $image = imagecreatefromjpeg($source);
//            imagejpeg($image, $destination, $quality);
//            break;
//        case 'image/png':
//            $image = imagecreatefrompng($source);
//            imagepng($image, $destination, $quality);
//            break;
//        case 'image/gif':
//            $image = imagecreatefromgif($source);
//            imagegif($image, $destination);
//            break;
//        default:
//            $image = imagecreatefromjpeg($source);
//            imagejpeg($image, $destination, $quality);
//    }
//    // Return compressed image
//    return $destination;
//}