<?php
include "../model/v02_aims_others_claim_function.php";

$id = $_POST['id'];
$remarks = str_replace("'","\'",$_POST['addRemarks']);

$result = v02addOthersClaimRemarks($id, $remarks);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Remarks successfully added.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add remarks.')
            history.back();
            </script>");
    exit();
}
?>
