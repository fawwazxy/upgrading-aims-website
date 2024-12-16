<?php
session_start();
require "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$closed_by = $_SESSION['SESS_ID'];
$action = $_GET['action'] ?: 'CLOSED';
$result = v02closeOrOpenClaim($id, $closed_by, $action);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
			alert('Successfully Close/Open Claim for selected month');
			window.history.back();
			</script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
			alert('Failed to close claim!');
			window.history.back();
			</script>");
    exit();
}
