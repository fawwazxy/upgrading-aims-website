<?php
require "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$result = v02closeOtherOpenClaim($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
			alert('Successfully Open Claim for selected month');
			window.history.back();
			</script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
			alert('Failed to open claim!');
			window.history.back();
			</script>");
    exit();
}
