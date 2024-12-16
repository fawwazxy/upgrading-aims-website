<?php
session_start();
require "../model/v02_aims_inout_function.php";
$success=0;

if(isset($_POST['inout_id'])) {
    $inout_id_array = array_reverse($_POST['inout_id']);
    $approval_by = $_SESSION['SESS_ID'];
    $action = ($_POST['approval_status'] == "APPROVE") ? '1' : '0';
    $inout_id = "('" . implode("','", $inout_id_array) . "');";

    $result = inOutMultipleApproval($inout_id, $action, $approval_by);

    if ($result == true){
        echo ("<script>
            alert('".count($inout_id_array)." Application successfully approved/rejected');
            window.history.back();
            </script>");
        exit();
    }

    echo ("<script>
            alert('Failed to approve/reject application');
            window.history.back();
            </script>");

}else{
    echo ("<script>
            alert('Please select at least one application');
            window.history.back();
            </script>");
    exit();
}
