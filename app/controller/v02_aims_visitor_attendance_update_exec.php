<?php
require "../model/v02_aims_visitor_function.php";

$id = $_POST['id'];
$company = $_POST['company'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$clock_in = $_POST['clock_in'];
$clock_in_location = $_POST['clock_in_location'];
$clock_in_qr = $_POST['clock_in_qr'];
$clock_out = $_POST['clock_out'];
$clock_out_location = $_POST['clock_out_location'];
$clock_out_qr = $_POST['clock_out_qr'];
$purpose = str_replace("'", "\'", $_POST['purpose']);
$role = $_POST['role'];

$result = updateAttendance($id, $clock_in, $clock_in_location,$clock_in_qr, $clock_out, $clock_out_location, $clock_out_qr, $purpose, $role);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Attendance successfully updated')
            window.location.href='../view/v02_aims_visitor_attendance_list.php?company=$company&start_date=$start_date&end_date=$end_date';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update attendance')
            window.history.back();
            </script>");
    exit();
}




