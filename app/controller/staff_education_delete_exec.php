<?php
include "../model/staff_function.php";

$edu_id = $_GET['id'];

$result = staffEducationDelete($edu_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya padam maklumat pendidikan')
           history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal padam maklumat pendidikan')
            history.back();
            </script>");
    exit();
}