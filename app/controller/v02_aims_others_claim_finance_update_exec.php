<?php
session_start();
include "../model/v02_aims_others_claim_function.php";

$id = $_POST['id'];
$updated_by = $_SESSION['SESS_ID'];
$job_no = $_POST['job_no'];

$result = v02FinanceUpdateOthersClaim($id,$updated_by,$job_no);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Update successfully.')
            window.location.href='../view/v02_aims_others_claim_finance_update.php?id=$id';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update.')
            history.back();
            </script>");
    exit();
}
