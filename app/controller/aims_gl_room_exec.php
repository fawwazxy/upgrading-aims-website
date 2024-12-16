<?php
include "../model/aims_gl_function.php";

$room_no = clean($_POST['room_no']);
$capacity = clean($_POST['capacity']);
$bed_type = clean($_POST['bed_type']);

$result = addRoom($room_no,$capacity,$bed_type);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_room.php';
            </script>");
    exit();
} else {
    die("Query failed");
}