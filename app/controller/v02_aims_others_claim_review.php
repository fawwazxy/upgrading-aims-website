<?php
session_start();
include "../model/v02_aims_others_claim_function.php";

/*If user checked the checkbox*/
if (isset($_POST['checkbox'])){
    $checkbox = $_POST['checkbox'];
    $verification_by = $_SESSION['SESS_ID'];
    $verification_status = ($_POST['verification_status'] == "REVIEW") ? '1' : '0';
    /*implode = returns string from elements of array */
    $id = "('" . implode("','", $checkbox) . "');";
    /* --> print_r($id) = ('11','13','14') */

    $result = v02OthersClaimReview($id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script type='text/javascript'>
        alert('Successfully Reviewed/Rejected Selected Claim');
       history.back();
        </script>");
        exit();
    } else {
        echo ("<script type='text/javascript'>
        alert('Failed to Review/Reject claim: '.$result);
       history.back();
        </script>");
        exit();
    }
} else {
    echo ("<script type='text/javascript'>
    alert('Please select at least one claim');
    window.history.back();
    </script>");
    exit();
}

?>