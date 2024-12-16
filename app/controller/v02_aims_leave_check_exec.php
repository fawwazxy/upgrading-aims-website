<?php
session_start();
include "../model/v02_aims_leave_function.php";

$id = $_GET['id'];
$action = $_GET['action'];
$checked_by = $_SESSION['SESS_ID'];

$current_balance = getCurrentBalanceFromLeaveId($id);

if($action == '1'){
    //get leave info using leave id
    $leave_info = getLeaveById($id)->fetch_assoc();

    if (in_array($leave_info['leave_type'], getLeaveQuotaList(true))){

        //subtract current balance if checked by HR
        $current_balance -= $leave_info['total_days'];

        $subtract_quota = subtractLeaveQuota($leave_info['staff_id'], $leave_info['leave_type'], $leave_info['start_date'], $current_balance);

        if ($subtract_quota != true){
            echo "<script>
            alert('Gagal untuk kemaskini kuota cuti. Sila hubungi pihak IT');
			window.history.back();
			</script>";
            exit();
        }
    }else{
        $current_balance = null;
    }
}

$result = hrCheckLeave($id, $action, $checked_by, $current_balance);

if($result == true) {
    echo "<script>
            alert('Berjaya meluluskan/menolak permohonan cuti.');
			window.history.back();
			</script>";
}else{
    echo "<script>
            alert('Gagal untuk meluluskan/menolak permohonan cuti!!!');
			window.history.back();
			</script>";
}