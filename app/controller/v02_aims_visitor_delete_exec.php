<?php
require "../model/v02_aims_visitor_function.php";

$visitor_id = $_GET['id'];
$type = $_GET['type'];
$company = $_GET['company'];
$gender = $_GET['gender'];
$status = $_GET['status'];

$result = deleteVisitor($visitor_id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Visitor successfully deleted')
            window.location.href='../view/v02_aims_visitor_list.php?type=$type&company=$company&gender=$gender&status=$status';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete visitor')
            window.history.back();
            </script>");
    exit();
}
