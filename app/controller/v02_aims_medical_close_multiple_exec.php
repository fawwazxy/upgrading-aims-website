<?php
session_start();
require "../model/v02_aims_medical_function.php";

if(isset($_POST['medical_id'])) {
    $medical_id_array = $_POST['medical_id'];
    $closed_by = $_SESSION['SESS_ID'];
    $action = $_POST['verify_status'];
    $medical_id_string = "('" . implode("','", $medical_id_array) . "');";

    $result = multipleCloseMedical($medical_id_string, $action, $closed_by);

    if ($result){
        echo ("<script>
            alert('".count($medical_id_array)." medical claim successfully closed/opened');
            window.history.back();
            </script>");
        exit();
    }else{
        echo ("<script>
            alert('Failed to close/open medical claim');
            window.history.back();
            </script>");
        exit();
    }

}else{
    echo ("<script>
            alert('Please select at least one medical claim');
            window.history.back();
            </script>");
    exit();
}
