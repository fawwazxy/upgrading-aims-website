<?php
require "../../lib/db/connection.php";

$sql = "SELECT id, name, noic, umur FROM staff WHERE no_staff <> 'ADMIN' && no_staff <> 'SUPERADMIN'";
$staff_info = db()->query($sql);

$i=1;
$array = array();

while ($row = $staff_info->fetch_assoc()){

    $id = $row['id'];
    $name = $row['name'];
    $noic = $row['noic'];
    $birthdate = $row['umur'];

    $date = substr($noic, 0, 6);

    $day = substr($date, 4, 2);
    $month = substr($date, 2, 2);
    $year = substr($date, 0, 2);
    $year = date('y') < $year ? '19'.$year : '20'.$year;

    $date2 = $year.'-'.$month.'-'.$day;

    $new_value = array(
        $id, $name,$noic, $birthdate, $date, $date2
    );

    $array[$i][0] = $row;
    $array[$i][1] = $new_value;
    $i++;

    $update = "UPDATE staff SET umur = '$date2' WHERE id = '$id'";
    db()->query($update);
}
echo json_encode($array);

