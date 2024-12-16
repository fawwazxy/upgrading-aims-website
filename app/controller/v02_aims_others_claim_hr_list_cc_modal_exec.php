<?php
include "../model/v02_aims_others_claim_function.php";

$tb_id = $_POST['getid'];
$claim_id = $_POST['id'];
$detail_claim = $_POST['desc'];
$rm_input = $_POST['rm_input'];

$result = v02updateOthersClaimCostCentre($claim_id, $detail_claim, $rm_input);

$new_total_claim = v02getNewTotal($tb_id);

$update_total_cost = v02updateNewTotal($tb_id,$new_total_claim);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Change cost centre successfully.')
            window.location.href='../view/v02_aims_others_claim_hr_update.php?id=$tb_id';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to change cost centre.')
            history.back();
            </script>");
    exit();
}