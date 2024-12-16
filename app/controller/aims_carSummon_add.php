<?php
include "../model/aims_carReserve_function.php";

//Sanitize the POST values
$reserve_id = clean($_POST['reserve_id']);
$summon_by = clean($_POST['summon_by']);
$name = clean($_POST['name']);
$company_name = clean($_POST['company_name']);
$car_plate_no = clean($_POST['car_plate_no']);
$issue_district = clean($_POST['issue_district']);
$summons_no = clean($_POST['summons_no']);
$offense = clean($_POST['offense']);
$enforcement_date = clean($_POST['enforcement_date']);
$offense_details = $_POST['offense_details'];
$original_amount = $_POST['original_amount'];
$destination = clean($_POST['destination']);

if($reserve_id== 0){
    $result = addcarsummonWithoutReserveId($summon_by,$destination,$issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$name, $car_plate_no, $company_name);
}else{
    $result = addcarsummon($reserve_id,$summon_by, $issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount);
}

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_carSummon_list.php';
            </script>");
    exit();
} else {
    die("Query failed");
}