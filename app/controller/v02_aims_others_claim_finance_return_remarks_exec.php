<?php
require "../model/v02_aims_others_claim_function.php";

$claim_id = $_POST['id'];
$reason = $_POST['remarks'];

$result = financeReturnRemarks($claim_id,$reason);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Claim successfully return to HR')
            window.location.href='../view/v02_aims_others_claim_finance_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to return claim')
            history.back();
            </script>");
    exit();
}
