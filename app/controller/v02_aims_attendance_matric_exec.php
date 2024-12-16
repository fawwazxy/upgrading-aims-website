<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";
require "../global/uniqid_generator.php";
/*print_r($_POST);
exit();*/
$created_by = $_SESSION['SESS_ID'];
$act = $_POST['act'];
$staff_ic = clean($_POST['staff_ic']);

$img = $_POST['image'];
$folderPath = "../../logphoto/";
$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = $staff_ic.'-'.create_guid().'-'.'.'.$image_type;
$file = $folderPath . $fileName;
file_put_contents($folderPath.$fileName,$image_base64);

if ($act == "in") {
    $result = addMatricClockIn($created_by, $fileName, $staff_ic);
    if($result!="" && $result > 0){
        $message = "Successfully Clock In";
    }else{
        $message = "Failed to Clock In: ".$result;
    }
} else {
    $result = updateMatricClockOut($created_by, $fileName, $staff_ic);
    if($result!="" && $result > 0){
        $message = "Successfully Clock Out";
    }else{
        $message = "Failed to Clock Out: ".$result;
    }
}
echo ("<script>
        alert('$message');
	    window.location.href='../view/v02_aims_attendance_homepage.php';
	</script>");
