<?php
include "../model/staff_function.php";

$family_id = $_GET['id'];

$result = staffFamilyDelete($family_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya padam maklumat keluarga')
           history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal padam maklumat keluarga')
            history.back();
            </script>");
    exit();
}