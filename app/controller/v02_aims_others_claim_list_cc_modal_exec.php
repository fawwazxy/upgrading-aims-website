<?php
require "../model/v02_aims_others_claim_function.php";

$cost_centre_id = $_POST['id'];
$claim_id = $_POST['claim_id'];
$detail_claim = $_POST['desc'];
$rm_input = $_POST['rm_input'];

$result = v02updateOthersClaimCostCentre($cost_centre_id, $detail_claim, $rm_input);

$new_total_claim = v02getNewTotal($claim_id);
$update_total_cost = v02updateNewTotal($claim_id,$new_total_claim);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Change cost centre successfully.');
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to change cost centre.')
            history.back();
            </script>");
    exit();
}