<?php
session_start();
include "../model/v02_aims_leave_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$approved_by = $_SESSION['SESS_ID'];

$result = approveLeave($id, $action, $approved_by);

if($result == true) {
    echo "<script>
            alert('Successfully approved/rejected leave application');
			window.location.href='../view/v02_aims_leave_approval.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to approve/reject leave application');
			window.history.back();
			</script>";
}