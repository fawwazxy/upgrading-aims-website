<?php
session_start();
include "../model/v02_aims_others_claim_function.php";
$year = $_POST['year'];
$month = $_POST['month'];
$verification = $_POST['verification'];
$department_code = $_POST['department_code'];

if (isset($_POST['checkbox'])){
    $verification_by = $_SESSION['SESS_ID'];
    $verification_status = ($_POST['verification_status'] == "APPROVE") ? '1' : '0';

    $checkbox = $_POST['checkbox'];
    $id_array = array();
    foreach ($checkbox as $data){
        $data_array = explode("#",$data);
        array_push($id_array, v02getOthersClaimID($data_array[0], $data_array[1]));
    }

    $set_of_id = "(" . implode(",", $id_array). ")"; // ('171','173')
    print_r($set_of_id);

    $result = v02OthersClaimApproved($set_of_id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script>
        alert('Successfully Approved/Disapproved Selected Claim');
       window.location.href='../view/v02_aims_others_claim_ceo_list.php?year=$year&month=$month&department_code=$department_code&verification=$verification';
        </script>");
        exit();
    } else {
        die("Failed Query Approved/Disapproved".$result);
    }
} else {
    echo ("<script>
    alert('Please select at least one claim');
    window.history.back();
    </script>");
    exit();
}