<?php
include "../model/v02_aims_ot_function.php";
//Sanitize the POST values

$id = clean($_POST['id']);
$verification_remark = clean($_POST['verification_remark']);

//$result = updateOtHod($working_hours,$hod_remark,$id);
$result = v02verificationRemark($id, $verification_remark);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
            alert('Successfully update OT Claim');
            window.history.back();
            </script>");
    exit();
}else {
    echo ("<script>
            alert('Failed to update OT Claim');
            window.history.back();
            </script>");
    exit();
}