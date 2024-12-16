<?php
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
//$start_ot = $_POST['start_ot'];
//$end_ot = $_POST['end_ot'];
$total_hours = $_POST['total_hours'];
$rate_mode = $_POST['rate_mode'];
$description = $_POST['description'];

$update_description = v02updateDescription($id, $rate_mode, $description);
$result="";
if ($update_description!="" && $update_description > 0){

    $ot_info = v02getOtInfo($id)->fetch_assoc();
    $date_id = $ot_info['ot_date_id'];
    $previous_hour = $ot_info['total_hours'];
    //update date summary
    hourAdjust($date_id, $previous_hour, $total_hours);

    $result = v02updateClaimHod($id, $total_hours);
    //Check whether the query was successful or not
    if($result!="" && $result > 0){
        echo ("<script>
            alert('Successfully update (HOD) OVERTIME CLAIM.')
            window.history.back();
            </script>");
        exit();
    }else{
        echo ("<script>
            alert('Success: description; Failed: Total working hours; Error: '.$result)
            window.history.back();
            </script>");
        exit();
    }
}else{
    echo ("<script>
            alert('Failed to send update request (HOD - OVERTIME CLAIM). Please contact IT Department. Error: '.$update_description)
            window.history.back();
            </script>");
    exit();
}

