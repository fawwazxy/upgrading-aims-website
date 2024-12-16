<?php
require "../model/v02_aims_ot_function.php";

$id = clean($_POST['id']);
$approval_status = clean($_POST['approval_status']);

$result = v02approveOtPermission($id, $approval_status);

//Check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script>
            alert('Successfully Approve/Decline OT Permission');
            window.location.href='../view/v02_aims_ot_permission_approval.php';
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Failed to Approve/Decline OT Permission !');
            window.history.back();
            </script>");
    exit();
}
