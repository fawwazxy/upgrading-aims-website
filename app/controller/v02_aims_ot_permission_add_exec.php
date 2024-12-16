<?php
session_start();
include "../model/v02_aims_ot_function.php";
include "../../mobile/send_fcm.php";

$applicant_id = $_SESSION['SESS_ID'];
$approval_id = clean($_POST['approval_id']);
$description = clean($_POST['description']);
$rate_mode = clean($_POST['rate_mode']);
$result = v02addOtPermission($rate_mode,$applicant_id,$description,$approval_id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    $token = getOtpApprovalFCMToken($approval_id);
    if($token!=''){
        $title = 'OT Permission Approval';
        $body = 'You have new permission from '.ucwords(getStaffName($applicant_id));
        sendFCM($token,$title,$body);
    }
    echo ("<script>
        alert('Successfully add new OT Permission');
        window.location.href='../view/v02_aims_ot_permission_list.php';
        </script>");
    exit();
} else {
    echo ("<script>
        alert('Failed to add new OT Permission !!! ');
        window.history.back();
        </script>");
    exit();
}