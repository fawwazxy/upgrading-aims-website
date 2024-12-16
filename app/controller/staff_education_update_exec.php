<?php
include "../model/staff_function.php";

$sess_id = $_POST['sess_id'];
$edu_id = $_POST['edu_id'];
$pencapaian = $_POST['pencapaian'];
$tempat = $_POST['tempat'];
$keputusan = $_POST['keputusan'];
$tahun_mula = $_POST['tahun_mula'];
$tahun_akhir = $_POST['tahun_akhir'];

$result = staffEducationUpdate($edu_id,$pencapaian,$tempat,$keputusan,$tahun_mula,$tahun_akhir,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya kemaskini maklumat pendidikan')
            history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal kemaskini maklumat pendidikan')
            history.back();
            </script>");
    exit();
}