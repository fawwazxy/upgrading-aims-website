<?php
header('Content-type: application/json');
require '../model/data_transfer.php';

$i = 1;
$success = 0;
$error_text = '';
$array = array();

$staffInfo = getStaff();
while ($row = $staffInfo->fetch_assoc()){
    $id = $row['id'];
    $no_staff = $row['no_staff'];
    $noic = $row['noic'];
    $name = $row['name'];
    $username = $row['username'];
    $accs_pwd = $row['accs_pwd'];
    $email = $row['email'];
    $alamat_tetap = $row['alamat_tetap'];
    $alamat_surat = $row['alamat_surat'];
    $umur = $row['umur'];
    $jawatan_code = $row['jawatan_code'];
    $role_id= $row['role_id'];
    $department_id = $row['department_id'];
    $company_id = $row['company_id'];
    $cawangan_kod = $row['cawangan_kod'];
    $department_sub = $row['department_sub'];
    $status = $row['status'];
    $created_date = $row['created_date'];
    $martial_status = $row['martial_status'];
    $tanggungan = $row['tanggungan'];
    $photo = $row['photo'];
    $nama_photo = $row['nama_photo'];
    $gender = $row['gender'];
    $pantau_kehadiran = $row['pantau_kehadiran'];
    $jenis_darah = $row['jenis_darah'];
    $shift_kerja = $row['shift_kerja'];
    $leave_approval = $row['leave_approval'];
    $jum_jam_kerja = $row['jum_jam_kerja'];
    $jum_jam_break = $row['jum_jam_break'];
    $status_qrcode = $row['status_qrcode'];
    $status_swafoto = $row['status_swafoto'];
    $status_tag = $row['status_tag'];

    $encryted = password_hash($accs_pwd, PASSWORD_BCRYPT);


    $new_value = array(
        $id, $no_staff, $accs_pwd, $encryted
    );

    $array[$i][0] = $row;
    $array[$i][1] = $new_value;
    $i++;

    /*$password_update = updatePassword($id, $encryted);
    if ($password_update){
        $success++;
    }else{
        $error_text .= $name.": ".$password_update."<br>";
    }*/
    $temporary_password = passwordBackup($id, $accs_pwd);
    if ($temporary_password){
        $success++;
    }else{
        $error_text .= $name.": ".$temporary_password."<br>";
    }
}
//echo json_encode($array);
echo $success.' password copied';
if (!empty($error_text)){
    echo "<br><br>Error: <br>";
    echo $error_text;
}

