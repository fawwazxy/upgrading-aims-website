<?php
session_start();
include "../model/v02_aims_inout_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$approval_by = $_SESSION['SESS_ID'];

$result = approveInOut($id, $action, $approval_by);

if($result == true) {
    echo "<script>
            alert('In/Out application successfully approved/rejected.');
			window.location.href='../view/v02_aims_inout_approval.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to approve/reject the application');
			window.history.back();
			</script>";
}
