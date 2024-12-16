<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

/*If user checked the checkbox*/
if (isset($_POST['checkbox'])){
    $checkbox = $_POST['checkbox'];
    $verification_by = $_SESSION['SESS_ID'];
    $verification_status = ($_POST['verification_status'] == "APPROVE") ? '1' : '0';
    /*implode = returns string from elements of array */
    $id = "('" . implode("','", $checkbox) . "');";

    $result = v02OthersClaimApproved($id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script>
            alert('Successfully Approved/Disapproved Selected Claim');
            history.back();
        </script>");
        exit();
    } else {
        die("Failed Approved/Disapproved ".$result);
    }
} else {
    echo ("<script>
        alert('Please select at least one claim');
        window.history.back();
    </script>");
    exit();
}