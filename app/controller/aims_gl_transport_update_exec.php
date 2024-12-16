<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$company_vehicle = clean($_POST['company_vehicle']);
$date_use = clean($_POST['date_use']);
$mileage_in = clean($_POST['mileage_in']);
$mileage_out = clean($_POST['mileage_out']);
$total_mileage = clean($_POST['total_mileage']);
$total = clean($_POST['total']);

$result = updateTransport($company_vehicle,$date_use,$mileage_in,$mileage_out,$total_mileage,$total,$id);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_transport.php';
            </script>");
    exit();
} else {
    die("Query failed");
}