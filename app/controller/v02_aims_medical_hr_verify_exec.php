<?php
session_start();
require "../model/v02_aims_medical_function.php";

$id = clean($_POST['id']);
$total_claim = clean($_POST['total_claim']);
$receipt_date = clean($_POST['receipt_date']);
$remark = clean($_POST['remark']);
$hr_verify_by = $_SESSION['SESS_ID'];
$hr_verify_status = clean($_POST['hr_verify_status']);
$action = clean($_POST['action']);

$current_balance = getCurrentBalanceFromMedicalId($id);
$tmp_current_balance = $current_balance;
$medical_info = getMedicalById($id)->fetch_assoc();

if ($hr_verify_status == '1'){ //Verify
    if (in_array($action, ['new', 'rejected'])){ //For new verification, and update verification [Reject -> Verify]
        $current_balance -= $total_claim;
    }else{ //For update verification [Verify -> Verify]
        $current_balance += $medical_info['total_claim'] - $total_claim;
    }
}else if ($hr_verify_status == '0'){ //Reject
    // For new verification and update verification [Reject -> Reject], current balance remain same amount
    if ($action == 'verified'){ //For update verification [Verify -> Reject] p/s: revert quota current balance
        $current_balance += $medical_info['total_claim'];
    }
}

if ($current_balance != $tmp_current_balance){ // check if current_balance variable is changed
    $subtract_quota = medicalQuotaAdjustment($medical_info['staff_id'], $medical_info['receipt_date'], $current_balance);
    if ($subtract_quota != true){
        echo "<script>
            alert('Failed to update medical quota! Please contact IT team');
			window.history.back();
			</script>";
        exit();
    }
}

$result = hrVerifyMedicalClaim($id, $receipt_date, $total_claim, $remark, $hr_verify_by, $hr_verify_status, $current_balance);

if($result == true) {
    echo ("<script type='text/javascript'>
            alert('Medical Claim successfully verified/rejected');
                window.history.back();
                </script>");
}else {
    echo ("<script type='text/javascript'>
            alert('Failed to verify/reject Medical Claim');
                window.history.back();
                </script>");
}









