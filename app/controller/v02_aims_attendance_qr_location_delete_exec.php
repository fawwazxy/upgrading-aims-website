<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$id = $_GET['id'];

$result = deleteQrLocation($id);

//check whether the query was successful or not
if($result!="" && $result > 0){
    $message = "Successfully Delete QR Location";
}else{
    $message = "Failed to delete QR Location: ".$result;
}

echo ("<script>
        alert('$message');
	    window.location.href = '../view/v02_aims_attendance_qr_location_list.php';
	</script>");