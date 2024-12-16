<?php
include "../model/v02_aims_others_claim_function.php";

$claim_id = $_POST['id'];
$tracking_no = $_POST['tracking_no'];

$update_tracking = updateTrackingNo($claim_id, $tracking_no);

if($update_tracking!="" && $update_tracking > 0) {
    echo ("<script type='text/javascript'>
        alert('Successfully updated.')
        window.history.back();
        </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update.')
            history.back();
            </script>");
    exit();
}