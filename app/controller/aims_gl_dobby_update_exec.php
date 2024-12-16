<?php
include "../model/aims_gl_function.php";

$dobby_date = clean($_POST['dobby_date']);
$amount = clean($_POST['amount']);
$id = clean($_POST['id']);

$result = updateDobby($dobby_date,$amount,$id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_dobby.php';
            </script>");
    exit();
} else {
    die("Query failed");
}