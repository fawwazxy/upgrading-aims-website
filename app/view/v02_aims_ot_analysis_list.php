<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_analysis_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$code_department = $_SESSION['SESS_DEPARTMENT'];

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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style type="text/css">
        .card {
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
            height: 110px;
            display: grid;
            border-radius: 0.5rem;
        }
        .content {
            display: grid;
            margin: 1em;
            font-weight: bold;

        }
        .card-chart{
            height: 450px !important;
            display: grid;
            border-radius: 0.5rem;
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
        }
        .card-pie{
            height: 370px !important;
            display: grid;
            border-radius: 0.5rem;
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
        }
        .report-card{
            height: 630px !important;
            display: grid;
            border-radius: 0.5rem;
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
        }
        table {
            border-collapse: collapse;
        }
        td, th {
            padding: 1em;
            border: 1px solid darkgrey !important;
        }
        .form-group {
            display: flex;
            align-items: center;
        }
        .form-group label {
            margin-right: 20px;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    OVERTIME CLAIM <i class="fa fa-caret-right"></i> ANALYSIS <? echo $year; ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="content">
                    <input type="hidden" id="year" name="year" value="<? echo $year;?>">
                    <div class="row">
                        <form id="filterForm" method="GET">
                            <div class="form-group col-md-8">
                                <label for="year">Year: </label>
                                <select class="form-control" name="year" id="year" onchange="filterForm.submit()">
                                    <?php echo getDropDownYear($year); ?>
                                </select>
                            </div>
                        </form>
                        <div class="col-md-4">
                            <a href="v02_aims_ot_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>" class="btn btn-primary" target="_blank">View Detail Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card-chart mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <!--OT Claim Bar Chart-->
                        <figure class="highcharts-figure" >
                            <div id="OTChart" style="height: 420px; width: 100%"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <br>
                <div class="card mt-32" style="background-color: #FFCF9D">
                    <div class="content">
                        <div>Total Permission</div>
                        <h1 class="text-center text" style="font-weight: bold !important;"><? echo totalPermission($year);?></h1>
                    </div>
                </div>
                <br>
                <div class="card mt-32" style="background-color: #ECE3CE">
                    <div class="content">
                        <div>Total Claim</div>
                        <h1 class="text-center text" style="font-weight: bold !important;"><? echo claimAnalysis($year);?></h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>
                    <div class="card mt-32" style="background-color: #EEEEEE">
                        <div class="content">
                            <div>Approved Claim</div>
                            <h1 class="text-center text" style="font-weight: bold !important; color: #3E7C17"><? echo claimAnalysis($year, 'claim_status', 'approved');?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>
                    <div class="card mt-32" style="background-color: #EEEEEE">
                        <div class="content">
                            <div>Rejected Claim</div>
                            <h1 class="text-center text" style="font-weight: bold !important; color: #D80032"><? echo claimAnalysis($year, 'claim_status', 'rejected');?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br>
                <div class="card-pie mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <!--OT Claim Pie Chart-->
                        <figure class="highcharts-figure">
                            <div id="pieChart" style="height: 345px; width: 100%"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br><br>
                <div class="card mt-32" style="background-color: #9EDDFF; height: 150px !important;">
                    <div class="content">
                        <div>Total Amount Claim</div>
                        <h1 class="text-center text" style="font-weight: bold !important;">RM<? echo number_format(totalClaim($year), 2)?></h1>
                    </div>
                </div>
                <br><br>
                <div class="card mt-32" style="background-color: #B0D9B1; height: 150px !important;">
                    <div class="content">
                        <div>Total Payment Closed</div>
                        <h1 class="text-center text" style="font-weight: bold !important;"><? echo totalClosed($year);?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="report-card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Monthly Report <? echo $year?></div><br>
                        <div class="col-lg-12" style="overflow: auto;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Month</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Staff Claim</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Amount (RM)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $total_claim_month = 0;
                                $total_amount_month = 0;
                                $months = array('January', 'February', 'March','April','May','June','July','August','September','October','November','December');

                                for ($i = 0; $i < count($months); $i++) {

                                    $claim_month = getCountByMonth($year, $months[$i]);
                                    $amount_month = getAmountByMonth($year, $months[$i]);
                                    ?>

                                    <tr>
                                        <th class="text-center" style="width: 30%"><? echo $months[$i];?></th>
                                        <th class="text-center" style="width: 30%"><? echo $claim_month; ?></th>
                                        <th class="text-center" style="width: 40%"><? echo number_format($amount_month,2);?></th>
                                    </tr>
                                    <? $total_claim_month += $claim_month;;
                                    $total_amount_month += $amount_month; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo $total_claim_month;?></th>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo number_format($total_amount_month,2);?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="report-card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Yearly Report by Company <? echo $year?></div><br>
                        <div class="col-lg-12" style="overflow: auto;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Company</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Claim</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Amount (RM)</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $company = getCompanyCode();
                                $total_claim_company = 0;
                                $total_amount_company = 0;

                                while($row = $company->fetch_assoc()) {

                                    $claim_company = getCountByCompany($year, $row['code_department']);
                                    $amount_company = getAmountByCompany($year, $row['code_department'])
                                    ?>

                                    <tr>
                                        <th class="text-center" style="width: 30%"><? echo $row['code_department'];?></th>
                                        <th class="text-center" style="width: 30%"><? echo $claim_company; ?></th>
                                        <th class="text-center" style="width: 40%"><? echo number_format($amount_company,2); ?></th>
                                    </tr>
                                    <? $total_claim_company += $claim_company;
                                    $total_amount_company += $amount_company; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo $total_claim_company?></th>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo number_format($total_amount_company,2);?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <br>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<script type="text/javascript">
    let year = $('#year').val();
    $(document).ready(function() {
        $.ajax({
            url: '../controller/v02_aims_ot_analysis_chart_exec.php?year='+year+'&case=graph_line',
            type: "GET",
            dataType: "json",
            success: function (result) {

                Highcharts.chart('OTChart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Graph Line Overtime Claim <? echo $year; ?>'
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
                        name: 'Weekday (RM)',
                        data: result[0].map(a=>Number(a)),
                        color: 'rgba(0,124,255,0.8)',
                    },{
                        name: 'Weekend (RM)',
                        data: result[1].map(b=>Number(b)),
                        color: 'rgba(0,186,8,0.8)',
                    },{
                        name: 'Holiday (RM)',
                        data: result[2].map(c=>Number(c)),
                        color: 'rgba(186,0,0,0.8)',
                    },{
                        name: 'Special (RM)',
                        data: result[3].map(d=>Number(d)),
                        color: 'rgba(234,208,0,0.65)',
                    },]
                });
            }
        });
    });
    $(document).ready(function() {
        $.ajax({
            url: '../controller/v02_aims_ot_analysis_chart_exec.php?year='+year+'&case=pie_chart',
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);

                Highcharts.chart('pieChart', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Amount of Overtime Claim by Company <? echo $year; ?>'
                    },
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: [{
                                enabled: true,
                                distance: 20
                            }, {
                                enabled: true,
                                distance: -40,
                                format: '{point.y:.2f}',
                                style: {
                                    fontSize: '1.2em',
                                    textOutline: 'none',
                                    opacity: 0.7
                                },
                                /*filter: {
                                    operator: '>',
                                    property: 'percentage',
                                    value: 10
                                }*/
                            }]
                        }
                    },
                    series: [
                        {
                            name: 'RM',
                            colorByPoint: true,
                            data: [
                                {
                                    name: data[0]['label'],
                                    y: parseFloat(data[0]['data'])
                                },
                                {
                                    name: data[1]['label'],
                                    y: parseFloat(data[1]['data'])
                                    /*sliced: true,
                                    selected: true,*/
                                },
                                {
                                    name: data[2]['label'],
                                    y: parseFloat(data[2]['data'])
                                },
                                {
                                    name: data[3]['label'],
                                    y: parseFloat(data[3]['data'])
                                },
                                {
                                    name: data[4]['label'],
                                    y: parseFloat(data[4]['data'])
                                },
                                {
                                    name: data[5]['label'],
                                    y: parseFloat(data[5]['data'])
                                },
                                {
                                    name: data[6]['label'],
                                    y: parseFloat(data[6]['data'])
                                },
                                {
                                    name: data[7]['label'],
                                    y: parseFloat(data[7]['data'])
                                },
                                {
                                    name: data[8]['label'],
                                    y: parseFloat(data[8]['data'])
                                },
                                {
                                    name: data[9]['label'],
                                    y: parseFloat(data[9]['data'])
                                },
                                {
                                    name: data[10]['label'],
                                    y: parseFloat(data[10]['data'])
                                },
                                {
                                    name: data[11]['label'],
                                    y: parseFloat(data[11]['data'])
                                },
                                {
                                    name: data[12]['label'],
                                    y: parseFloat(data[12]['data'])
                                }
                            ]
                        }
                    ]
                });



            }
        });
    });
</script>
</body>
</html>