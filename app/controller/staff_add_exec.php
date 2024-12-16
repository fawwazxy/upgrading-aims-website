<?php
include "../model/staff_function.php";

$ic_number = $_POST['ic_number'];
$name = strtoupper(str_replace("'", "\'", $_POST['name']));
$name_corp = $_POST['name'];
$tarikh_lahir = $_POST['tarikh_lahir'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$martial_status = $_POST['martial_status'];
$tanggungan = $_POST['tanggungan'];
$gender = $_POST['gender'];
$alamat_tetap = $_POST['alamat_tetap'];
$alamat_surat = $_POST['alamat_surat'];
$peranan = $_POST['peranan'];
$unit = $_POST['unit'];
$bahagian = $_POST['bahagian'];
$lokasi = $_POST['lokasi'];
$jum_jam_kerja = $_POST['jum_jam_kerja'];
$jum_jam_break = $_POST['jum_jam_break'];
$tarikh_mula = $_POST['tarikh_mula'];
$tarikh_akhir = $_POST['tarikh_akhir'];
$status = $_POST['status'];
$leave_approval = $_POST['leave_approval'];
$taraf_jawatan = $_POST['taraf_jawatan'];
$pantau_kehadiran = $_POST['pantau_kehadiran'];
$status_qrcode = $_POST['status_qrcode'];
$status_swafoto = $_POST['status_swafoto'];
$status_tag = $_POST['status_tag'];
$created_at = date("Y-m-d H:i:s");
$no_ic_digit = substr($ic_number, -6);
$phone_no_digit = substr($phone, -4);
$new_password = $no_ic_digit.'@'.$phone_no_digit;

$encrypted = password_hash($new_password, PASSWORD_BCRYPT);

if (icNumberIsExist($ic_number)){
    echo ("<script type='text/javascript'>
            alert('Nombor kad pengenalan sudah didaftar. Sila semak di senarai staf')
            window.location.href='../view/staff_add.php';
            </script>");
    exit();
} else {
    $result = staffAdd($ic_number,$encrypted,$name,$tarikh_lahir,$phone,$email,$martial_status,$tanggungan,$gender,
        $alamat_tetap,$alamat_surat,$peranan,$unit,$bahagian,$lokasi,
        $jum_jam_kerja,$jum_jam_break,$status,$leave_approval,
        $pantau_kehadiran,$status_qrcode,$status_swafoto,$status_tag);

    $result2 = staffRunningNoUpdate();

    $result3 = staffRecordAdd($ic_number,$tarikh_mula,$tarikh_akhir,$taraf_jawatan,$peranan,$unit,$bahagian,$status,$lokasi);

    //----------------------------------------------------------------------------------------------------------------------
    #send data to aims-corp
    $url = 'https://corp.aimsglobal.com.my/api/staff/store';
    $headers = array(
        'token:AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
        'Content-Type:application/json',
        'Accept:application/json'
    );
    $data = [
        'id' => $result,
        'name' => $name_corp,
        'no_ic' => $ic_number,
        'password' => $encrypted,
        'phone_no' => $phone,
        'email' => $email,
        'role' => $peranan,
        'company_id' => generateCompanyId($bahagian),
        'department' => $unit,
        'status' => $status=="BEKERJA" ? 1 : 0,
        'gender' => $gender=='LELAKI' ? 1 : 0,
        'approval_id' => generateApprovalId($leave_approval),
        'created_at' => $created_at,
    ];
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    $result4 = curl_exec($ch);
    curl_close($ch);
    $result4_decoded = json_decode($result4, true);
//----------------------------------------------------------------------------------------------------------------------

    if($result!="" && $result > 0) {
        if($result2!="" && $result2 > 0) {
            if($result3!="" && $result3 > 0) {
                if($result4_decoded["data"]==true) {
                    echo ("<script type='text/javascript'>
                        alert('Berjaya tambah rekod staf')
                        window.location.href='../view/staff_education.php?flagScreen=tab_2&id=$result';
                        </script>");
                    exit();
                }
                else {
                    undoAddStaffByNoStaff($ic_number);
                    $message = "Gagal - ".$result4_decoded["message"];
                }
            } else {
                $message = "Gagal tambah rekod staf";
            }
        } else {
            $message = "Gagal kemaskini bilangan staf";
        }
    } else {
        $message = "Gagal tambah staf. Sila cuba lagi";
    }
    echo ("<script type='text/javascript'>
            alert('$message')
            window.location.href='../view/staff_add.php';
            </script>");
    exit();
}