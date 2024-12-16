<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$month=($_GET['bdaymonth']) ?: '';
$status=($_GET['status']) ?: 'daily';
$app_status=($_GET['app_status']) ?: 'APPROVE';
$plate_no=($_GET['plate_no']) ?: 'XX 8848';

$sys = getSys(1)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print: Transport Request</title>
    <style>
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 5px;
        }

        th{
            color: #ffffff;
            background: #484848;
        }

        body{
            padding:10px;
            font-family: Arial, serif;
        }

        .table-footer{
            text-align: center;
            background-color: #777;
            color: #ffffff;
            font-weight: bold;
        }

        button{
            padding: 4px 8px;
        }

        @media print {
            button {display: none;}
        }
    </style>
</head>
<body>
<div class="row">

</div>
<img id="logo" src="../../resources/images/aims-logo.PNG" style="width:440px;height:90px;margin-left:15px;" alt="logo"/>
<button style="float: right" onclick="window.print()" aria-hidden="true">Print this page</button>
<hr>

<div class="row">
    <input type="hidden" id ="date" value ="<? echo $month?>"/>
    <h3 class="page-header" style="text-align: center">REPORT MONTHLY :  <? echo strtoupper(date('F Y', strtotime($month))) ?></h3>
</div>
<br><br>
<table style="width: 100%" id="dataTables-example">
    <thead>
    <tr>
        <th>No.</th>
        <th>Date</th>
        <th>Applicant Name</th>
        <th>Purpose</th>
        <th>Destination</th>
        <th>Status Application</th>
        <th>Reason Not to approve</th>
        <th>Action</th>
        <th>Plate Number</th>
        <th>Departure Milage</th>
        <th>Return Milage</th>
        <th>Amount Mileage</th>
        <th>Duration</th>
        <th>Inspection</th>
        <th>Status of summon</th>
        <th>Health Status & illness</th>

    </tr>
    </thead>
    <tbody>
    <?
    $car = getcarRequestList3($app_status,$month,$_SESSION['SESS_NAME'],$status,$plate_no);
    $i=1;
    $total=0;
    while($list_car = $car->fetch_assoc()) {
        $amount = abs(($list_car['return_milage'] - $list_car['dep_milage']) * 0.9);
        ?>

        <tr>
            <td><? echo $i++;?></td>
            <td style="text-align:center"><? echo $list_car['dep_date']; ?></td>
            <td style="text-align:center"><? echo $list_car['name']; ?></td>
            <td style="text-align:center"><? echo $list_car['purpose']; ?></td>
            <td style="text-align:center"><? echo $list_car['destination']; ?></td>
            <td style="text-align:center"><? echo $list_car['app_status']; ?></td>
            <td style="text-align:center"><? echo $list_car['reason']; ?></td>
            <td style="text-align:center"> - </td>
            <td style="text-align:center"><? echo $list_car['car_plate_no']; ?></td>
            <td style="text-align:center"><? echo $list_car['dep_milage']; ?></td>
            <td style="text-align:center"><? echo $list_car['return_milage']; ?></td>
            <td style="text-align:center"><? echo 'RM '.number_format($amount, 2)?></td>
            <td style="text-align:center"><? echo $list_car['dep_date'].' - '.$list_car['return_date']; ?></td>
            <td style="text-align:center"><? echo $list_car['status_incep']; ?></td>
            <td style="text-align:center"><? echo ($list_car['summon_status']) ?: '-'; ?></td>
            <td style="text-align:center">
                <?
                echo strtoupper(str_replace('_', ' ', $list_car['health_status']));
                echo '<p>'.$list_car['illness'].'</p>'; ?>
            </td>
        </tr>
        <? $total += (float)$amount;
    }?>
    <tr>
        <td class="table-footer" colspan="12" style="text-align: right">
            <?echo 'RM '.number_format($total, 2)?>
        </td>
        <td class="table-footer" colspan="4"></td>
    </tr>
    </tbody>
</table>
</body>
</html>