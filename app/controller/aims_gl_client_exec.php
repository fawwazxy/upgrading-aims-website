<?php
include "../model/aims_gl_function.php";

$client_name = clean($_POST['client_name']);
$client_ic = clean($_POST['client_ic']);
$client_phone_no = clean($_POST['client_phone_no']);
$client_company_id = clean($_POST['client_company_id']);
$client_address = clean($_POST['client_address']);
$client_state = clean($_POST['client_state']);
$client_city = clean($_POST['client_city']);
$client_postcode = clean($_POST['client_postcode']);
$client_car = clean($_POST['client_car']);

$targetDir = "../../glphoto/";
$document_name = "";
$document_size = 0;

if($_FILES['document']['size'] > 0) {
    $image_document = $_FILES['document']['tmp_name'];
    $document_name = date('Ymd_His').str_replace(" ","_",$_FILES['document']['name']);
    $document_size = $_FILES['document']['size'];
    $targetPath = $targetDir . $document_name;
    move_uploaded_file($image_document,$targetPath);
}

$result = addClient($client_name, $client_ic, $client_phone_no, $client_company_id, $client_address, $client_state, $client_city, $client_postcode, $client_car, $document_name, $document_size);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
        alert('Client successfully added')
            window.location.href='../view/aims_gl_client.php';
            </script>");
    exit();
} else {
    die("Query failed");
}