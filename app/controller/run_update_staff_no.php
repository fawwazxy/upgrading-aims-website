<?php
session_start();
require "../../lib/db/connection.php";
$conn = db();
$staff = $_GET['staff'];
$fx = $_GET['fx'] ?: 'staff';

$success = $failed = 0;

switch ($fx) {
    case 'staff':
        if ($staff == 'all') {
            echo "<b>Executing Staff Number update for all staff...</b>";

            $success = $failed = 0;
            $temp = $conn->query("SELECT * FROM temp_staff");

            while ($temp_staff = $temp->fetch_assoc()) {
                $staff_ic = $temp_staff['staff_ic'];
                $staff_no = $temp_staff['staff_no'];

                $query_run = $conn->query("UPDATE staff SET no_staff = '$staff_no' WHERE noic = '$staff_ic'");

                $query_run ? $success++ : $failed++;
            }
            echo "<br>Success: " . $success;
            echo "<br>Failed: " . $failed;
            echo "<br>Total: " . ($success + $failed);
        }else{
            echo "<b>Executing Staff Number update for staff with IC Number: " . $staff . "</b>";

            $temp_staff = $conn->query("SELECT * FROM temp_staff WHERE staff_ic = '$staff'")->fetch_assoc();

            $staff_ic = $temp_staff['staff_ic'];
            $staff_no = $temp_staff['staff_no'];

            $query_run = $conn->query("UPDATE staff SET no_staff = '$staff_no' WHERE noic = '$staff_ic'") or die($conn->error);

            echo ($query_run) ? "Query successfully executed." : "Failed to execute query.";
        }
        break;

    case 'attendance':
        $temp = $conn->query("SELECT * FROM temp_staff");

        while ($temp_staff = $temp->fetch_assoc()) {
            $staff_ic = $temp_staff['staff_ic'];
            $staff_no = $temp_staff['staff_no'];

            $query_run = $conn->query("UPDATE kehadiran SET no_staff = '$staff_no' WHERE nokp_staff = '$staff_ic'");

            $query_run ? $success++ : $failed++;
        }
        echo "<br>Success: " . $success;
        echo "<br>Failed: " . $failed;
        echo "<br>Total: " . ($success + $failed);
        break;

    case 'workday':
        $temp = $conn->query("SELECT * FROM temp_staff");

        while ($temp_staff = $temp->fetch_assoc()) {
            $staff_ic = $temp_staff['staff_ic'];
            $staff_no = $temp_staff['staff_no'];

            $query_run = $conn->query("UPDATE tarikh_bekerja SET no_staff = '$staff_no' WHERE no_staff = '$staff_ic'");

            $query_run ? $success++ : $failed++;
        }
        echo "<br>Success: " . $success;
        echo "<br>Failed: " . $failed;
        echo "<br>Total: " . ($success + $failed);
        break;

    default:
        echo "default case executed";
        break;
}

echo "<br>-------------------------------<br><br>Script completed successfully.";
echo '<br><br><br><a href="../view/overwrite_staff_no.php" style="font-size: 32px; font-weight: bold">Back</a>';