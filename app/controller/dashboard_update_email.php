<?php
require "../model/dashboard_functions.php";

$id = $_POST['id'];
$email = $_POST['email'];
$phone_no = $_POST['phoneNo'];

$result = updateEmail($id,$email,$phone_no);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Email successfully updated.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update email.')
            history.back();
            </script>");
    exit();
}
