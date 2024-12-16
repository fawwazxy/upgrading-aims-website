<?php
include "../model/staff_function.php";

$exp_id = $_GET['id'];

$result = staffExperienceDelete($exp_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya padam maklumat pekerjaan')
           history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal padam maklumat pekerjaan')
            history.back();
            </script>");
    exit();
}