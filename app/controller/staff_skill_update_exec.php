<?php
include "../model/staff_function.php";

$sess_id = $_POST['sess_id'];
$skill_id = $_POST['skill_id'];
$skill = $_POST['skill'];
$level = $_POST['level'];

$result = staffSkillUpdate($skill_id,$skill,$level,$sess_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya kemaskini maklumat kemahiran')
            history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal kemaskini maklumat kemahiran')
            history.back();
            </script>");
    exit();
}