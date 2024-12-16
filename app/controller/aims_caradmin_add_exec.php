<?php
include "../model/aims_carReserve_function.php";
//Sanitize the POST values
$id = clean($_POST['id']);
$app_status = clean($_POST['app_status']);
$reason = clean($_POST['reason']);
$name_admin = clean($_POST['name_admin']);
$description = strtoupper(clean($_POST['description']));
$department = clean($_POST['department']);
$status = clean($_POST['status']);

$result =addCarAdmin($app_status,$reason,$name_admin,$description,$department,$id);

//Check whether the query was successful or not
if($result!="" && $result > 0 && $status=="admin") {
    echo ("<script type='text/javascript'>
            alert('Successfully approve/reject transport request');
            window.history.back();
            </script>");
} else if($result!="" && $result > 0 && $status=="company") {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_car_companyapp.php?app_status=$app_status';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
                alert('Failed to approve/reject transport request');
                window.history.back();
            </script>");
}