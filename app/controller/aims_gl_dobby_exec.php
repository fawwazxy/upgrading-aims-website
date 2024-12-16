<?php
include "../model/aims_gl_function.php";

$dobby_date = clean($_POST['dobby_date']);
$amount = clean($_POST['amount']);
$created_by = clean($_POST['created_by']);

$result = addDobby($dobby_date,$amount,$created_by);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_dobby.php';
            </script>");
    exit();
} else {
    die("Query failed");
}