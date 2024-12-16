<?php
include "../model/aims_carReserve_function.php";


//Sanitize the POST values
$id = clean($_POST['id']);
$name = clean($_POST['name']);
$department_name = clean($_POST['department_name']);
$jawatan = clean($_POST['jawatan']);
$drivername = clean($_POST['drivername']);
$purpose = clean($_POST['purpose']);
$destination = clean($_POST['destination']);
$company_name = clean($_POST['company_name']);
$car_type = clean($_POST['car_type']);
$no_passengers = clean($_POST['no_passengers']);
$car_plate_no = clean($_POST['car_plate_no']);
$dep_date = clean($_POST['dep_date']);
$dep_time = clean($_POST['dep_time']);
$dep_mileage = clean($_POST['dep_mileage']);
$return_date = clean($_POST['return_date']);
$return_time = clean($_POST['return_time']);
$return_mileage = clean($_POST['return_mileage']);
$status_incep= clean($_POST['status_incep']);
$status = $_POST['status'];
$status1 = $_POST['app_status'];
$healty_status = $_POST['healty_status'];
$illness = $_POST['illness'];

$result = updatecarRequest($name,$jawatan,$department_name,$drivername,$purpose,$destination,$company_name,
    $car_type,$no_passengers,$car_plate_no,$dep_date,$dep_time,$dep_mileage,$return_date,$return_time,
    $return_mileage,$status_incep,$healty_status,$illness,$id);


if($result!="" && $result > 0 && $status == 'staff') {

    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_carReserve_list.php';
            </script>");
    exit();
} else if($result!="" && $result > 0 && $status == 'admin') {

    echo ("<script type='text/javascript'>
            alert('Successfully update car reserve info');
            window.close();
            </script>");
    exit();
} else if($result!="" && $result > 0 && $status == 'company') {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_car_companyapp.php?app_status=$status1';
            </script>");
    exit();
} else {
    die("Query failed");
}