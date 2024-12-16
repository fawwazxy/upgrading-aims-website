<?php
session_start();
require "../model/v02_aims_others_claim_function.php";

$auth_id = $_SESSION['SESS_ID'];
$claim_id = $_GET['id'];
/*$tracking_no = $_POST['tracking_no'];*/

$result = v02closeOtherClosedPayment($claim_id,$auth_id);
/*$result2 = v02trackingNo($claim_id,$tracking_no);*/

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
			alert('Successfully Close Payment for selected claim');
			window.history.back();
			</script>");
    exit();

} else {
    echo ("<script type='text/javascript'>
			alert('Failed to close payment!');
			window.history.back();
			</script>");
    exit();
}