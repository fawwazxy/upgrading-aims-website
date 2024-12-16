<?php
include "../model/staff_function.php";

$staff_id = $_POST['id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if($new_password != $confirm_password){
    echo "<script type='text/javascript'> alert('Kata laluan yang baharu tidak sepadan'); window.location.href = '../view/login_edit.php';</script>";
    exit();
}

$encrypted = password_hash($confirm_password, PASSWORD_BCRYPT);
$db_password = getStaffById($staff_id)->fetch_object()->accs_pwd;

if(!password_verify($old_password, $db_password)){
    echo "<script type='text/javascript'> alert('Kata laluan lama tidak sah'); window.location.href = '../view/login_edit.php';</script>";
    exit();
}
$result = updateKataLaluan($staff_id,$encrypted);

if(!$result){
    echo ("<script type='text/javascript'> alert('Kata laluan gagal dikemaskini');window.location.href='../view/login_edit.php';</script>");
    exit();
}

//----------------------------------------------------------------------------------------------------------------------
#send data to aims-corp
$url = 'https://corp.aimsglobal.com.my/api/staff/password/'.$staff_id;

$headers = array(
    'token:AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
    'Content-Type:application/json',
    'Accept:application/json'
);

$data = [
    'password' => $encrypted,
];


$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$result2 = curl_exec($ch);
curl_close($ch);

$result2_decoded = json_decode($result2, true);

if(!$result2){
    updatePassword($staff_id,$db_password);
    echo ("<script type='text/javascript'> alert('Kata laluan gagal dikemaskini- ".$result2_decoded["message"]."');
    window.location.href='../view/login_edit.php';</script>");
    exit();
}

//----------------------------------------------------------------------------------------------------------------------

echo ("<script type='text/javascript'> alert('Kata laluan berjaya dikemaskini');window.location.href='../view/login_edit.php';</script>");
exit();

