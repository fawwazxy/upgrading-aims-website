<?php
include "../model/aims_gl_function.php";

$utility_desc_id = clean($_POST['utility_desc_id']);
$no_20 = clean($_POST['no_20']);
$no_21 = clean($_POST['no_21']);
$total = clean($_POST['total']);
$month = clean($_POST['month']);
$year = clean($_POST['year']);
$created_by = clean($_POST['created_by']);

$result = addUtility($utility_desc_id, $no_20, $no_21, $total, $month, $year, $created_by);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_utility.php';
            </script>");
    exit();
} else {
    die("Query failed");
}