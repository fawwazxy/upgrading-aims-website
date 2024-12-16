<?php
session_start();
require "../model/v02_aims_medical_function.php";
//sanitize the POST values
$staff_id = clean($_POST['staff_id']);
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);
$entitled_balance = clean($_POST['entitled_balance']);
$current_balance = clean($_POST['current_balance']);
$created_by = $_SESSION['SESS_ID'];

$result = insertMedicalQuota($staff_id,$entitled_balance,$current_balance,$start_date,$end_date,$created_by);

if($result == true) {
    echo "<script>
            alert('Medical Quota successfully added');
			window.location.href='../view/v02_aims_medical_quota.php?id=$staff_id';
			</script>";
}else{
    echo "<script>
            alert('Failed to add Medical Quota');
			window.history.back();
			</script>";
}