<?php

require '../../app/model/v02_aims_visitor_function.php';

if($_SERVER["REQUEST_METHOD"]!='POST') {
    http_response_code(400);
    die("Invalid Method");
}

/*$id = clean($_POST["id"]);
$coordinate = clean($_POST["coordinate"]);
$qr_location = clean($_POST["qr_location"]);*/

$id = $_POST["id"];
$coordinate = $_POST["coordinate"];
$clock_out_qr = $_POST["qr_location"];

$result = updateClockOut($id, null, $coordinate, $clock_out_qr);

if(!$result){
    http_response_code(400);
    die("An error has occurred when saving data to the database");
}

echo 'Successfully checked out.';