<?php
session_start();
include "../model/v02_aims_inout_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$support_by = $_SESSION['SESS_ID'];

$result = supportInOut($id, $action, $support_by);

if($result == true) {
    echo "<script>
            alert('In/Out application successfully supported/rejected');
			window.location.href='../view/v02_aims_inout_support.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to support or reject the application');
			window.history.back();
			</script>";
}
