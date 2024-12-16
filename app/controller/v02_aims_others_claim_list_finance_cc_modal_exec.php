<?
include "../model/v02_aims_others_claim_function.php";
$tb_id = $_POST['getid'];
$claim_id = $_POST['id'];
$detail_claim = $_POST['desc'];

$result = v02updateOthersFinanceClaimModal($claim_id, $detail_claim);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Change cost centre successfully.')
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