<?php
include "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$getid = $_GET['getid'];

$result =  v02DeleteListCostCentre($id);

$new_total_claim = v02getNewTotal($getid);

$update_total_cost = v02updateNewTotal($getid,$new_total_claim);

//Check whether the query was successful or not
if($result) {
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
