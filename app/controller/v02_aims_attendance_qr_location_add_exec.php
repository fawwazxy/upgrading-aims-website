<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$branch = clean($_POST['branch']);
$custom = clean($_POST['custom']);

$branch = ($branch == 'custom') ? $custom : $branch;
$name = clean($_POST['name']);
$latitude = clean($_POST['latitude']);
$longitude = clean($_POST['longitude']);
$status = clean($_POST['status']);

$result = insertQrLocation($branch, $name, $latitude, $longitude, $status);

//check whether the query was successful or not
if($result!="" && $result > 0){
    $message = "Successfully Insert QR Location";
}else{
    $message = "Failed to insert QR Location: ".$result;
}

echo ("<script>
        alert('$message');
	    window.history.back();
	</script>");