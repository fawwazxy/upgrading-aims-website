<?php


require '../../app/model/v02_aims_visitor_function.php';

if ($_SERVER["REQUEST_METHOD"] != 'GET') {
    http_response_code(400);
    die("Invalid Method");
}

/*$visitor_id = clean($_GET["visitor_id"]);*/

$visitor_id = $_GET["visitor_id"];

$last_attendance = getVisitorLatestAttendance($visitor_id)->fetch_all(MYSQLI_ASSOC);

if(!$last_attendance || count($last_attendance) < 1) return null;

$last_attendance[0] ['id'] = (int) $last_attendance[0] ['id'];
$last_attendance[0] ['visitor_id'] = (int) $last_attendance[0] ['visitor_id'];

echo json_encode($last_attendance[0]);