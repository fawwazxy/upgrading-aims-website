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
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "../../lib/db/connection.php";

function generateCompanyId($code){
    $conn=db();
    $sql = "SELECT id FROM department WHERE code_department = '$code'";
    $result = $conn->query($sql)->fetch_object()->id;

    if ($result != ''){
        return $result;
    }
    return '1';
}

function generateApprovalId($no_staff){
    $conn=db();
    $sql = "SELECT id FROM staff WHERE no_staff = '$no_staff'";
    $result = $conn->query($sql)->fetch_object()->id;

    if ($result != ''){
        return $result;
    }
    return '1';
}

$sql = "SELECT * FROM staff";
$user_list = db()->query($sql);
$i=1;
$success=0;

echo $user_list->num_rows.' rows found.<br><br>';

while ($user = $user_list->fetch_assoc()){
    $id = $user['id']; $name = $user['name']; $no_staff = $user['no_staff']; $no_ic = $user['noic'];
    $username = $user['username']; $password = $user['accs_pwd'];
    $phone = $user['phone']; $email = $user['email'];
    $role = $user['role_id']; $company_id = generateCompanyId($user['department_id']);
    $department = $user['department_sub']; $status = ($user['status'] == 'BEKERJA') ? '1' : '0';
    $gender = ($user['gender'] == 'PREMPUAN') ? '0' : '1'; $approval_id = generateApprovalId($user['leave_approval']);

    $sql = "INSERT INTO `aimsglob_corp`.`users`(`id`, `name`, `no_staff`,  `no_ic`,`username`, `password`, `phone_no`, `email`, `role`,
                `company_id`, `department`, `status`,  `gender`, `approval_id`, `access_status`, `pic_status`,
                `created_at`, `updated_at`)
                VALUES ($id, '$name', '$no_staff', '$no_ic', '$username', '$password', '$phone', '$email', '$role', '$company_id',
                '$department', '$status', '$gender', '$approval_id', 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

    $result = db()->query($sql);

    if ($result){
        echo '<b style="color: #04ba00; text-shadow: #565654">'.$i.'. SUCCESS</b>';
        $success++;
    }else{
        echo db()->error.'<br>';
        echo '<b style="color: #b30000; text-shadow: #565654">'.$i.'. FAILED</b>';
    }
    echo '<br><b>Staff ID:</b> '.$id;
    echo '&nbsp;&nbsp;&nbsp;<b>Staff No.:</b> '.$no_staff;
    echo '&nbsp;&nbsp;&nbsp;<b>Staff IC:</b> '.$no_ic;
    echo '<br><b>Name:</b> '.$name;
    echo '<br><b>Username:</b> '.$username;
    echo '<br><b>Password:</b> '.$password;
    echo '<br><b>Phone:</b> '.$phone;
    echo '&nbsp;&nbsp;&nbsp;<b>Email:</b> '.$email;
    echo '<br><b>Company ID:</b> '.$company_id;
    echo '&nbsp;&nbsp;&nbsp;<b>Email:</b> '.$email;
    echo '<br>------------------------------------------------------------------------------------------------<br>';
    $i++;
}
/*echo "
[
        'id' => '$id',
        'name' => '$name',
        'no_staff' => '$no_staff',
        'no_ic' => '$no_ic',
        'username' => 'superadmin',
        'password' => Hash::make('superadmin'),
        'phone_no' => '01133327475',
        'email' => 'support@aimsglobal.com.my',
        'role' => 'SUPERADMIN',
        'company_id' => '1',
        'department' => 'SYSTEM',
        'status' => '1',
        'gender' => '1',
        'created_at' => $current_date_time,
        'updated_at' => $current_date_time,
    ]
";*/

echo '<b style="color: #04ba00; text-shadow: #565654">SUCCESS: '.$success.' rows</b>';
echo '<br><b style="color: #b30000; text-shadow: #565654">FAILED: '.($i-1-$success).' rows</b>';
?>
</body>
