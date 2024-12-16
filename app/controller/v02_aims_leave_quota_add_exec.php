<?php
session_start();
require "../model/v02_aims_leave_function.php";
//sanitize the POST values
$staff_id = clean($_POST['staff_id']);
$leave_type = clean($_POST['leave_type']);
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);
$entitled_balance = clean($_POST['entitled_balance']);
$current_balance = clean($_POST['current_balance']);
$created_by = $_SESSION['SESS_ID'];

$result = insertLeaveQuota($staff_id,$leave_type,$entitled_balance,$current_balance,$start_date,$end_date,$created_by);

if($result == true) {
    echo "<script>
            alert('Kuota cuti pekerja berjaya ditambah');
			window.location.href='../view/v02_aims_leave_quota.php?id=$staff_id';
			</script>";
}else{
    echo "<script>
            alert('Gagal untuk menambah kuota cuti pekerja');
			window.history.back();
			</script>";
}