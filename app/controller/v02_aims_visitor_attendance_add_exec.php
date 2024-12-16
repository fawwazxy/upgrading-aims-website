<?php
require "../model/v02_aims_visitor_function.php";

$ic_number = $_POST['ic_number'];

$getInfo = getVisitorByIc($ic_number)->fetch_assoc();

if ($getInfo['id'] > 0){

    if (!in_array($getInfo['status'],['0','1'])){

        $clock_in = $_POST['clock_in'];
        $clock_in_location = $_POST['clock_in_location'];
        $purpose = str_replace("'", "\'", $_POST['purpose']);
        $role = $_POST['role'];
        $qr_location = $_POST['qr_location'];

        $result = addAttendance($getInfo['id'],$clock_in,$clock_in_location,$purpose, $role,$qr_location);

        if($result!="" && $result > 0) {
            echo ("<script type='text/javascript'>
            alert('Attendance successfully added')
            window.location.href='../view/v02_aims_visitor_attendance_list.php';
            </script>");
            exit();
        } else {
            echo ("<script type='text/javascript'>
            alert('Failed to add attendance')
            window.history.back();
            </script>");
            exit();
        }
    }
    else {
        echo ("<script type='text/javascript'>
            alert('This visitor account is Suspended/Pending')
            window.history.back();
            </script>");
        exit();

    }
} else {
    echo ("<script type='text/javascript'>
            alert('Cannot recognize ic number')
            window.history.back();
            </script>");
    exit();
}

