<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$month = $_GET['month'];
$year = ($_GET['year']) ?: date('Y');
if(!isset($month)){
    $month=$date_year;
}
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
        select {
            border: hidden;
        }
        @media print {
            #month, #year, #btn-Preview-Image {
                display: none;
            }
        }
        th, td {
            text-align: center;
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
                    <th>NO</th>
                    <th>LOCATION</th>
                    <th>DATE</th>
                    <th>ITEM</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                    <th>TOTAL (RM)</th>
                </tr>
                </thead>
                <tbody>
                <? $i=1;
                $rr = getHkExpensesByMonth($month, $year);
                while($list_rr = $rr->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><? echo $i++; ?></td>
                        <td class="text-left"><? echo $list_rr['location']; ?></td>
                        <td><? echo $list_rr['date_purchase'] ;?></td>
                        <td class="text-left"><? echo $list_rr['item'] ;?></td>
                        <td><? echo $list_rr['unit'] ;?></td>
                        <td><? echo $list_rr['price'] ;?></td>
                        <td><? echo $list_rr['total'] ;?></td>
                    </tr>
                    <? $all += (float)$list_rr['total']; } ?>
                <tr>
                    <th colspan="6"></th>
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
        location.href = "aims_gl_hk_expenses_report.php?month="+month+"&year="+year;
    }
</script>
</body>
</html>