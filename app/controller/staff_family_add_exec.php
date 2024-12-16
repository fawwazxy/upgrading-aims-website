<?php
session_start();
include "../model/staff_function.php";

$sess_id = $_SESSION['SESS_ID'];
$staff_id = $_POST['staff_id'];
$staff_no = $_POST['staff_no'];
$name = $_POST['name'];
$work = $_POST['work'];
$relationship = $_POST['relationship'];
$phone = $_POST['phone'];

$result = staffFamilyAdd($staff_no,$name,$work,$relationship,$phone,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya tambah maklumat keluarga')
                window.location.href='../view/staff_family.php?flagScreen=tab_5&id=$staff_id';
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal tambah maklumat keluarga')
            history.back();
            </script>");
    exit();
}