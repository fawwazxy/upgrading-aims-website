<?php
session_start();
include "../model/v02_aims_ot_function.php";

$id = ($_POST['id']);
$approved_status = ($_POST['approved_status']);
$approved_by = $_SESSION['SESS_ID'];

$otm = v02getMonthSessionDetails($id)->fetch_assoc();
$staff_applicant_name = $otm['name'];
$month_session = $otm['month_session'];

$result = v02approveOtClaim($id,$approved_by,$approved_status);

//Check whether the query was successful or not
if($result!="" && $result > 0){
	echo "<script>
			alert('All overtime claim of ".$staff_applicant_name." for ".strtoupper($month_session)." has been approved/declined.');
            window.history.back();
		</script>";
}else{
	echo ("<script>
            alert('Failed to Approve/Decline OT Claim !');
            window.history.back();
            </script>");
	exit();
}







