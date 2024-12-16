<?php
session_start();
include "../model/v02_aims_inout_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$checked_by = $_SESSION['SESS_ID'];

$result = hrCheckInOut($id, $action, $checked_by);

if($result == true) {
    echo "<script>
            alert('In/Out application successfully checked.');
			window.history.back();
			</script>";
}else{
    echo "<script>
            alert('In/Out application failed to check');
			window.history.back();
			</script>";
}