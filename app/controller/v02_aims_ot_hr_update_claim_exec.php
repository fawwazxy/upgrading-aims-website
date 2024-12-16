<?php
include "../model/v02_aims_ot_function.php";
//sanitize the POST values

$id= clean($_POST['id']);
$rate_mode= clean($_POST['rate_mode']);
$month_claim = clean($_POST['month_claim']);
$staff_id = clean($_POST['staff_id']);
$total_hours= clean($_POST['total_hours']);
$verification_remark= (empty($_POST['verification_remark'])) ? '-' : clean($_POST['verification_remark']);
$description= (empty($_POST['description'])) ? '-' : clean($_POST['description']);

if ($month_claim != ''){
    v02HrChangeMonthClaim($id, $month_claim, $staff_id);
}

$update_description = v02updateDescription($id, $rate_mode, $description);
$result="";
if ($update_description!="" && $update_description > 0){
    $result = v02updateOtByHR($id, $total_hours, $verification_remark);
    //Check whether the query was successful or not
    if($result!="" && $result > 0){
        echo ("<script>
            alert('Successfully update (HR) OVERTIME CLAIM.')
            window.history.back();
            </script>");
        exit();
    }else{
        echo ("<script>
            alert('Success: description; Failed: Total Hours, Remark; Error: '.$result)
            window.history.back();
            </script>");
        exit();
    }
}else{
    echo ("<script>
            alert('Failed to send update request (HR - OVERTIME CLAIM). Please contact IT Department. Error: '.$update_description)
            window.history.back();
            </script>");
    exit();
}
