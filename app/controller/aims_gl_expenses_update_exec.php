<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$hk_date = clean($_POST['hk_date']);
$hk_status = clean($_POST['hk_status']);
$dobby_bs = clean($_POST['dobby_bs']);
$dobby_bl = clean($_POST['dobby_bl']);
$dobby_twl = clean($_POST['dobby_twl']);
$tea = clean($_POST['tea']);
$sugar = clean($_POST['sugar']);
$creamer = clean($_POST['creamer']);
$soap = clean($_POST['soap']);
$shampoo = clean($_POST['shampoo']);
$water = clean($_POST['water']);
$created_by = clean($_POST['created_by']);

$result = updateExpenses($hk_date,$hk_status,$dobby_bs,$dobby_bl,$dobby_twl,$tea,$sugar,$creamer,$soap,$shampoo,$water,$created_by,$id);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_expenses.php';
            </script>");
    exit();
} else {
    die("Query failed");
}