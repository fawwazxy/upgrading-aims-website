<?php
include "../model/v02_aims_ot_function.php";
if(isset($_POST['checkbox'])) {
    $checkbox = $_POST['checkbox'];
    $approval_status = ($_POST['approval_status'] == "APPROVE") ? '1' : '0';
    $id = "('" . implode("','", $checkbox) . "');";
    $result = v02getCheckboxApproveOtp($id,$approval_status);

    //Check whether the query was successful or not
    if($result!="" && $result > 0){
        echo ("<script>
            alert('Successfully Approve/Decline selected OT Permission');
            window.history.back();
            </script>");
        exit();
    }else{
        die("Query failed: ".$result);
    }
}else{
    echo ("<script>
            alert('Please select at least one OT PERMISSION');
            window.history.back();
            </script>");
    exit();
}
