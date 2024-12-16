<?php
session_start();
include "../model/staff_function.php";

$sess_id = $_SESSION['SESS_ID'];
$staff_id = $_POST['staff_id'];
$staff_no = $_POST['staff_no'];
$pencapaian = $_POST['pencapaian'];
$tempat = $_POST['tempat'];
$keputusan = $_POST['keputusan'];
$tahun_mula = $_POST['tahun_mula'];
$tahun_akhir = $_POST['tahun_akhir'];

$result = staffEducationAdd($staff_no,$pencapaian,$tempat,$keputusan,$tahun_mula,$tahun_akhir,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya rekod maklumat pendidikan')
            window.location.href='../view/staff_education.php?flagScreen=tab_2&id=$staff_id';
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal rekod maklumat pendidikan')
            history.back();
            </script>");
    exit();
}