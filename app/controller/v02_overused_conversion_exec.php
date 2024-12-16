<?php
include "../model/v02_aims_ot_function.php";

//sanitize the POST values
$id = clean($_POST['month_session_id']);
$total_overused = clean($_POST['total_overused']);
$convert_to_off_day = clean($_POST['convert_to_off_day']);
$convert_to_claim = clean($_POST['convert_to_claim']);

$result = v02overusedConversion($id, $total_overused, $convert_to_off_day, $convert_to_claim);

//check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script>
        alert('Successfully Update Overused Conversion')
	    window.location.href='../view/v02_aims_ot_hr_update_form.php?id=".$id."';
	</script>");
    exit();
}else{
    echo ("<script>
        alert('Failed to update Overused Conversion: ".$result."');
	    window.location.href='../view/v02_aims_ot_hr_update_form.php?id=".$id."';
	</script>");
    exit();
}