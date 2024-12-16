<?php
include "../model/aims_gl_function.php";

$location = clean($_POST['location']);
$date_purchase = clean($_POST['date_purchase']);
$item = clean($_POST['item']);
$unit = clean($_POST['unit']);
$price = clean($_POST['price']);
$total = clean($_POST['total']);
$created_by = clean($_POST['created_by']);

$result = addHkExpenses($location,$date_purchase,$item,$unit,$price,$total,$created_by);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_hk_expenses.php';
            </script>");
    exit();
} else {
    die("Query failed");
}