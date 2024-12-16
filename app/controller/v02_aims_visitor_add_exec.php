<?php
require "../model/v02_aims_visitor_function.php";

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
$auth = $_POST['auth'];

$reg_company = ($custom != '') ? $custom : $company;

$get_id = getVisitorByIc($ic_number)->fetch_object()->id;

if ($get_id < 1){
    $result = addVisitor($name, $ic_number, $phone_no, $email, $reg_company, $birth_year, $gender, $type, $status);
    $href = ($auth == '0') ? '../view/v02_aims_visitor_success_card.php' : '../view/v02_aims_visitor_list.php';

    if($result!="" && $result > 0) {
        echo ("<script type='text/javascript'>
            alert('Visitor successfully added')
            window.location.href='$href';
            </script>");
        exit();
    } else {
        echo ("<script type='text/javascript'>
            alert('Failed to add visitor')
            window.history.back();
            </script>");
        exit();
    }

} else {
    echo ("<script type='text/javascript'>
            alert('IC number already registered')
            window.history.back();
            </script>");
    exit();
}



