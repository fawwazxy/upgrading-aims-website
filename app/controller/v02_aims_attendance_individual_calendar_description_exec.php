<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$staff_id = $_SESSION['SESS_ID'];
$description = $_POST['description'];

$success = 0;
foreach ($description as $date => $value){
    $date_id = getCalendarDateId($date);
    $result = updateIndividualCalendarDescriptionByDateID($staff_id, $date_id, $value);

    if ($result){
        $success++;
    }
}

$message = ($success > 364) ? "Individual calendar has been saved (Total {$success} days)" : "Failed to save individual Calendar";

echo "<script>
            alert('$message');
			window.location.href = '../view/v02_aims_attendance_digital_calendar.php';
			</script>";