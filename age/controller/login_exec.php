<?php
include "../model/functions.php";

session_start();

$username = clean($_POST['username']);
$password = clean($_POST['password']);

$login = login($username);

if ($login -> num_rows == 1) {
    $row = $login->fetch_assoc();

    if (password_verify($password, $row['accs_pwd'])){
        session_regenerate_id();
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
        session_write_close();

        if ($row['role_id'] != '') {
            echo ("<script type='text/javascript'>
            window.location.href='../view/dashboard.php';
            </script>");
            //header("location: ../view/dashboard.php");
            exit();
        } else {
            $fail = 'Sorry, site under maintenance.';
            echo "<script type='text/javascript'> alert(\"$fail\"); location.href = '../view/login.php';</script>";
            echo ("<script type='text/javascript'>
            window.location.href='../view/login.php';
            </script>");
            //header("location: ../view/login.php");
            exit();
        }
    } else {
        echo "<script type='text/javascript'> alert('Kata Laluan salah'); location.href = '../view/login.php';</script>";
        exit();

    }
} else {
    //Login failed
    $fail = 'Log Masuk Gagal.\nNama salah.';
    echo "<script type='text/javascript'> alert(\"$fail\"); location.href = '../view/login.php';</script>";
    exit();
}

//$conn->close();
?>