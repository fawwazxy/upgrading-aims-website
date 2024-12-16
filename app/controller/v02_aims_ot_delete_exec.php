<?php
include "../model/v02_aims_ot_function.php";

$id = ($_GET['id']);
$del_otp = ($_GET['del_otp']);
$ot_info = v02getOtInfo($id)->fetch_assoc();
$file = "../../overtimephoto/" . $ot_info['document_name'];

$date_info = v02updateDateSummary($ot_info['ot_date_id'],$ot_info['total_hours']);

$result = v02deleteOt($id);
if ($del_otp == 1){
    v02deleteOtPermission($ot_info['ot_permission_id']);
}

//Check whether the query was successful or not
if($result!="" && $result > 0){
	unlink($file);
	echo ("<script>
            alert('Successfully deleted OVERTIME CLAIM. You can make a re-claim for the overtime.')
            window.history.back();
            </script>");
	exit();
}else{
    echo ("<script>
            alert('Failed to delete OVERTIME CLAIM. Please contact IT Department')
            window.history.back();
            </script>");
    exit();
}









