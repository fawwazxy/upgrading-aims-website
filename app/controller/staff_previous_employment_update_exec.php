<?php
include "../model/staff_function.php";

$sess_id = $_POST['sess_id'];
$exp_id = $_POST['exp_id'];
$tempat_bekerja = $_POST['tempat_bekerja'];
$tarikh_mula = $_POST['tarikh_mula'];
$tarikh_akhir = $_POST['tarikh_akhir'];
$gaji = $_POST['gaji'];
$jawatan = $_POST['jawatan'];
$peranan = $_POST['peranan'];

$result = staffExperienceUpdate($exp_id,$tempat_bekerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya kemaskini maklumat pekerjaan')
            history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal kemaskini maklumat pekerjaan')
            history.back();
            </script>");
    exit();
}