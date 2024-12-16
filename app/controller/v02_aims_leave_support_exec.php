<?php
session_start();
include "../model/v02_aims_leave_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$support_by = $_SESSION['SESS_ID'];

$result = supportLeave($id, $action, $support_by);

if($result == true) {
    echo "<script>
            alert('Successfully support/reject leave applications');
			window.location.href='../view/v02_aims_leave_support.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to support/reject leave application');
			window.history.back();
			</script>";
}