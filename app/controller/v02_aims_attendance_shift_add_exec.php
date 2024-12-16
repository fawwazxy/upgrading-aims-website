<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$code = clean($_POST['code']);
$description = clean($_POST['description']);
$start_time = clean($_POST['start_time']);
$work_hour = clean($_POST['work_hour']) * (60 * 60);
$break_hour = clean($_POST['break_hour']) * (60 * 60);
$status = clean($_POST['status']);

$result = insertWorkShift($code, $description, $start_time, $work_hour, $break_hour, $status);

//check whether the query was successful or not
if($result!="" && $result > 0){
    $message = "Successfully Insert Work Shift";
}else{
    $message = "Failed to insert Work shift: ".$result;
}

echo ("<script>
        alert('$message');
	    window.location.href = '../view/v02_aims_attendance_shift_list.php';
	</script>");