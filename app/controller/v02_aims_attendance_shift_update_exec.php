<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$id = $_POST['id'];
$code = clean($_POST['code']);
$description = clean($_POST['description']);
$start_time = clean($_POST['start_time']);
$work_hour = clean($_POST['work_hour']) * (60 * 60);
$break_hour = clean($_POST['break_hour']) * (60 * 60);
$status = clean($_POST['status']);

$result = updateWorkShift($id, $code, $description, $start_time, $work_hour, $break_hour, $status);

//check whether the query was successful or not
if($result!="" && $result > 0){
    $message = "Successfully Update Work Shift";
}else{
    $message = "Failed to update Work shift: ".$result;
}

echo ("<script>
        alert('$message');
	    window.history.back();
	</script>");