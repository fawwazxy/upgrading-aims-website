<?php
include "../controller/auth.php";
require "../model/v02_aims_medical_analysis_function.php";
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

    <style type="text/css">
        .card {
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
            height: 120px;
            display: grid;
            border-radius: 0.5rem;
        }
        .content {
            display: grid;
            margin: 1em;
            font-weight: bold;

        }
        .card-graph{
            height: 540px !important;
            display: grid;
            border-radius: 0.5rem;
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
        }
        .report-card{
            height: 650px !important;
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
                    MEDICAL CLAIM <i class="fa fa-caret-right"></i> ANALYSIS <? echo $year; ?>
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
                            <a href="v02_aims_medical_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>" class="btn btn-primary" target="_blank"="modal">View Detail Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Total Request</div>
                        <h1 class="text-center text" style="font-weight: bold !important; color: #4F709C"><? echo medicalAnalysis($year);?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Approved</div>
                        <h1 class="text-center text" style="font-weight: bold !important; color: #3E7C17">
                            <? echo medicalAnalysis($year, 'hr_verify_status', 'approved');?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Rejected</div>
                        <h1 class="text-center text" style="font-weight: bold !important; color: #D80032">
                            <? echo medicalAnalysis($year, 'hr_verify_status', 'rejected');?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <div>Pending</div>
                        <h1 class="text-center text" style="font-weight: bold !important; color: #E9B824">
                            <? echo medicalAnalysis($year, 'hr_verify_status', 'pending');?></h1>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card-graph mt-32" style="background-color: #EEEEEE">
                    <div class="content">
                        <!--Medical Claim Bar Chart-->
                        <figure class="highcharts-figure" >
                            <div id="MedicalChart" style=" height: 515px;"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-32" style="background-color: #9EDDFF">
                    <div class="content">
                        <div>Total Entitle <? echo $year; ?></div>
                        <h1 class="text-center text" style="font-weight: bold !important;">RM<? echo number_format(totalEntitle($year),2);?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br>
                <div class="card mt-32" style="background-color: #FFCF9D">
                    <div class="content">
                        <div>Total Claim Approved <? echo $year; ?></div>
                        <h1 class="text-center text" style="font-weight: bold !important;">RM<? echo number_format(totalUsed($year),2);?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br>
                <div class="card mt-32" style="background-color: #B0D9B1">
                    <div class="content">
                        <div>Total Available <? echo $year; ?></div>
                        <?
                            $entitle = totalEntitle($year);
                            $used = totalUsed($year);

                            $available = $entitle - $used;
                        ?>
                        <h1 class="text-center text" style="font-weight: bold !important;">RM<? echo number_format($available,2);?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <br>
                <div class="card mt-32" style="background-color: #EBE4D1">
                    <div class="content">
                        <div>Total Payment Released</div>
                        <h1 class="text-center text" style="font-weight: bold !important;">
                            <? echo paymentClosed($year, 'payment_closed_at', 'released');?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <br>
                <div class="card mt-32" style="background-color: #EBE4D1">
                    <div class="content">
                        <div>Total Payment Unreleased</div>
                        <h1 class="text-center text" style="font-weight: bold !important;">
                            <? echo paymentClosed($year, 'payment_closed_at', 'unreleased');?></h1>
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
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Request</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Claim (RM)</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                    $total_request_month = 0;
                                    $total_claim_month = 0;
                                    $months = array('January', 'February', 'March','April','May','June','July','August','September','October','November','December');

                                    for ($i = 0; $i < count($months); $i++) {

                                        $request_month = getCountByMonth($year, $months[$i]);
                                        $claim_month = getAmountByMonth($year, $months[$i]);
                                ?>

                                    <tr>
                                        <th class="text-center" style="width: 30%"><? echo $months[$i];?></th>
                                        <th class="text-center" style="width: 30%"><? echo $request_month; ?></th>
                                        <th class="text-center" style="width: 40%"><? echo number_format($claim_month,2);?></th>
                                    </tr>
                                <? $total_request_month += $request_month;;
                                   $total_claim_month += $claim_month; } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <th class="text-center" style="background-color: #B7B7B7"><? echo $total_request_month;?></th>
                                        <th class="text-center" style="background-color: #B7B7B7"><? echo number_format($total_claim_month,2);?></th>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label>Yearly Report by Company <? echo $year?></label>
                            </div>
                        </div>
                        <br>
                        <div class="col-lg-12" style="overflow: auto;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Company</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Request</th>
                                    <th class="text-center" style="background-color: rgba(150,211,255,0.5)">Total Claim (RM)</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $company = getCompanyCode();
                                $total_request_company = 0;
                                $total_claim_company = 0;

                                while($row = $company->fetch_assoc()) {

                                    $request_company = getCountByCompany($year, $row['code_department']);
                                    $claim_company = getAmountByCompany($year, $row['code_department'])
                                ?>

                                    <tr>
                                        <th class="text-center" style="width: 30%"><? echo $row['code_department'];?></th>
                                        <th class="text-center" style="width: 30%"><? echo $request_company; ?></th>
                                        <th class="text-center" style="width: 40%"><? echo number_format($claim_company,2); ?></th>
                                    </tr>
                                <? $total_request_company += $request_company;
                                   $total_claim_company += $claim_company; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo $total_request_company?></th>
                                    <th class="text-center" style="background-color: #B7B7B7"><? echo number_format($total_claim_company,2);?></th>
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
    $(document).ready(function() {
        let year = $('#year').val();
        $.ajax({
            url: '../controller/v02_aims_medical_analysis_chart_exec.php?year='+year,
            type: "GET",
            dataType: "json",
            success: function (result) {
                console.log(result)

                Highcharts.chart('MedicalChart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Graph Line Medical Claim <? echo $year; ?>'
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
                        name: 'Amount Request (RM)',
                        data: result[0].map(a=>Number(a)),
                        color: 'rgba(0,124,255,0.8)',
                    },{
                        name: 'Total Payment Released',
                        data: result[1].map(b=>Number(b)),
                        color: 'rgba(0,186,8,0.8)',
                    }]
                });
            }
        });
    });
</script>
</body>
</html>