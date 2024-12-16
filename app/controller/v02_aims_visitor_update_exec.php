<?php
require "../model/v02_aims_visitor_function.php";

$id = $_POST['id'];
$page_type = $_POST['page_type'];
$page_company = $_POST['page_company'];
$page_gender = $_POST['page_gender'];
$page_status = $_POST['page_status'];
$name = $_POST['name'];
$ic_number = $_POST['ic_number'];
$phone_no = $_POST['phone_no'];
$email = $_POST['email'];
$company = $_POST['company'];
$custom = $_POST['custom'];
$birth_year = $_POST['birth_year'];
$gender = $_POST['gender'];
$type = $_POST['type'];
$status = $_POST['status'];

$reg_company = ($custom != '')?$custom:$company;

$result = updateVisitor($id, $name, $ic_number, $phone_no, $email, $reg_company, $birth_year, $gender, $type, $status);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Visitor successfully updated')
            window.location.href='../view/v02_aims_visitor_list.php?type=$page_type&company=$page_company&gender=$page_gender&status=$page_status';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update visitor')
            window.history.back();
            </script>");
    exit();
}
