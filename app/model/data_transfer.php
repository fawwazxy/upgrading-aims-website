<?php
require '../../lib/db/connection.php';

function getStaff(){
    $conn=db();
    return $conn->query("SELECT * FROM staff");
}

function updatePassword($id, $encryted){
    $conn=db();
    return $conn->query("UPDATE staff SET accs_pwd = '$encryted' WHERE id = '$id'");
}

function passwordBackup($id, $accs_pwd){
    $conn=db();
    return $conn->query("UPDATE staff SET jenis_darah = '$accs_pwd' WHERE id = '$id'");
}