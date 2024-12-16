<?php
require "../model/v02_aims_visitor_function.php";

$id = $_POST['id'];
$page_type = $_POST['page_type'];
$page_company = $_POST['company'];
$page_gender = $_POST['gender'];
$page_status = $_POST['status'];
$type = $_POST['type'];

$result = updateStatus($id, $type);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Visitor status successfully updated')
            window.location.href='../view/v02_aims_visitor_list.php?type=$page_type&company=$page_company&gender=$page_gender&status=$page_status';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update status visitor')
            window.history.back();
            </script>");
    exit();
}

