<?php
include "../model/v02_aims_ot_function.php";
$prev_approval = $_POST['approval'];
if(isset($_POST['checkbox'])) {
    $checkbox = $_POST['checkbox'];
    $approval_by = clean($_POST['approval_id']);
    $approval_status = ($_POST['approved_status'] == "APPROVE") ? '1' : '0';
    $id = "('" . implode("','", $checkbox) . "');";
    $result = v02CheckboxApproveMonthClaim($id, $approval_by, $approval_status, $prev_approval);

    //Check whether the query was successful or not
    if($result!="" && $result > 0){
        echo ("<script>
            alert('Successfully Approved/Declined selected OT Claim');
            window.history.back();
            </script>");
        exit();
    }else{
        die("Query failed: ".$result);
    }
}else{
    echo ("<script>
            alert('Please select at least one OT Claim');
            window.history.back();
            </script>");
    exit();
}
