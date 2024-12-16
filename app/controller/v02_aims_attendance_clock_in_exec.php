<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";
/*print_r($_POST);
exit();*/
$act = $_POST['act'];
$created_by = clean($_POST['created_by']);
$staff_ic = clean($_POST['staff_ic']);
$branch_code = clean($_POST['branch_code']);
$location_code = clean($_POST['location_code']);

if ($act == "in") {
    $result = addClockIn($created_by, $staff_ic, $location_code, 'MANUAL-LOG',null);
    if($result!="" && $result > 0){
        $message = "Successfully Clock In";
    }else{
        $message = "Failed to Clock In: ".$result;
    }
} else {
    $result = updateClockOut($created_by, $staff_ic, $location_code, 'MANUAL-LOG', null);
    if($result!="" && $result > 0){
        $message = "Successfully Clock Out";
    }else{
        $message = "Failed to Clock Out: ".$result;
    }
}
echo ("<script>
        alert('$message');
	    window.location.href='../view/v02_aims_attendance_manual_log.php';
	</script>");