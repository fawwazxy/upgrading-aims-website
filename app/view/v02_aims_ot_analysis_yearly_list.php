<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_analysis_function.php";

$month = (isset($_GET['month'])) ? ($_GET['month']) : date('m');
$year = $_GET['year'] ?: date('Y');
$code = ($_GET['code']) ?: 'SB';
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
                    OVERTIME CLAIM <i class="fa fa-caret-right"></i> ANALYSIS REPORT <? echo $year; ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <form method="get" action="">
                <input type="hidden" value="<? echo $code?>" name="code">
                <div class="col-md-2">
                    <select class="form-control" id="year" name="year" required>
                        <?echo getDropDownYear($year) ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="month" name="month" required>
                        <?echo getDropDownMonth($month) ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" id="filterBtn">Search</button>
                </div>
            </form>
        </div>
        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <div class="panel-heading text-center">
                        <label>OVERTIME CLAIM LIST</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="tab">
                    <a class="tabLinks <? if($code == "SB") echo 'active'?>" href="v02_aims_ot_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>&code=SB">ALL</a>
                    <? $company = getCompanyCode();
                    while($row = $company->fetch_assoc()) { ?>
                        <a class="tabLinks <? if($row['code_department'] == $code) echo 'active'?>"
                           href="v02_aims_ot_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>&code=<? echo $row['code_department']; ?>">
                            <? echo $row['code_department']?>
                        </a>
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover table-bordered" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 6%">No.</th>
                                <th class="text-center">Staff Info</th>
                                <th style="width: 19%" class="text-center">Month</th>
                                <th style="width: 15%" class="text-center">Amount (RM)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $no = 1;
                            $report_list = getAnalysisReport($year,$month,$code);
                            while($list = $report_list->fetch_assoc()){
                                $count_total = v02countTotalOTFromMonthSessionID($list['staff_id'],$year,$month)->fetch_object()->total_count;
                                $total_claim = v02countTotalOTFromMonthSessionID($list['staff_id'],$year,$month)->fetch_object()->total_claim;
                                ?>
                                <tr>
                                    <td class="text-center"><? echo $no++; ?></td>
                                    <td>
                                        <p><b><? echo $list['name'];?></b></p>
                                        <small><? echo $list['department_id']?></small>
                                        <small>(<? echo $list['department_sub']?>)</small>
                                    </td>
                                    <td class="text-center"><? echo '<b>'.$list['month_session'].'</b>'; ?>
                                        <p class="ot-status" style="background-color: #000000; margin-top: 16px">OT Count: <? echo $count_total?></p></td>
                                    <td class="text-center"><b><? echo $total_claim?></b></td>
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