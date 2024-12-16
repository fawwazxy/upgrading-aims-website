<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$room_id = clean($_POST['room_id']);
$locker_no = clean($_POST['locker_no']);
$status = clean($_POST['status']);

$result = updateLocker($room_id,$locker_no,$status,$id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_locker.php';
            </script>");
    exit();
} else {
    die("Query failed");
}