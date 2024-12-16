<?php
require "../../lib/db/connection.php";

$sql = "SELECT id, description FROM v02_aims_others_claim";
$result = db()->query($sql);

$i=1;
$array = array();

while ($row = $result->fetch_assoc()){

    $new_description = str_replace('<br />', '', $row['description']);

    $update = "UPDATE v02_aims_others_claim SET description = '$new_description' WHERE id = '".$row['id']."'";
    db()->query($update);

    array_push($array, [
        "old" => $row['id'].": ".$row['description'],
        "new" => $row['id'].": ".$new_description,
        ]);
}

echo json_encode($array);