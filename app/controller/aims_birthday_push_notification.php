<?php
require "../../lib/db/connection.php";
$date = date("-m-d");
echo $date;

$sql = "SELECT staff.name,staff.department_sub,push_notification_token.token 
        FROM staff 
        INNER JOIN push_notification_token ON staff.no_staff = push_notification_token.no_staff
        WHERE umur LIKE '%$date%'";

$staffs_with_birthday_today = db()->query($sql);

while ($staff_with_birthday_today = $staffs_with_birthday_today->fetch_assoc()){
    if($staffs_with_birthday_today['token']!='')
        sendFCM(
            $staff_with_birthday_today['token'],
            'Selamat menyambut ulang tahun kelahiran',
            'Ikhlas daripada warga AIMS-GLOBAL HOLDINGS SDN. BHD.'
        );
}
