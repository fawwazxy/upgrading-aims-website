<?php
session_start();
require "../model/v02_attendance_function.php";

$type = $_POST['type'];
$description = $_POST['description'];
$action = $_POST['action'];

$success = 0;
foreach ($type as $date => $value){
    $default = ($value == 'workday') ? 1 : 0;
    $public = ($value == 'public') ? 1 : 0;
    $result = insertOrUpdateWorkdayCalendarByDate($date, $default, $public, $description[$date], $action, $_SESSION['SESS_ID']);

    if ($result){
        $success++;
    }
}

$message = ($success > 364) ? "Workday calendar has been saved (Total {$success} days)" : "Failed to save workday Calendar";

echo "<script>
            alert('$message');
			window.history.back();
			</script>";