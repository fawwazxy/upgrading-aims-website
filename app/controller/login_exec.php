<?php
include "../model/functions.php";
session_start();

$username = clean($_POST['username']);
$password = clean($_POST['password']);

$login = login($username);

if ($login -> num_rows == 1) {
    $row = $login->fetch_assoc();

    if (password_verify($password, $row['accs_pwd'])){

        //start jana tarikh bekerja
        if(!in_array($row['role_id'], ['SUPERADMIN', 'ADMIN'])){
            if(checkTahunAvailbility(date('Y'),$row['no_staff']) == 0){
                $date = date('Y').'-01-01';

                $end_date = date('Y').'-12-31';
                $sys_id='1';

                janaHujungMinggu($sys_id,$row['no_staff']);

                while (strtotime($date) <= strtotime($end_date)) {
                    $hari=date("l", strtotime($date));
                    $hari_minggu = getStatusHujungMinggu($hari,$row['no_staff'])->fetch_assoc();
                    if($hari_minggu['status']=='1'){
                        $status='0';
                    }else{
                        $status='1';
                    }
                    $result = janaTarikh($sys_id,$date,$status,$row['no_staff']);
                    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
            }
        }

        session_regenerate_id();
        $_SESSION["auth"] = true;
        $_SESSION['SESS_ID'] = $row['id'];
        $_SESSION['SYS_ID'] = $row['sys_id'];
        $_SESSION['SESS_NAME'] = $row['name'];
        $_SESSION['SESS_COM'] = $row['company_id'];
        $_SESSION['SESS_STATUS'] = $row['status'];
        $_SESSION['SESS_ROLE'] = $row['role_id'];
        $_SESSION['SESS_NO_STAFF'] = $row['no_staff'];
        $_SESSION['SESS_NOKP'] = $row['noic'];
        $_SESSION['SESS_CAWANGAN'] = $row['cawangan_kod'];
        $_SESSION['SESS_DEPARTMENT'] = $row['department_id'];
        $_SESSION['SESS_DEPARTMENT_SUB'] = $row['department_sub'];
        $_SESSION['SESS_NO_TELEFON'] = $row['phone'];
        $_SESSION['SESS_EMAIL'] = $row['email'];
        session_write_close();

        if ($row['role_id'] != '') {
            echo ("<script type='text/javascript'> window.location.href='../view/dashboard.php';</script>");
            exit();
        } else {
            echo "<script type='text/javascript'> alert('Sorry, site under maintenance.'); history.back();";
            exit();
        }
    } else {
        echo "<script type='text/javascript'> alert('Log Masuk Gagal. Kata Laluan salah'); history.back();</script>";
        exit();
    }
} else {
    echo "<script type='text/javascript'> alert('Log Masuk Gagal. Nama Pengguna salah'); history.back();</script>";
    exit();
}