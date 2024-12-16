<?php
include "../model/aims_carReserve_function.php";

//Sanitize the POST values
$id = $_POST['id'];
$reserve_id = $_POST['reserve_id'];
$issue_district = $_POST['issue_district'];
$summons_no = $_POST['summons_no'];
$offense = $_POST['offense'];
$enforcement_date = $_POST['enforcement_date'];
$offense_details = $_POST['offense_details'];
$original_amount = $_POST['original_amount'];
$destination = $_POST['destination'];
$car_plate_no = $_POST['car_plate_no'];
$company_name = $_POST['company_name'];
$name = $_POST['name'];

if(empty($reserve_id)) {
    $result = guestUpdateCarSummon($name,$company_name,$car_plate_no,$destination,$issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$id);
} else {
    $result = updatecarsummon($issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$id);
}

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_carSummon_list.php';
            </script>");
    exit();
}else{
    die("Query failed");
}