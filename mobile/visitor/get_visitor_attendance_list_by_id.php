<?php

require '../../app/model/v02_aims_visitor_function.php';

if ($_SERVER["REQUEST_METHOD"] != 'GET') {
    http_response_code(400);
    die("Invalid Method");
}

/*$visitor_id = clean($_GET["visitor_id"]);*/

$visitor_id = $_GET["visitor_id"];

$attendance_list = getAttendanceListByVisitorId($visitor_id)->fetch_all(MYSQLI_ASSOC);

foreach ($attendance_list as &$attendance){
    $attendance ['id'] = (int) $attendance ['id'];
    $attendance ['visitor_id'] = (int) $attendance ['visitor_id'];
    $attendance ['role'] = getVisitorType($attendance ['role']);
}

echo json_encode($attendance_list);