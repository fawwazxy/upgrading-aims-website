<?php

require '../../app/model/v02_aims_visitor_function.php';

if($_SERVER["REQUEST_METHOD"]!='POST') {
    http_response_code(400);
    die("Invalid Method");
}

/*$visitor_id = clean($_POST["visitor_id"]);
$role = clean($_POST["role"]);
$coordinate = clean($_POST["coordinate"]);
$qr_location = clean($_POST["qr_location"]);
$reason = clean($_POST["reason"]);*/

$visitor_id = $_POST["visitor_id"];
$role = $_POST["role"];
$coordinate = $_POST["coordinate"];
$clock_in_qr = $_POST["clock_in_qr"];
$reason = $_POST["reason"];

$result = addAttendance($visitor_id,date("Y-m-d H:i:s"),$coordinate,$reason, $role, $clock_in_qr);

if(!$result){
    http_response_code(400);
    die("An error has occurred when saving data to the database");
}

echo 'New attendance successfully created.';





