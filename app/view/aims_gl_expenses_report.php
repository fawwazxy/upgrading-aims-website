<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$amount=($_GET['amount']) ?: '0';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
$sys = getSys(1)->fetch_assoc();

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
        th, td {
            text-align: center;
        }
        input,select {
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
    </style>
</head>
<body>

<div id="wrapper">
    <div class="row">
        <div class="col-lg-12">

            <h4 class="text-center"><b>REPORT EXPENSES HOUSEKEEPING GLOBAL LOUNGE</b></h4>
            <h4 class="text-center"><b><? echo $filter; ?></b></h4>

            <form method="get" action="">
                <table class="table table-borderless" style="width: 20%; float: right">
                    <tr>
                        <td>
                            <label for="month" class="hidden">MONTH</label>
                            <select  required class="form-control" name="month" id="month" value="<? echo $month; ?>">
                                <? echo getDropDownMonth($month) ;?>
                            </select>
                        </td>
                        <td>
                            <label for="year" class="hidden">YEAR</label>
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
                    <th rowspan="2" style="vertical-align: middle">NO</th>
                    <th rowspan="2" style="vertical-align: middle">RR NUMBER</th>
                    <th rowspan="2" style="vertical-align: middle">CHECK IN</th>
                    <th rowspan="2" style="vertical-align: middle">ROOM NO</th>
                    <th rowspan="2" style="vertical-align: middle">BED NO</th>
                    <th rowspan="2" style="vertical-align: middle">HK DATE</th>
                    <th rowspan="2" style="vertical-align: middle">HK STATUS</th>
                    <th colspan="3">DOBBY</th>
                    <th colspan="3">BEVERAGE</th>
                    <th colspan="3">TOILETRIES</th>
                </tr>
                <tr>
                    <th style="vertical-align: middle">B-S</th>
                    <th style="vertical-align: middle">BL</th>
                    <th style="vertical-align: middle">TWL</th>
                    <th style="vertical-align: middle">TEA</th>
                    <th style="vertical-align: middle">SUGAR</th>
                    <th style="vertical-align: middle">CREAMER</th>
                    <th>BATCH SOAP</th>
                    <th style="vertical-align: middle">SHAMPOO</th>
                    <th>MINERAL WATER</th>
                </tr>
                </thead>
                <tbody>
                <? $i=1;
                $rr = getExpensesByMonth($month,$year);
                while($list_rr = $rr->fetch_assoc()) {
                    $dobby_total= getTotalDobbyByMonth($month,$year)->fetch_assoc();
                    ?>

                    <tr>
                        <td><? echo $i++;?></td>
                        <td><? echo $list_rr['ref_no']; ?></td>
                        <td><? echo $list_rr['arrival_date'] ;?></td>
                        <td><? echo $list_rr['room_id'] ;?></td>
                        <td><? echo $list_rr['bed_id'] ;?></td>
                        <td><? echo $list_rr['hk_date'] ;?></td>
                        <td><? echo $list_rr['hk_status'] ;?></td>
                        <td><? echo $list_rr['dobby_bs'] ;?></td>
                        <td><? echo $list_rr['dobby_bl'] ;?></td>
                        <td><? echo $list_rr['dobby_twl'] ;?></td>
                        <td><? echo $list_rr['tea'] ;?></td>
                        <td><? echo $list_rr['sugar'] ;?></td>
                        <td><? echo $list_rr['creamer'] ;?></td>
                        <td><? echo $list_rr['soap'] ;?></td>
                        <td><? echo $list_rr['shampoo'] ;?></td>
                        <td><? echo $list_rr['water'] ;?></td>
                    </tr>

                    <? $t += (float)$list_rr['tea'];
                    $s += (float)$list_rr['sugar'];
                    $c += (float)$list_rr['creamer'];
                    $so += (float)$list_rr['soap'];
                    $sh += (float)$list_rr['shampoo'];
                    $w += (float)$list_rr['water'];
                    $d = $dobby_total['amount']; ?>

                <? } ?>

                <tr>
                    <th colspan="7"></th>
                    <th style="text-align:center;" colspan="3"><? echo ($d)? 'RM ' .$d : ""; ?></th>
                    <th style="text-align:center;"><? echo number_format($t ); ?></th>
                    <th style="text-align:center;"><? echo number_format($s ); ?></th>
                    <th style="text-align:center;"><? echo number_format($c ); ?></th>
                    <th style="text-align:center;"><? echo number_format($so ); ?></th>
                    <th style="text-align:center;"><? echo number_format($sh ); ?></th>
                    <th style="text-align:center;"><? echo number_format($w ); ?></th>
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
        $('#dataTables-example').DataTable({
            responsive: true
        });

    });

    $(document).ready(function() {
        $("#month,#year").change(function(){

            var selected_month=$("#month").val();
            var selected_year=$('#year').val();
            reloadMonth(selected_month,selected_year);
        });

    });

    function reloadMonth(month,year){
        location.href = "aims_gl_expenses_report.php?month="+month+"&year="+year;
    }

</script>

</body>
</html>