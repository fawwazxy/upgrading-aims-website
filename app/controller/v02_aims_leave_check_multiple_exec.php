<?php
session_start();
require "../model/v02_aims_leave_function.php";
$success=0;

if(isset($_POST['leave_id'])) {
    $leave_id_array = array_reverse($_POST['leave_id']);
    $checked_by = $_SESSION['SESS_ID'];
    $action = ($_POST['check_status'] == "SEMAK") ? '1' : '0';

    foreach ($leave_id_array as $leave_id){
        $current_balance = getCurrentBalanceFromLeaveId($leave_id);

        if($action == '1'){
            //get leave info using leave id
            $leave_info = getLeaveById($leave_id)->fetch_assoc();

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
        }
        $result = hrCheckLeave($leave_id, $action, $checked_by, $current_balance);

        if ($result == true){
            $success++;
        }
    }
    echo ("<script>
            alert('$success permohonan berjaya disemak/dibatalkan');
            window.history.back();
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Tiada permohonan dipilih untuk semakan');
            window.history.back();
            </script>");
    exit();
}
