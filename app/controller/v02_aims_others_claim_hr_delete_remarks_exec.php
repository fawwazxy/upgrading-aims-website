<?php
include "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];

$result = v02DeleteOthersClaimRemarks($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Remarks successfully deleted.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete remarks.')
            history.back();
            </script>");
    exit();
}

