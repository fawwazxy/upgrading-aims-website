<?php
include "../model/aims_gl_function.php";

$room_id = clean($_POST['room_id']);
$locker_no = clean($_POST['locker_no']);

$result = addLocker($room_id,$locker_no);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_locker.php';
            </script>");
    exit();
} else {
    die("Query failed");
}