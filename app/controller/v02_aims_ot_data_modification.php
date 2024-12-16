<?php
require "../../lib/db/connection.php";
$fx = $_GET['fx'];
$toExecute = $_GET['toExecute'] == 'yes';
$conn=db();
$success = 0;
$failed = 0;
$data = [];

switch ($fx){

    case 'otp_applicant_id':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot_permission otp LEFT JOIN staff s ON s.no_staff = otp.applicant_id
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot_permission SET applicant_id = '$id' WHERE applicant_id = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'otp_approval_id':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot_permission otp LEFT JOIN staff s ON s.no_staff = otp.approval_id
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot_permission SET approval_id = '$id' WHERE approval_id = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'otm_staff_id':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot_month_session otm LEFT JOIN staff s ON s.no_staff = otm.staff_id
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot_month_session SET staff_id = '$id' WHERE staff_id = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'ot_verify_by':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot ot LEFT JOIN staff s ON s.no_staff = ot.verify_by
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot SET verify_by = '$id' WHERE verify_by = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'ot_review_by':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot ot LEFT JOIN staff s ON s.no_staff = ot.review_by
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot SET review_by = '$id' WHERE review_by = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'ot_approved_by':
        $sql = "SELECT s.id, s.no_staff, s.name FROM v02_aims_ot ot LEFT JOIN staff s ON s.no_staff = ot.approved_by
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE v02_aims_ot SET approved_by = '$id' WHERE approved_by = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    case 'push_token_staff_id':
        $sql = "SELECT s.id, s.no_staff, s.name FROM push_notification_token p LEFT JOIN staff s ON s.no_staff = p.staff_id
                WHERE s.no_staff IS NOT NULL GROUP BY s.no_staff ORDER BY s.no_staff";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $no_staff = $row['no_staff'];
            $name = $row['name'];
            $sub_query = "UPDATE push_notification_token SET staff_id = '$id' WHERE staff_id = '$no_staff'";

            if ($toExecute){
                $executeSuccess = $conn->query($sub_query);

                $executeSuccess ? $success++ : $failed++;
                $status = $executeSuccess ? 'success' : 'x';
            }else{
                $status = 'success';
                $success++;
            }

            $data[] = ['id' => $id, 'no_staff' => $no_staff, 'name' => $name, 'status' => $status];
        }
        break;

    default:
        echo 'We could not detect fx parameter (Method GET). Executing default case function...<br><br>Done';
        break;
} ?>

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
        #users {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 90%;
            margin-left: 5%;
            margin-right: 5%;
        }

        #users td, #users th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #users tr:nth-child(even){background-color: #f2f2f2;}

        #users tr:hover {background-color: #ddd;}

        #users th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04aa33;
            color: white;
        }
    </style>
</head>
<body>
<div style="margin-left: 8%">
    <h1><? echo $fx.($toExecute ? '' : ' (Display Only)'); ?></h1>
    <h3><? echo $result->num_rows.' rows found.' ?></h3>
    <h4>
        <? echo 'Success: '.$success ?><br>
        <? echo 'Failed: '.$failed ?>
    </h4>
</div>


<table id="users">
    <tr>
        <th>#</th>
        <th>Success?</th>
        <th>Staff ID</th>
        <th>Staff IC</th>
        <th>Staff Name</th>
    </tr>
    <? foreach ($data as $index => $value){ ?>
        <tr>
            <td><? echo $index ?></td>
            <td style="font-weight: bold; color: <? echo ($value['status'] == 'x') ? 'red' : 'green' ?>">
                <? echo $value['status'] ?></td>
            <td><? echo $value['id'] ?></td>
            <td><? echo $value['no_staff'] ?></td>
            <td><? echo $value['name'] ?></td>
        </tr>
    <? } ?>
</table>
</body>
</html>