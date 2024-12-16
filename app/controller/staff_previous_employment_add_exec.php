<?php
session_start();
include "../model/staff_function.php";

$sess_id = $_SESSION['SESS_ID'];
$staff_id = $_POST['staff_id'];
$staff_no = $_POST['staff_no'];
$tempat_bekerja = $_POST['tempat_bekerja'];
$tarikh_mula = $_POST['tarikh_mula'];
$tarikh_akhir = $_POST['tarikh_akhir'];
$gaji = $_POST['gaji'];
$jawatan = $_POST['jawatan'];
$peranan = $_POST['peranan'];

$result = staffExperienceAdd($staff_no,$tempat_bekerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya tambah maklumat pekerjaan')
            window.location.href='../view/staff_previous_employment.php?flagScreen=tab_3&id=$staff_id';
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal tambah maklumat pekerjaan')
            history.back();
            </script>");
    exit();
}