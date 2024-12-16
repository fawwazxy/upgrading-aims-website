<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$client_name = clean($_POST['client_name']);
$client_ic = clean($_POST['client_ic']);
$client_phone_no = clean($_POST['client_phone_no']);
$client_company_id = clean($_POST['client_company_id']);
$client_address = clean($_POST['client_address']);
$client_state = clean($_POST['client_state']);
$client_city = clean($_POST['client_city']);
$client_postcode = clean($_POST['client_postcode']);
$client_car = clean($_POST['client_car']);

$result = UpdateClient($client_name,$client_ic,$client_phone_no,$client_company_id,$client_address,$client_state,$client_city,$client_postcode,$client_car,$id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_client.php';
            </script>");
    exit();
} else {
    die("Query failed");
}