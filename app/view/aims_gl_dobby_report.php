<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$sys = getSys(1)->fetch_assoc();
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');

$months = [
    '1' => 'JANUARY',
    '2' => 'FEBRUARY',
    '3' => 'MARCH',
    '4' => 'APRIL',
    '5' => 'MAY',
    '6' => 'JUNE',
    '7' => 'JULY',
    '8' => 'AUGUST',
    '9' => 'SEPTEMBER',
    '10' => 'OCTOBER',
    '11' => 'NOVEMBER',
    '12' => 'DECEMBER'
];
$filter = ($months[$month])? $months[$month].' '.$year: $year;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
            color: black;
        }
        select {
            border: hidden;
        }
        @media print {
            #month, #year, #btn-Preview-Image {
                display: none;
            }
        }
        .table.table-borderless, .table.table-borderless th, .table.table-borderless td {
            border: none;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center"><b>REPORT DOBBY EXPENSES GLOBAL LOUNGE</b></h4>
            <h4 class="text-center"><b><? echo $filter; ?></b></h4>

            <form method="GET" action="">
                <table class="table table-borderless" style="width: 20%; float: right">
                    <tr>
                        <td>
                            <label for="month" class="hidden">Month</label>
                            <select  required class="form-control" name="month" id="month" value="<? echo $month; ?>">
                                <? echo getDropDownMonth($month) ;?>
                            </select>
                        </td>
                        <td>
                            <label for="year" class="hidden">Year</label>
                            <select  required class="form-control" name="year" id="year" value="<? echo $year; ?>">
                                <option value="">-- Choose Year --</option>
                                <? echo DropDownYear($year) ;?>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%; vertical-align: middle">NO</th>
                    <th class="text-left" style="vertical-align: middle">DATE</th>
                    <th>AMOUNT (RM)</th>
                </tr>
                </thead>
                <tbody>
                <? $i=1;
                $rr = getDobbyByMonth($month,$year);
                while($list_rr = $rr->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><? echo $i++; ?></td>
                        <td class="text-left"><? echo $list_rr['dobby_date']; ?></td>
                        <td><? echo $list_rr['amount'] ;?></td>
                    </tr>
                    <? $all += (float)$list_rr['amount']; } ?>
                <tr>
                    <th colspan="2"></th>
                    <th><?echo 'RM ' .number_format($all, 2)?></th>
                </tr>
                </tbody>
            </table>
            <div style="text-align:center;">
                <input id="btn-Preview-Image" class="btn btn-primary" type="button" onclick="window.print()" value="Print"/>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#month,#year").change(function(){

            var selected_month=$("#month").val();
            var selected_year=$('#year').val();
            reloadMonth(selected_month,selected_year);
        });

    });
    function reloadMonth(month,year){
        location.href = "aims_gl_dobby_report.php?month="+month+"&year="+year;
    }
</script>
</body>
</html>