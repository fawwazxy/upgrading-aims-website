<?php
include "../model/staff_function.php";

$sess_id = $_POST['sess_id'];
$family_id = $_POST['family_id'];
$name = $_POST['name'];
$work = $_POST['work'];
$relationship = $_POST['relationship'];
$phone = $_POST['phone'];

$result = staffFamilyUpdate($family_id,$name,$work,$relationship,$phone,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya kemaskini maklumat keluarga')
            history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal kemaskini maklumat keluarga')
            history.back();
            </script>");
    exit();
}