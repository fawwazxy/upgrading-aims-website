<?php
session_start();
include "../model/v02_aims_ot_function.php";

$id = clean($_POST['id']);
$hr_status = (clean($_POST['hr_form']) == 'REVIEW') ? '1' : '0';
$hr_staff_no = $_SESSION['SESS_ID'];

$normal_hour = ($hr_status == '0') ? NULL : clean($_POST['normal_hour']);
$normal_wageperhour = ($hr_status == '0') ? NULL : clean($_POST['normal_wageperhour']);
$normal_totalwages = ($hr_status == '0') ? NULL : clean($_POST['normal_totalwages']);
$weekend_hour = ($hr_status == '0') ? NULL : clean($_POST['weekend_hour']);
$weekend_wageperhour = ($hr_status == '0') ? NULL : clean($_POST['weekend_wageperhour']);
$weekend_totalwages = ($hr_status == '0') ? NULL : clean($_POST['weekend_totalwages']);
$holiday_hour = ($hr_status == '0') ? NULL : clean($_POST['holiday_hour']);
$holiday_wageperhour = ($hr_status == '0') ? NULL : clean($_POST['holiday_wageperhour']);
$holiday_totalwages = ($hr_status == '0') ? NULL : clean($_POST['holiday_totalwages']);
$special_hour = ($hr_status == '0') ? NULL : clean($_POST['special_hour']);
$special_wageperhour = ($hr_status == '0') ? NULL : clean($_POST['special_wageperhour']);
$special_totalwages = ($hr_status == '0') ? NULL : clean($_POST['special_totalwages']);
$total_claim = ($hr_status == '0') ? NULL : clean($_POST['total_claim']);


$result = v02reviewOtClaim($id,$normal_hour,$normal_wageperhour,$normal_totalwages,$weekend_hour,$weekend_wageperhour,$weekend_totalwages,
    $holiday_hour,$holiday_wageperhour,$holiday_totalwages,$special_hour,$special_wageperhour,$special_totalwages,$total_claim,$hr_status,$hr_staff_no);

//Check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script>
            alert('Successfully Review Month Claim');
            window.location.href = '../view/v02_aims_ot_hr_update_form.php?id=".$id."';
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Error: '.$result);
            window.history.back();
            </script>");
    exit();
}

/*
foreach ($_POST as $field => $value){
    echo $field.' - '.$value.'<br>';
}

echo 'month_session_id = '.$id.'<br>';
echo 'hr_status = '.$hr_status.'<br>';
echo 'staff_no = '.$hr_staff_no.'<br>';
echo 'n_h = '.$normal_hour.'<br>';
echo 'n_wph = '.$normal_wageperhour.'<br>';
echo 'n_tw = '.$normal_totalwages.'<br>';
echo 'w_h = '.$weekend_hour.'<br>';
echo 'w_wph = '.$weekend_wageperhour.'<br>';
echo 'w_tw = '.$weekend_totalwages.'<br>';
echo 'h_h = '.$holiday_hour.'<br>';
echo 'h_wph = '.$holiday_wageperhour.'<br>';
echo 'h_tw = '.$holiday_totalwages.'<br>';
echo 's_h = '.$special_hour.'<br>';
echo 's_wph = '.$special_wageperhour.'<br>';
echo 's_tw = '.$special_totalwages.'<br>';
echo 'total_claim = '.$total_claim.'<br>';
exit();

*/






