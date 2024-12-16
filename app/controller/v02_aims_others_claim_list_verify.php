<?php
include "../model/v02_aims_others_claim_function.php";

if (isset($_POST['checkbox'])){
    $year = $_POST['year'];
    $month = $_POST['month'];
    $verification = $_POST['verification'];
    $verification_by = $_POST['staff_id'];
    $verification_status = ($_POST['verification_status'] == "VERIFY") ? '1' : '0';

    $checkbox = $_POST['checkbox'];
    $id_array = array();
    foreach ($checkbox as $data){
        $data_array = explode("#",$data);
        array_push($id_array, v02getOthersClaimIDVerify($data_array[0], $data_array[1]));
    }

    $set_of_id = "(" . implode(",", $id_array). ")"; // ('171','173')
    print_r($set_of_id);

    $result = v02OthersClaimVerify($set_of_id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script>
        alert('Successfully Verified/Unverified Selected Claim');
       window.location.href='../view/v02_aims_others_claim_hod_list.php?year=$year&month=$month&verification=$verification';
        </script>");
        exit();
    } else {
        die("Failed Query Verified/Rejected".$result);
    }
} else {
    echo ("<script>
    alert('Please select at least one claim');
    window.history.back();
    </script>");
    exit();
}