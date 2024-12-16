<?php
session_start();
require "../model/v02_aims_leave_function.php";
$success=0;

if(isset($_POST['leave_id'])) {
    $leave_id_array = array_reverse($_POST['leave_id']);
    $approval_by = $_SESSION['SESS_ID'];
    $action = ($_POST['approval_status'] == "APPROVE") ? '1' : '0';
    $leave_id = "('" . implode("','", $leave_id_array) . "');";

    $result = leaveMultipleApproval($leave_id, $action, $approval_by);

    if ($result == true){
        echo ("<script>
            alert('".count($leave_id_array)." application has been successfully approved/rejected.');
            window.history.back();
            </script>");
        exit();
    }

    echo ("<script>
            alert('Failed to approve/reject leave request');
            window.history.back();
            </script>");

}else{
    echo ("<script>
            alert('No applications were selected for approval');
            window.history.back();
            </script>");
    exit();
}
