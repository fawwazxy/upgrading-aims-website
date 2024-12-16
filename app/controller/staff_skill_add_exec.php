<?php
session_start();
include "../model/staff_function.php";

$sess_id = $_SESSION['SESS_ID'];
$staff_id = $_POST['staff_id'];
$staff_no = $_POST['staff_no'];
$skill = $_POST['skill'];
$level = $_POST['level'];

$result = staffSkillAdd($staff_no,$skill,$level,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya tambah maklumat kemahiran')
            window.location.href='../view/staff_skill.php?flagScreen=tab_4&id=$staff_id';
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal tambah maklumat kemahiran')
            history.back();
            </script>");
    exit();
}