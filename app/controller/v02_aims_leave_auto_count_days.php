<?php
require "../model/v02_aims_leave_function.php";

$no_staff = clean($_POST['no_staff']);
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);

$result = autoCountLeaveDays($no_staff, $start_date, $end_date);

echo json_encode($result);