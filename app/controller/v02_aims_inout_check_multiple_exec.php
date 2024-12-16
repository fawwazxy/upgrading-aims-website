<?php
session_start();
require "../model/v02_aims_inout_function.php";
$success=0;

if(isset($_POST['inout_id'])) {
    $inout_id_array = array_reverse($_POST['inout_id']);
    $checked_by = $_SESSION['SESS_ID'];
    $action = ($_POST['check_status'] == "CHECK") ? '1' : '0';

    foreach ($inout_id_array as $inout_id){

        $result = hrCheckInOut($inout_id, $action, $checked_by);

        if ($result == true){
            $success++;
        }
    }
    echo ("<script>
            alert('$success application successfully checked/rejected');
            window.history.back();
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Please select at least one');
            window.history.back();
            </script>");
    exit();
}
