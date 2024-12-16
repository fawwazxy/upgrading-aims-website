<?php
session_start();
require "../model/v02_aims_medical_function.php";

if(isset($_POST['medical_id'])) {
    $medical_id_array = $_POST['medical_id'];
    $approved_by = $_SESSION['SESS_ID'];
    $action = ($_POST['approval_status'] == "APPROVE") ? '1' : '0';
    $level = $_POST['level'];
    $medical_id_string = "('" . implode("','", $medical_id_array) . "');";

    foreach ($medical_id_array as $medical_id){
        if ($action == '0'){ //if rejected, revert medical claim balance
            $medical_info = getMedicalById($medical_id)->fetch_assoc();

            $staff_id = $medical_info['staff_id'];
            $receipt_date = $medical_info['receipt_date'];
            $total_claim = $medical_info['total_claim'];

            $old_current_balance = getCurrentBalanceFromMedicalId($medical_id);
            $new_current_balance = $old_current_balance + $total_claim;

            $revert_balance = medicalQuotaAdjustment($staff_id, $receipt_date, $new_current_balance);
//            $rewrite_balance = rewriteMedicalClaimBalance($id, $new_current_balance);

            if ($revert_balance != true){
                echo "<script>
                        alert('Failed to revert medical claim balance');
                        window.history.back();
                        </script>";
                exit();
            }
        }
    }

    $result = multipleApproveMedical($medical_id_string, $action, $approved_by, $level);

    echo ("<script>
            alert('".count($medical_id_array)." medical claim successfully approved/disapproved');
            window.history.back();
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Please select at least one medical claim');
            window.history.back();
            </script>");
    exit();
}
