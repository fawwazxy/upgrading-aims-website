<script>
    alert('This file is blocked!');
    window.history.back();
</script>
<!--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        body{
            font-family: "Lucida Console", "Courier New", monospace;
        }
    </style>
</head>
<body>
<?php /*
require "../../lib/db/connection.php";

function encryptPasswordUser($id, $encrypted_password){
    $query = "UPDATE staff SET accs_pwd = '$encrypted_password' WHERE id = '$id'";
    return db()->query($query);
}

$sql = "SELECT id, name, no_staff, accs_pwd FROM staff";
$result = db()->query($sql);

$staff = [];
$total = $result->num_rows;
$success = 0;

while ($row = $result->fetch_assoc()){
    $encrypted_password = password_hash($row['accs_pwd'], PASSWORD_BCRYPT);

    $update_password = encryptPasswordUser($row['id'], $encrypted_password);

    if($update_password){
        $success++;
    }
    $staff[$i] = $row;
    $staff[$i]['encrypted'] = $encrypted_password;
    $i++;
}
echo '<b style="color: #04ba00; text-shadow: #565654">SUCCESS: '.$success.' rows</b>';
echo '<br><b style="color: #b30000; text-shadow: #565654">FAILED: '.($total-$success).' rows</b>';
//echo json_encode($staff);
?>
</body>
