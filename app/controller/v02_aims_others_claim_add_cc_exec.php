<?
include "../model/v02_aims_others_claim_function.php";
$claim_id = $_POST['claim_id'];
$cost_centre_id = $_POST['desc'];
$rm_input = $_POST['rm_input'];
$isHumanResources = $_POST['hr'] == 'yes';

$result = v02addOthersHRClaimModal($claim_id, $cost_centre_id, $rm_input, $isHumanResources);
$new_total_claim = v02getNewTotal($claim_id);
$update_total_cost = v02updateNewTotal($claim_id,$new_total_claim);
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Add cost centre successfully.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add cost centre.')
            history.back();
            </script>");
    exit();
}