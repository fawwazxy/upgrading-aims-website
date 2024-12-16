<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$staff_id = $_POST['staff_id'];
$type = $_POST['type'];
$shift = $_POST['shift'];
$description = $_POST['description'];
$action = $_POST['action'];

$success = 0;
foreach ($type as $date => $value){
    $workday = ($value == 'workday') ? 1 : 0;
    $date_id = getCalendarDateId($date);
    $result = insertOrUpdateIndividualCalendarByDateID($staff_id, $date_id, $shift[$date], $workday, $description[$date], $action, $_SESSION['SESS_ID']);

    if ($result){
        $success++;
    }
}

$message = ($success > 364) ? "Individual calendar has been saved (Total {$success} days)" : "Failed to save individual Calendar";

echo "<script>
            alert('$message');
			window.history.back();
			</script>";