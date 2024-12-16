<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
$year = ($_GET['year'])?: date('Y');
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
    <script src="../../js/highcharts/highcharts.js"></script>
    <script src="../../js/highcharts/modules/exporting.js"></script>
    <script src="../../js/highcharts/modules/export-data.js"></script>
    <script src="../../js/highcharts/modules/data.js"></script>
    <script src="../../js/jquery.highchartTable.js"></script>
    <style type="text/css">
        h2,h4 {
            text-align: center;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <input type="hidden" id="year" name="year" value="<? echo $year; ?>">
        <div class="row">
            <div class="col-md-10">
                <h1 class="page-header">
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> ANALYSIS <? echo $year; ?>
                </h1>
            </div>
            <div class="col-md-1">
                <a class="btn btn-primary page-header" href="v02_aims_others_claim_analysis_report.php" target="_blank">View Report</a>
            </div>
            <div class="col-md-1">
                <form id="filterForm" method="GET" class="page-header">
                    <select class="form-control" name="year" id="year" onchange="filterForm.submit()">
                        <? echo getDropDownYear($year);?>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">

                <?
                $total_claim = number_format(getTotalAmount($year,'request'),2);
                $total_closed = number_format(getTotalAmount($year,'paid'),2);
                $total_outstanding = getTotalAmount($year,'request') - getTotalAmount($year,'paid');
                ?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4 class="text-left">TOTAL CLAIM</h4>
                        <h2 class="text-primary"><? echo 'RM'.$total_claim; ?></h2>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4 class="text-left">TOTAL CLOSED</h4>
                        <h2 class="text-success"><? echo 'RM'.$total_closed; ?></h2>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4 class="text-left">TOTAL OUTSTANDING</h4>
                        <h2 class="text-danger"><? echo 'RM'.number_format($total_outstanding,2); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <figure class="highcharts-figure" >
                    <div id="claimChart"></div>
                </figure>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>MONTHLY CLAIM REQUEST <? echo $year; ?></h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-info">
                                <th class="text-center">Month</th>
                                <th class="text-center">Total Claim</th>
                                <th class="text-center">Total Amount (RM)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $bgcolor = '';
                            $total_monthly_amount = 0;
                            $total_monthly_request = 0;
                            $months = array("JANUARY", "FEBRUARY", "MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER");
                            for ($i = 0; $i < count($months); $i++) {
                                $bgcolor = ($months[$i] == strtoupper(date('F')))?'#A1E2FD':'';
                                $monthly_amount = getCountByMonth($year, $months[$i], 'amount');
                                $monthly_request = getCountByMonth($year, $months[$i], 'request');
                                ?>
                                <tr>
                                    <th style="width: 20%; background-color: <? echo $bgcolor; ?>" class="text-center"><? echo $months[$i]; ?></th>
                                    <td style="width: 30%;" class="text-center"><? echo $monthly_request; ?></td>
                                    <td style="width: 30%;" class="text-center"><? echo number_format($monthly_amount,2); ?></td>
                                </tr>
                                <? $total_monthly_amount += $monthly_amount; $total_monthly_request += $monthly_request; } ?>
                            </tbody>
                            <tfoot class="bg-info">
                            <tr>
                                <td></td>
                                <th class="text-center"><? echo $total_monthly_request; ?></th>
                                <th class="text-center"><? echo number_format($total_monthly_amount,2); ?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>COMPANY YEARLY CLAIM <? echo $year; ?></h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr class="bg-info">
                                <th class="text-center">Company Claim</th>
                                <th class="text-center">Total Claim</th>
                                <th class="text-center">Total Amount (RM)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $company_list = getCompany();
                            $total_yearly_claim = 0;
                            $total_yearly_amount = 0;
                            while($row = $company_list->fetch_assoc()) {
                                $yearly_claim = getTotalCompanyClaim($row['id'], $year);
                                $yearly_amount = getAmountCompanyClaim($row['id'], $year);
                                ?>
                                <tr>
                                    <th class="text-center" style="width: 20%"><? echo $row['code_department']; ?></th>
                                    <td class="text-center" style="width: 30%;"><? echo $yearly_claim; ?></td>
                                    <td class="text-center" style="width: 30%;"><? echo number_format($yearly_amount,2); ?></td>
                                </tr>
                                <? $total_yearly_claim += $yearly_claim; $total_yearly_amount += $yearly_amount; } ?>
                            </tbody>
                            <tfoot class="bg-info">
                            <tr>
                                <td></td>
                                <th class="text-center"><? echo $total_yearly_claim; ?></th>
                                <th class="text-center"><? echo number_format($total_yearly_amount,2); ?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <? include "../global/footer.php"; ?>

    </div>
</div>
<script type="text/javascript">
    var year = $('#year').val();
    $(document).ready(function() {
        $.ajax({
            url: '../controller/v02_aims_others_claim_analysis_exec.php?year='+year,
            type: "GET",
            dataType: "json",
            success: function (result) {
                console.log(result)

                Highcharts.chart('claimChart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Monthly Graph Amount'
                    },
                    xAxis: {
                        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August' ,'September', 'October', 'November', 'December'],
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Amount'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:black;padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        },
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.2f}'
                            }
                        }
                    },
                    series: [{
                        name: 'Total Claim',
                        data: result[0].map(a=>Number(a)),
                        color: 'rgba(0,124,255,0.8)',
                    }, {
                        name: 'Total Closed',
                        data: result[1].map(b=>Number(b)),
                        color: 'rgba(0,255,34,0.8)',
                    }]
                });
            }
        });
    });
</script>
</body>
</html>