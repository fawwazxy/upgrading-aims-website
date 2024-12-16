<?php
require "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$result = v02closeOtherOpenPayment($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
			alert('Successfully Open Payment for selected claim');
			window.history.back();
			</script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
			alert('Failed to open payment!');
			window.history.back();
			</script>");
    exit();
}
