<?php
include "../model/staff_function.php";

$staff_id = $_POST['staff_id'];
$name = $_POST['name'];
$ic_number = $_POST['noic'];
$staff_no = $_POST['no_staff'];
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
$preferred_shift = $_POST['preferred_shift'];

$old_staff_data = getStaffById($staff_id)->fetch_assoc();
$old_staff_record_data = getStaffRecordByNoStaff($ic_number)->fetch_assoc();

$result = staffUpdate($staff_id,$staff_no, $name,$phone,$email,$martial_status,$tanggungan,$gender,
    $alamat_tetap,$alamat_surat,$peranan,$unit,$bahagian,$lokasi,
    $jum_jam_kerja,$jum_jam_break,$status,$leave_approval,
    $pantau_kehadiran,$status_qrcode,$status_swafoto,$status_tag, $preferred_shift);


if(!$result){
    echo ("<script type='text/javascript'>
        alert('Gagal kemaskini staf')
        window.location.href='../view/staff_update.php?flagScreen=tab_1&id=$staff_id';
        </script>");
    exit();
}

$result2 = staffRecordEdit($ic_number,$tarikh_mula,$tarikh_akhir,$taraf_jawatan,$peranan,$unit,$bahagian,$status,$lokasi);

if(!$result2){
    echo ("<script type='text/javascript'>
        alert('Gagal kemaskini rekod staf')
        window.location.href='../view/staff_update.php?flagScreen=tab_1&id=$staff_id';
        </script>");
    exit();
}

//----------------------------------------------------------------------------------------------------------------------
#send data to aims-corp
$url = 'https://corp.aimsglobal.com.my/api/staff/update/'.$staff_id;

$headers = array(
    'token:AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
    'Content-Type:application/json',
    'Accept:application/json'
);

$data = [
    'name' => $name,
    'phone_no' => $phone,
    'email' => $email,
    'role' => $peranan,
    'company_id' => generateCompanyId($bahagian),
    'department' => $unit,
    'status' => $status=="BEKERJA" ? 1 : 0,
    'gender' => $gender=='LELAKI' ? 1 : 0,
    'approval_id' => generateApprovalId($leave_approval),
];


$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$result3 = curl_exec($ch);
curl_close($ch);

$result3_decoded = json_decode($result3, true);

//----------------------------------------------------------------------------------------------------------------------
if($result3_decoded["data"]!=true){
    echo "1";
    //revert staff update
    staffUpdate($staff_id, $old_staff_data['no_staff'], $old_staff_data["name"],$old_staff_data["phone"],$old_staff_data["email"],$old_staff_data["martial_status"],$old_staff_data["tanggungan"],$old_staff_data["gender"],
        $old_staff_data["alamat_tetap"],$old_staff_data["$alamat_surat"],$old_staff_data["role_id"],$old_staff_data["department_sub"],$old_staff_data["department_id"],$old_staff_data["cawangan_kod"],
        $old_staff_data["jum_jam_kerja"],$old_staff_data["jum_jam_break"],$old_staff_data["status"],$old_staff_data["leave_approval"],
        $pantau_kehadiran["pantau_kehadiran"],$old_staff_data["status_qrcode"],$old_staff_data["status_swafoto"],$old_staff_data["status_tag"], $old_staff_data["preferred_shift"]);
    //revertUpdateStaffRecord
    staffRecordUpdate($old_staff_record_data["id"],$old_staff_record_data["bank_name"],$old_staff_record_data["notes"],$old_staff_record_data["account_no"],$old_staff_record_data["salary"]);
    echo ("<script type='text/javascript'>
                        alert('Gagal - ".$result3_decoded["message"]."')
                        window.location.href='../view/staff_update.php?flagScreen=tab_1&id=$staff_id';
                        </script>");
    exit();
}


echo ("<script type='text/javascript'>
alert('Berjaya kemaskini staf')
window.location.href='../view/staff_update.php?flagScreen=tab_1&id=$staff_id';
</script>");
exit();


