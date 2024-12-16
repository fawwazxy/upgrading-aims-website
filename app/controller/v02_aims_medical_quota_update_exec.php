<?php
session_start();
require "../model/v02_aims_medical_function.php";
//sanitize the POST values
$quota_id = clean($_POST['quota_id']);
$staff_id = clean($_POST['staff_id']); // used only for redirect url
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);
$entitled_balance = clean($_POST['entitled_balance']);
$current_balance = clean($_POST['current_balance']);
$updated_by = $_SESSION['SESS_ID'];


$result = updateMedicalQuota($quota_id,$entitled_balance,$current_balance,$start_date,$end_date,$updated_by);

if($result == true) {
    echo "<script>
            alert('Staff medical quota successfully updated');
			window.location.href='../view/v02_aims_medical_quota.php?id=".$staff_id."';
			</script>";
}else{
    echo "<script>
            alert('Failed to update staff medical quota');
			window.history.back();
			</script>";
}