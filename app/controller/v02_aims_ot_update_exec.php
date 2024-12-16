<?php
include "../model/v02_aims_ot_function.php";

$id = clean($_POST['id']);
$start_ot = clean($_POST['start_ot']);
$end_ot = clean($_POST['end_ot']);
$total_hours = clean($_POST['total_hours']);

$ot_info = v02getOtInfo($id)->fetch_assoc();
$date_id = $ot_info['ot_date_id'];
$previous_hour = $ot_info['total_hours'];

//update date summary
hourAdjust($date_id, $previous_hour, $total_hours);

$result = v02updateOt($id,$start_ot,$end_ot,$total_hours);

//check whether the query was successful or not
if($result!="" && $result > 0){
    $message = "Successfully Update Overtime Claim";
}else{
    $message = "Failed to update Overtime Claim: ".$result;
}

echo ("<script>
        alert('$message');
	    window.history.back();
	</script>");