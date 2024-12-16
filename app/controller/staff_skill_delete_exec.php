<?php
include "../model/staff_function.php";

$skill_id = $_GET['id'];

$result = staffSkillDelete($skill_id);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya padam maklumat kemahiran')
           history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal padam maklumat kemahiran')
            history.back();
            </script>");
    exit();
}