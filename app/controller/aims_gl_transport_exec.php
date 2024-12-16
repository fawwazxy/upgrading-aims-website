<?php
include "../model/aims_gl_function.php";

$company_vehicle = clean($_POST['company_vehicle']);
$date_use = clean($_POST['date_use']);
$mileage_in = clean($_POST['mileage_in']);
$mileage_out = clean($_POST['mileage_out']);
$total_mileage = clean($_POST['total_mileage']);
$total = clean($_POST['total']);
$created_by = clean($_POST['created_by']);

$result = addTransport($company_vehicle,$date_use,$mileage_in,$mileage_out,$total_mileage,$total,$created_by);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_transport.php';
            </script>");
    exit();
} else {
    die("Query failed");
}