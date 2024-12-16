<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

/*If user checked the checkbox*/
if (isset($_POST['checkbox'])){
    $checkbox = $_POST['checkbox'];
    $verification_by = $_POST['staff_id_verify'];
    $verification_status = ($_POST['verification_status'] == "VERIFY") ? '1' : '0';
    $id = "('" . implode("','", $checkbox) . "');";

    $result = v02OthersClaimVerify($id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script type='text/javascript'>
        alert('Successfully Verified/Unverified Selected Claim');
        window.history.back();
        </script>");
        exit();
    } else {
        die("Failed Verified/Unverified: ".$result);
    }
} else {
    echo ("<script type='text/javascript'>
    alert('Please select at least one claim');
    window.history.back();
    </script>");
    exit();
}