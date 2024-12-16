<?php
session_start();
include "../model/v02_aims_medical_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$approved_by = $_SESSION['SESS_ID'];

$result = updatePaymentStatusMedical($id, $action, $approved_by);

if($result == true) {
    echo "<script>
            alert('Successfully $action medical claim.');
			window.history.back();
			</script>";
}else{
    echo "<script>
            alert('Failed to $action medical claim');
			window.history.back();
			</script>";
}