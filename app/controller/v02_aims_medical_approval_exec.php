<?php
session_start();
include "../model/v02_aims_medical_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$level = $_GET['level'];
$approved_by = $_SESSION['SESS_ID'];

if ($action == '0'){ //if rejected, revert medical claim balance
    $medical_info = getMedicalById($id)->fetch_assoc();

    $staff_id = $medical_info['staff_id'];
    $receipt_date = $medical_info['receipt_date'];
    $total_claim = $medical_info['total_claim'];

    $old_current_balance = getCurrentBalanceFromMedicalId($id);
    $new_current_balance = $old_current_balance + $total_claim;

    $revert_balance = medicalQuotaAdjustment($staff_id, $receipt_date, $new_current_balance);
//    $rewrite_balance = rewriteMedicalClaimBalance($id, $new_current_balance);

    if ($revert_balance != true){
        echo "<script>
            alert('Failed to revert medical claim balance');
			window.history.back();
			</script>";
        exit();
    }
}

$result = approveMedical($id, $action, $approved_by, $level);

if($result == true) {
    echo "<script>
            alert('Successfully approve/disapproved medical claim.');
			window.history.back();
			</script>";
}else{
    echo "<script>
            alert('Failed to approved/disapproved medical claim');
			window.history.back();
			</script>";
}