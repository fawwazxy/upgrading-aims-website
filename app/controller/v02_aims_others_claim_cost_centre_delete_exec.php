<?
include "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$claim_id = $_GET['claim_id'];

$result =  v02DeleteListCostCentre($id);
$new_total_claim = v02getNewTotal($claim_id);
$update_total_cost = v02updateNewTotal($claim_id,$new_total_claim);

//Check whether the query was successful or not
if($update_total_cost) {
    echo ("<script type='text/javascript'>
            alert('Selected cost centre successfully delete.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete selected cost centre.')
            history.back();
            </script>");
    exit();
}

?>
