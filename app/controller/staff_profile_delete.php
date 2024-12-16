<?php
require "../model/staff_function.php";
$staff_id = $_GET['id'];

$result = staffProfileDefault($staff_id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
        alert('Berjaya padam profil')
        history.back();
        </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
        alert('Gagal padam profil')
        history.back();
        </script>");
    exit();
}