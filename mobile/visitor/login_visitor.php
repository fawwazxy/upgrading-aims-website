<?php
require '../../app/model/v02_aims_visitor_function.php';

if($_SERVER["REQUEST_METHOD"]!='POST'){
    http_response_code(400);
    die("Invalid Method");
}

$email = $_POST["email"];
$ic = $_POST["ic"];

$result = loginVisitor($email, $ic)->fetch_all(MYSQLI_ASSOC);

if(!$result || count($result) < 1){
    http_response_code(400);
    die("Visitor not found");
}

if($result[0]['status'] != 2){
    http_response_code(400);
    die("Visitor status is ".getVisitorStatus($result[0]['status']));
}

echo json_encode($result[0],JSON_UNESCAPED_SLASHES);