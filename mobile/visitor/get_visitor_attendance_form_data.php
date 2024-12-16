<?php

require '../../app/model/v02_aims_visitor_function.php';

if($_SERVER["REQUEST_METHOD"]!='GET') {
    http_response_code(400);
    die("Invalid Method");
}

$visitor_types = getVisitorType(0,true);

$i= 0;
$array = Array();

foreach ($visitor_types as $visitor_type){
    $array[$i]['value'] = $i;
    $array[$i]['type'] = $visitor_type;
    $i++;
}

echo json_encode($array);
