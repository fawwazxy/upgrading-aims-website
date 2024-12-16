<?php
session_start();
include "../model/staff_function.php";
$staff_id = $_GET['id'];

if ($_SESSION['SESS_ROLE'] == 'SUPERADMIN' || in_array($_SESSION['SESS_DEPARTMENT_SUB'],['HR','HR-SEA'])) {
    $staff = getStaffById($staff_id)->fetch_assoc();
    $old_password = $staff["accs_pwd"];
    $noic = substr($staff['noic'], -6);
    $phone = substr($staff['phone'], -4);
    $new_password = $noic . '@' . $phone;
    $encryted = password_hash($new_password, PASSWORD_BCRYPT);
    $result = updatePassword($staff_id, $encryted);

    $back_href = ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR-SEA')? 'staff_info_hr_sea.php':'staff_info.php';


    if (!$result) {
        echo("<script type='text/javascript'>
                alert('Gagal set semula kata laluan');
                window.location.href='../view/$back_href';
                </script>");
        exit();
    }

//----------------------------------------------------------------------------------------------------------------------
    #send data to aims-corp
    $url = 'https://corp.aimsglobal.com.my/api/staff/password/' . $staff_id;

    $headers = array(
        'token:AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
        'Content-Type:application/json',
        'Accept:application/json'
    );

    $data = [
        'password' => $encryted,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result2 = curl_exec($ch);
    curl_close($ch);

    $result2_decoded = json_decode($result2, true);

//----------------------------------------------------------------------------------------------------------------------

    if ($result2_decoded["data"] != true) {
        revertResetPassword($staff_id, $old_password);
        echo("<script type='text/javascript'>
                        alert('Gagal - " . $result2_decoded["message"] . "')
                        window.location.href='../view/staff_add.php';
                        </script>");
        exit();
    } else {
        echo("<script type='text/javascript'>
                alert('Berjaya set semula kata laluan');
                window.location.href='../view/$back_href';
                </script>");
        exit();
    }
} else {
    echo("<script type='text/javascript'>
            alert('Anda tidak dibenarkan melakukan tindakan ini');
            window.history.back();
            </script>");
    exit();
}
