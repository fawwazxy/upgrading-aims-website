<?php
session_start();
include "../model/v02_aims_others_claim_function.php";

$id = $_POST['id'];
$advance = $_POST['advance'];
$refund = $_POST['refund'];
$outstanding = $_POST['outstanding'];

$verification_by = $_SESSION['SESS_ID'];
$verification_status = ($_POST['verification_status'] == "CHECK") ? '1' : '0';

$result2 = v02OthersClaimCheckUpdate($id, $verification_by,$verification_status);
$result = v02FinanceUse($id,$advance,$refund,$outstanding);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Claim successfully checked.')
            window.location.href='../view/v02_aims_others_claim_finance_update.php?id=$id';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to checked claim.')
            history.back();
            </script>");
    exit();
}
