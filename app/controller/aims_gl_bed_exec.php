<?php
include "../model/aims_gl_function.php";

$room_id = clean($_POST['room_id']);
$bed_no = clean($_POST['bed_no']);

$result = addBed($room_id,$bed_no);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_bed.php';
            </script>");
    exit();
} else {
    die("Query failed");
}