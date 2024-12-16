<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_analysis_function.php";

$month = (isset($_GET['month'])) ? $_GET['month'] : date('m');
$year = $_GET['year'] ?: date('Y');
$staff_id = $_GET['id'];
$month_name = convertDigitToMonthName($month);
$staff_info = getStaffInfo($staff_id)->fetch_assoc();
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
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #EEEEEE;
        }
        .tab a {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 16px;
            text-decoration: none;
            color: #000000;
            border-radius: 5%;
        }
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }
        .tab a.active {
            background-color: rgba(150,211,255,0.5);
        }
        .text-muted{
            font-style: italic !important;
        }
        .ot-status{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
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
                    OVERTIME CLAIM <i class="fa fa-caret-right"></i> ANALYSIS REPORT <i class="fa fa-caret-right"></i> <? echo $month_name.' '.$year; ?>
                </h1>
            </div>
        </div>

        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <table class="table table-bordered w-100">
                    <tr>
                        <th>Name:</th>
                        <td><? echo $staff_info['name']; ?></td>
                        <th>Department:</th>
                        <td><? echo $staff_info['department_sub']; ?></td>
                    </tr>
                    <tr>
                        <th>IC Number:</th>
                        <td><? echo $staff_info['noic']; ?></td>
                        <th>Company:</th>
                        <td><? echo $staff_info['department_id']; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover table-bordered" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Rate Mode</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Claim?</th>
                                <th class="text-center">Amount (RM)</th>
                                <th class="text-center">Payment Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $no = 1;
                            $individual_list = getAnalysisReportIndividual($staff_id, $year, $month);
                            while($list = $individual_list->fetch_assoc()){
                                $claim_status = ($list['claim_status'] == 1) ?
                                    '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                                $total_claim = ($list['total_claim'] == '')? '<p class="text-secondary">PENDING</p>':number_format($list['total_claim'],2);
                                $payment_status = ($list['payment_status'] != 'CLOSED')? '<p class="text-secondary">PENDING</p>':'<p class="text-success">CLOSED</p>';
                                ?>
                                <tr>
                                    <td style="width: 6%"><? echo $no++; ?></td>
                                    <td style="width: 8%" class="text-center"><? echo $list['rate_mode']; ?></td>
                                    <td style="width: 8%" class="text-center"><? echo $list['month_session']; ?></td>
                                    <td><? echo $list['description'].'<br> Permission Created: '.$list['permission_created']; ?></td>
                                    <td class="text-center"><? echo $claim_status; ?></td>
                                    <td class="text-center"><? echo $total_claim; ?></td>
                                    <td class="text-center"><? echo $payment_status; ?></td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
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
        $('#dataTables-example').DataTable({
            responsive: true,
        });
    });
</script>
</body>
</html>