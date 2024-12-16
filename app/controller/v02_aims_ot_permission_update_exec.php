<?php
include "../model/v02_aims_ot_function.php";

$id = clean($_POST['id']);
$rate_mode = clean($_POST['rate_mode']);
$approval_id = clean($_POST['approval_id']);
$description = clean($_POST['description']);

$result = v02updateOtPermission($id,$rate_mode,$approval_id,$description);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
            alert('Successfully update OT Permission');
            window.history.back();
            </script>");
    exit();
} else {
    echo ("<script>
            alert('Failed to update OT Permission');
            window.history.back();
            </script>");
    exit();
}