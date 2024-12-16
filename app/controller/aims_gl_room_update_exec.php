<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$room_no = clean($_POST['room_no']);
$capacity = clean($_POST['capacity']);
$bed_type = clean($_POST['bed_type']);
$status = clean($_POST['status']);

$result = updateRoom($room_no,$capacity,$bed_type,$status,$id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_room.php';
            </script>");
    exit();
} else {
    die("Query failed");
}