<?php
session_start();
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$month_session_id = $_GET['id'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$back_href = ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR')? 'v02_aims_ot_hr_list.php':'v02_aims_ot_hr_sea_list.php';
$page_name = ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR')? 'HR':'HR-SEA';

if (!in_array($department_sub,['HR','HR-SEA'])) {
    echo "<script>
            alert('This section can only be accessed by person in charge for OVERTIME FORM verification/approval')
            window.history.back();
            </script>";
    exit();
}

if (empty($month_session_id)) {
    echo "<script>alert('HR Form cannot be load. Make sure you are requesting valid month_session');
            window.history.back();
            </script>";
}

$contractor_array = v02getContractorList();
$month_details = v02getMonthSessionDetails($month_session_id)->fetch_assoc();

$ot_day_closed = 15;
if ($month_details['department_sub'] == 'MOORING-GANG' || ($month_details['department_sub'] == 'TECHOPERATION' && $month_details['department_id'] == 'AGSHIMSB')){
    $ot_day_closed = 20;
}else if (in_array($month_details['staff_id'], $contractor_array)){
    $ot_day_closed = 31;
}

$ot_by_month = v02getOtApproval($month_details['id']);
$pending_count = 0;
$approve_count = 0;
$disapprove_count = 0;
while ($row = $ot_by_month->fetch_assoc()){
    if (empty($row['approved_by']) && empty($row['approved_at'])){
        $pending_count++;
    }else{
        if ($row['approved_status'] == '1'){
            $approve_count++;
        }else{
            $disapprove_count++;
        }
    }
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>

    <style>
        .conversion-table tr{
            height: 48px;
        }
        .horizontal-scroll {
            overflow: hidden;
            overflow-x: auto;
            clear: both;
            width: 100%;
        }
        #table-hr tr td:last-child {
            white-space: nowrap;
        }
        .font-weight-bold{
            font-weight: bold;
        }
        .ot-status{
            padding: 3px 8px;
            border-radius: 5px;
            font-weight:bold;
            color: #FFFFFF;
        }

        .table-info tr{
            height: 24px;
        }
        .table-info th{
            padding-right: 8px;
        }
        .warning-tooltip{
            color: #4f4f4f;
            background-color: #ffc000;
            font-size: 75%;
            font-weight: bold;
            border-radius: 4px;
            padding: 4px;
            position: relative;
            display: inline-block;
        }

        /* Tooltip text */
        .warning-tooltip .warning-tooltiptext {
            border: 1px solid black;
            visibility: hidden;
            width: 512px;
            /*background-color: #FFFFFF;*/
            /*color: #e50000;*/
            background-color: #000000;
            color: #FFFFFF;
            text-align: left;
            padding: 8px 16px;
            border-radius: 6px;

            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 1;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .warning-tooltip:hover .warning-tooltiptext {
            visibility: visible;
        }
        .date-summary{
            float: right;
            margin-right: 8px;
            padding-left: 8px;
            padding-right: 8px;
        }
        .text-white{
            color: #ffffff;
        }
        .text-dark{
            color: #000000;
        }
        .bg-purple{
            background-color: #4E61FF;
        }
        .btn-secondary{
            background-color: #d7d7d7;
        }
        .bg-dark{
            background-color: #000000;
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CLAIM <i class="fa fa-caret-right"></i>
                    <? echo $page_name; ?> REVIEW <i class="fa fa-caret-right"></i> FORM
                    <? if ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
                    <a href="aims_ot_hr_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <? } ?>

                    <a href="<? echo $back_href; ?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-sm-8">
                <table class="table-info" style="width: 100%">
                    <tr>
                        <th>Staff Name</th>
                        <td> : </td>
                        <td><? echo $month_details['name'];?></td>
                        <th>Department</th>
                        <td>: </td>
                        <td><? echo $month_details['department_sub'];?></td>
                    </tr>
                    <tr>
                        <th>I/C No</th>
                        <td>: </td>
                        <td><? echo $month_details['noic'];?></td>
                        <th>Company</th>
                        <td>: </td>
                        <td><? echo $month_details['department_id'];?></td>
                    </tr>
                    <tr>
                        <th>Staff No.</th>
                        <td>: </td>
                        <td><? echo $month_details['no_staff'];?></td>
                        <th>Month Claim</th>
                        <td> : </td>
                        <td><? echo strtoupper($month_details['month_session']);?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-4 text-right">
                <a href="v02_aims_ot_print.php?id=<? echo $month_session_id;?>" target="_blank" class="btn btn-success">
                    Print <i class="fa fa-print"></i></a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="font-weight-bold">OVERTIME CLAIM LIST</span>
                        <span class="warning-tooltip" style="margin-left: 8px">
                            Warning <i class="fa fa-exclamation-circle"></i>
                            <span class="warning-tooltiptext">
                                ~ If there any changes of month claim, please update month claim before making rates calculation and reviewing. <br>
                                ~ However, you can reset the summary table if month claim changed after reviewed
                                <br>&nbsp; (ot status will be reverted to pending)
                            </span>
                    </span>
                    </div>
                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 10%">Date/Day</th>
                                    <th style="width: 7%">Rate</th>
                                    <th style="width: 10%">Start/End</th>
                                    <th style="width: 10%">Hours</th>
                                    <th style="width: 10%">Month</th>
                                    <th style="width: 22%">Description</th>
                                    <th style="width: 13%">Remark</th>
                                    <th style="width: 8%">HR</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i= 1;
                                $sum_hours = 0;
                                $list_ot_by_month_id = v02allOtByMonthSession($month_session_id);
                                while($row = $list_ot_by_month_id->fetch_assoc()) {
                                    //sum total hours
                                    $sum_hours += $row['total_hours'];
                                    //convert hours to hours and minutes
                                    $hours = floor($row['total_hours']);
                                    $minutes = ($row['total_hours'] - $hours) * 60;
                                    $minutes = number_format($minutes);

                                    //check hr status
                                    if (!empty($row['review_by']) && $row['review_status'] == '1'){ //reviewed
                                        $status_icon = '<i class="fa fa-check-circle text-success"></i>';
                                    }else if (!empty($row['review_by']) && $row['review_status'] != '1'){ //rejected
                                        $status_icon = '<i class="fa fa-times-circle text-danger"></i>';
                                    }else{ //pending
                                        $status_icon = '<i class="fa fa-exclamation-circle" style="color: grey"></i>';
                                    }
                                    ?>
                                    <tr class="odd gradeX text-center">

                                        <td>
                                            <p><?php echo $row['date']; ?></p>
                                            <p class="ot-status text-uppercase" style="background-color: #000000">
                                                <?php echo date('l', strtotime($row['date'])); ?>
                                            </p>
                                        </td>
                                        <td class="text-center"><?php echo $row['rate_mode']?></td>
                                        <td>
                                            <p class="ot-status text-dark bg-success">Start:<br> <?php echo date('h:i a', strtotime($row['start_ot'])); ?></p>
                                            <p class="ot-status text-dark bg-danger">End:<br> <?php echo date('h:i a', strtotime($row['end_ot'])); ?></p>
                                        </td>
                                        <td>
                                            <p><? echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?></p>
                                            <b class="ot-status bg-purple">
                                                <? echo number_format($row['total_hours'], 2).' h' ?>
                                            </b>
                                        </td>
                                        <td class="text-uppercase"><?php echo $row['month_session']; ?></td>
                                        <td class="text-left"><?php echo nl2br($row['description']); ?></td>
                                        <td class="text-left"><?php echo $row['verification_remark']; ?></td>
                                        <td class="text-center"><?php echo $status_icon; ?></td>
                                        <td>
                                            <? //if ($approve_count < 1 && $disapprove_count < 1){ ?>
                                            <a class="btn btn-primary"  href="#updateModal" style="margin: 4px 0"
                                               data-toggle="modal" data-id="<? echo $row['id'];?>" title="Edit">
                                                Update</a>
                                            <? //} ?>
                                            <a class="btn <? echo (!empty($row['document_name'])) ? 'btn-info' : 'btn-default btn-secondary'?>" href="#attachmentModal"
                                               data-toggle="modal" data-id="<? echo $row['id'];?>" style="margin: 4px 0">
                                                Attachment</a>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-right" colspan="3">Total Hours</th>
                                    <th class="text-center"><? echo number_format($sum_hours, 2).' h' ?></th>
                                    <td colspan="5"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="horizontal-scroll" style="margin-top: 32px">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="../controller/v02_overused_conversion_exec.php" method="post">
                                        <?
                                        $half_month = date('Y-m', strtotime($month_details['month_session'])).'-'.$ot_day_closed;
                                        $total_overused = v02getOtOverused($month_details['id'], $half_month);
                                        $total_overused = ($total_overused) ?: 0;

                                        $text_total_overused = ($month_details['total_overused'] != '') ? $month_details['total_overused'] : $total_overused;
                                        $text_conversion_off_day = ($text_total_overused > 0) ? 0 : '';
                                        $text_conversion_claim = ($text_total_overused > 0) ? number_format($text_total_overused, 2) : '';

                                        $conversion_disabled = ''; /*($text_total_overused > 0) ? '' :'disabled'*/
                                        if ($month_details['conversion_offday'] != ''){
                                            $text_conversion_off_day = $month_details['conversion_offday'];
                                        }
                                        if ($month_details['conversion_claim'] != ''){
                                            $text_conversion_claim = $month_details['conversion_claim'];
                                        }
                                        ?>
                                        <table style="width: 100%" class="conversion-table">
                                            <tr>
                                                <td>Total Overused on <b><? echo date($half_month);?></b> &nbsp;</td>
                                                <td> : </td>
                                                <th style="padding-left: 16px; width: 128px;color: <? echo ($month_details['total_overused'] != '') ? 'GREEN' : 'RED'; ?>">
                                                    <input type="hidden" name="month_session_id" id="month_session_id" value="<? echo $month_session_id;?>"/>
                                                    <input type="hidden" name="total_overused" id="total_overused" value="<? echo $text_total_overused;?>"/>
                                                    <? echo $text_total_overused;?> <small><i class="text-muted">hours</i></small>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Convert to Day-Off &nbsp;</td>
                                                <td> : </td>
                                                <td style="padding-left: 8px">
                                                    <label>
                                                        <input <? echo $conversion_disabled ?> type="number" class="form-control" name="convert_to_off_day" id="convert_to_off_day"
                                                                                               oninput="inputDecimal(event)" step="0.25" min="0" max="<?// echo (number_format($text_total_overused, 2)) ?: '' ?>"
                                                                                               value="<? echo $text_conversion_off_day;?>" style="color: <? echo ($month_details['conversion_offday'] != '') ? 'GREEN' : 'RED'; ?>">
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Convert to claim &nbsp;</td>
                                                <td> : </td>
                                                <td style="padding-left: 8px">
                                                    <label>
                                                        <input <? echo $conversion_disabled ?> type="number" class="form-control" name="convert_to_claim" id="convert_to_claim"
                                                                                               oninput="inputDecimal(event)" step="0.25" min="0" max="<?// echo (number_format($text_total_overused, 2)) ?: '' ?>"
                                                                                               value="<? echo $text_conversion_claim ?>" style="color: <? echo ($month_details['conversion_claim'] != '') ? 'GREEN' : 'RED'; ?>">
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="padding-left: 8px">
                                                    <button <? echo $conversion_disabled ?> type="submit" id="save_button" class="btn btn-block btn-primary">SAVE</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="3">
                                                    <a href="../view/v02_aims_leave_quota.php?id=<? echo $month_details['staff_id'] ?>"
                                                       target="_blank">Open Leave Quota Settings &nbsp;<i class="fa fa-external-link"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="col-md-8" style="border-left: 1px dashed black">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 15%">Rate</th>
                                            <th style="width: 15%">Start</th>
                                            <th style="width: 15%">End</th>
                                            <th style="width: 15%">Total</th>
                                            <th style="width: 40%">Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <? $overused_date = v02getDateWithOverused($month_session_id);
                                        if ($overused_date->num_rows < 1){ ?>
                                            <tr>
                                                <td class="text-center text-muted" colspan="5" style="background-color: #e2e2e2">
                                                    No daily overused quota in this session</td>
                                            </tr>
                                        <? }
                                        while ($res = $overused_date->fetch_assoc()){
                                            //convert today overused hours to hours and minutes
                                            $o_hours = floor($res['today_overused']);
                                            $o_minutes = ($res['today_overused'] - $o_hours) * 60;
                                            ?>
                                            <tr style="background-color: #cdcdcd">
                                                <td colspan="5">
                                                <span class="ot-status date-summary text-white bg-dark" style="float:left;">
                                                    <? echo date("d / m / Y", strtotime($res['date']))?>
                                                </span>
                                                    <span class="ot-status date-summary text-white bg-dark" style="float:left;">
                                                    <? echo strtoupper(date("l", strtotime($res['date'])))?>
                                                </span>
                                                    <span class="ot-status date-summary text-white" style="background-color: #9f191f">
                                                    Overused: <? echo $res['today_overused']; echo ' ('.$o_hours.'h '.$o_minutes.'m)'?>
                                                </span>
                                                </td>
                                            </tr>
                                            <? $overused_detail = v02getOverusedDetails($res['id']);
                                            while ($list = $overused_detail->fetch_assoc()){
                                                //convert hours to hours and minutes
                                                $hours = floor($list['total_hours']);
                                                $minutes = ($list['total_hours'] - $hours) * 60;
                                                ?>
                                                <tr class="text-center">
                                                    <td><? echo $list['rate_mode']?></td>
                                                    <td><? echo date('h:i a', strtotime($list['start_ot']));?></td>
                                                    <td><? echo date('h:i a', strtotime($list['end_ot']));?></td>
                                                    <td><?php echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?></td>
                                                    <td class="text-left"><? echo $list['description']?></td>
                                                </tr>
                                            <? }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-danger">Please fill <b>Total Hours</b> in table before using the rates calculator</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><h5>Automatic Rate Calculator</h5></div>
                            <div class="col-sm-3">
                                <div class="form-group row">
                                    <div class="col-sm-2"><h4>: </h4></div>
                                    <div class="col-sm-10">
                                        <input type="text" name="basic_pay" id="basic_pay" class="form-control numberAndDecimalOnly" oninput="changeToRed('#basic_pay')" onkeypress="inputDecimal(event)" placeholder="Basic Pay">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"><h4>&divide;</h4></div>
                            <div class="col-md-1"><h4 class="font-weight-bold">26</h4></div>
                            <div class="col-md-1"><h4>&divide;</h4></div>
                            <div class="col-md-1"><h4 class="font-weight-bold">8</h4></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="font-weight-bold">Base Rate ( &times; 1.0)</h4>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group row">
                                    <div class="col-sm-2"><h4>: </h4></div>
                                    <div class="col-sm-10">
                                        <h4 class="font-weight-bold" id="base_rate">RM 0.00</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <form action="../controller/v02_aims_ot_hr_exec.php" method="post">
                                <input type="hidden" name="id" id="id" value="<? echo $month_details['id'];?>"/>
                                <table style="width: 100%" class="table table-bordered table-hover">
                                    <tr style="background-color: #404040; color: #FFFFFF">
                                        <td class="text-center">Rate</td>
                                        <td>Total Hours</td>
                                        <td class="text-center"></td>
                                        <td>Wage per Hour</td>
                                        <td class="text-center"></td>
                                        <td>Total Wages</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="padding-top:1.5%"><b>1.5</b></td>
                                        <td>
                                            <input type="text" name="normal_hour" id="normal_hour" class="form-control" style="color: <? echo ($month_details['normal_hour']) ? 'GREEN' : 'RED'; ?>" oninput="changeToRed('#normal_hour')"
                                                   value="<? echo (!empty($month_details['normal_hour']) && $month_details['normal_hour'] != '0.00')
                                                       ? $month_details['normal_hour'] : getTotalHourByRate($month_session_id, 1.5); ?>" onkeypress="inputDecimal(event)"/>
                                        </td>
                                        <td class="text-center"><h5>&times;</h5></td>
                                        <td>
                                            <input type="text" name="normal_wageperhour" id="normal_wageperhour" class="form-control" onkeypress="inputDecimal(event)"
                                                   style="color: <? echo ($month_details['normal_wageperhour']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['normal_wageperhour'] != '0.00') ? $month_details['normal_wageperhour'] : ''; ?>" oninput="changeToRed('#normal_wageperhour')"/>
                                        </td>
                                        <td class="text-center"><h5>&equals;</h5></td>
                                        <td>
                                            <input readonly type="text" name="normal_totalwages" id="normal_totalwages" class="form-control" value="<?echo ($month_details['normal_totalwages'] != '0.00') ? $month_details['normal_totalwages'] : ''; ?>"
                                                   style="color: <? echo ($month_details['normal_totalwages']) ? 'GREEN' : 'RED'; ?>" onkeypress="inputDecimal(event)"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="padding-top:1.5%"><b>2</b></td>
                                        <td>
                                            <input type="text" name="weekend_hour" id="weekend_hour" class="form-control" style="color: <? echo ($month_details['weekend_hour']) ? 'GREEN' : 'RED'; ?>"
                                                   oninput="changeToRed('#weekend_hour')" onkeypress="inputDecimal(event)"
                                                   value="<? echo (!empty($month_details['weekend_hour']) && $month_details['weekend_hour'] != '0.00')
                                                       ? $month_details['weekend_hour'] : getTotalHourByRate($month_session_id, 2.0); ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&times;</h5></td>
                                        <td>
                                            <input type="text" name="weekend_wageperhour" id="weekend_wageperhour" class="form-control" onkeypress="inputDecimal(event)" oninput="changeToRed('#weekend_wageperhour')"
                                                   style="color: <? echo ($month_details['weekend_wageperhour']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['weekend_wageperhour'] != '0.00') ? $month_details['weekend_wageperhour'] : ''; ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&equals;</h5></td>
                                        <td>
                                            <input readonly type="text" name="weekend_totalwages" id="weekend_totalwages" class="form-control" onkeypress="inputDecimal(event)"
                                                   style="color: <? echo ($month_details['weekend_totalwages']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['weekend_totalwages'] != '0.00') ? $month_details['weekend_totalwages'] : ''; ?>"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="padding-top:1.5%"><b>3</b></td>
                                        <td>
                                            <input type="text" name="holiday_hour" id="holiday_hour" class="form-control" style="color: <? echo ($month_details['holiday_hour']) ? 'GREEN' : 'RED'; ?>"
                                                   oninput="changeToRed('#holiday_hour')" onkeypress="inputDecimal(event)"
                                                   value="<? echo (!empty($month_details['holiday_hour']) && $month_details['holiday_hour'] != '0.00')
                                                       ? $month_details['holiday_hour'] : getTotalHourByRate($month_session_id, 3.0); ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&times;</h5></td>
                                        <td>
                                            <input type="text" name="holiday_wageperhour" id="holiday_wageperhour" class="form-control" onkeypress="inputDecimal(event)" oninput="changeToRed('#holiday_wageperhour')"
                                                   style="color: <? echo ($month_details['holiday_wageperhour']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['holiday_wageperhour'] != '0.00') ? $month_details['holiday_wageperhour'] : ''; ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&equals;</h5></td>
                                        <td>
                                            <input readonly type="text" name="holiday_totalwages" id="holiday_totalwages" class="form-control" onkeypress="inputDecimal(event)"
                                                   style="color: <? echo ($month_details['holiday_totalwages']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['holiday_totalwages'] != '0.00') ? $month_details['holiday_totalwages'] : ''; ?>"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center" style="padding-top:1.5%">~</td>
                                        <td>
                                            <input type="text" name="special_hour" id="special_hour" class="form-control" style="color: <? echo ($month_details['special_hour']) ? 'GREEN' : 'RED'; ?>"
                                                   oninput="changeToRed('#special_hour')" onkeypress="inputDecimal(event)"
                                                   value="<? echo (!empty($month_details['special_hour']) && $month_details['special_hour'] != '0.00')
                                                       ? $month_details['special_hour'] : getTotalHourByRate($month_session_id, 4.0); ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&times;</h5></td>
                                        <td>
                                            <input type="text" name="special_wageperhour" id="special_wageperhour" class="form-control" onkeypress="inputDecimal(event)" oninput="changeToRed('#special_wageperhour')"
                                                   style="color: <? echo ($month_details['special_wageperhour']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['special_wageperhour'] != '0.00') ? $month_details['special_wageperhour'] : ''; ?>"/>
                                        </td>
                                        <td class="text-center"><h5>&equals;</h5></td>
                                        <td>
                                            <input readonly type="text" name="special_totalwages" id="special_totalwages" class="form-control" onkeypress="inputDecimal(event)"
                                                   style="color: <? echo ($month_details['special_totalwages']) ? 'GREEN' : 'RED'; ?>" value="<? echo ($month_details['special_totalwages'] != '0.00') ? $month_details['special_totalwages'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="../controller/v02_hr_reset_ot_summary_exec.php?id=<? echo $month_details['id'];?>" onclick="return confirm('Are you sure to reset? Overtime status will be reverted to pending. Action cannot be undone!')"
                                               class="btn btn-sm btn-warning font-weight-bold <?// if ($approve_count > 0 || $disapprove_count > 0) echo 'disabled';?>">
                                                Reset Table</a>
                                        </td>
                                        <th colspan="3" class="text-right" style="padding-top:1.5%;border-right: 0">TOTAL (RM)</th>
                                        <td></td>
                                        <td style="text-align:center;">
                                            <input readonly type="text" value="<? echo $month_details['total_claim'];?>" name="total_claim" id="total_claim" class="form-control"
                                                   style="color: <? echo ($month_details['total_claim']) ? 'GREEN' : 'RED'; ?>" onkeypress="inputDecimal(event)"/>
                                        </td>
                                    <tr>

                                    <tr>
                                        <td class="text-right" style="border-right: 0">REVIEWED BY :</td>
                                        <th colspan="4">
                                            <? echo (v02getReviewBy($month_session_id)) ?: $_SESSION['SESS_NAME'] ; ?>
                                        </th>
                                        <td class="text-center">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="submit" name="hr_form" id="review_button" class="btn btn-block btn-primary" data-toggle="modal" value="REVIEW">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="submit" name="hr_form" id="reject_button" class="btn btn-block btn-danger" data-toggle="modal" value="REJECT">
                                                </div>
                                            </div>
                                            <? if ($approve_count > 0 || $disapprove_count > 0){ //open for a short period of time 23/08/2022 - ($approve_count < 1 && $disapprove_count < 1) || $department_sub == 'HR'?>
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                        <small class="text-danger" style="font-style: italic; font-weight: bold">
                                                            This form has been approved by CEO/Chairman. <br>
                                                            Any new changes will automatically marked as APPROVED by CEO/Chairman. <br>
                                                            Please click <span class="ot-status" style="background-color: #dbaf26">Reset Table</span> to
                                                            revert REVIEW and APPROVAL status.
                                                            <!--<span class="ot-status bg-primary">Review</span> and
                                                            <span class="ot-status" style="background-color: #d9534f">Reject</span>
                                                                    action is now disabled-->
                                                        </small>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include '../global/footer.php'; ?>
    </div>
</div>

<div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">VIEW ATTACHMENT</h4>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#attachmentModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_attachment.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#demo3').html(html);
                            }
                        });
                    });
                </script>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-block btn-danger btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">HR OVERTIME CLAIM UPDATE</h4>
            </div>
            <div class="modal-body" id="update_modal" style="">
                <script type="text/javascript">
                    $('#updateModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_hr_update_claim.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#update_modal').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "paging":   false
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function opTwoInputs(value1, value2, operator = 'multiply'){
        value1 = (value1 === undefined) ? 0 : value1;
        value2 = (value2 === undefined) ? 0 : value2;

        let total;

        if (operator === 'minus'){
            total = (value1 - value2);
            $('#total_overused, #convert_to_off_day').css('color', 'red');
        }else {
            total = (value1 * value2);
        }

        return (total === 0.00) ? null : twoDecimalPlaces(total);
    }

    function twoDecimalPlaces(num){
        let result = Math.round((num + Number.EPSILON) * 100) / 100;
        return result.toFixed(2);
    }

    //Change color if input changed
    function changeToRed(id){
        let element;
        if (id === '#basic_pay'){
            element = $('#normal_wageperhour, #normal_totalwages, #weekend_wageperhour, #weekend_totalwages, #holiday_wageperhour, #holiday_totalwages, #special_wageperhour, #special_totalwages, #total_claim');
        }else {
            if (jQuery.inArray(id, ['#normal_hour','#normal_wageperhour']) !== -1 ){
                element = $('#normal_totalwages, #total_claim')
            }else if (jQuery.inArray(id, ['#weekend_hour','#weekend_wageperhour']) !== -1 ){
                element = $('#weekend_totalwages, #total_claim')
            }else if (jQuery.inArray(id, ['#holiday_hour','#holiday_wageperhour']) !== -1 ){
                element = $('#holiday_totalwages, #total_claim')
            }else if (jQuery.inArray(id, ['#special_hour','#special_wageperhour']) !== -1 ){
                element = $('#special_totalwages, #total_claim')
            }
            $(id).css('color', 'red');
        }
        element.css('color', 'red');
    }

    //input decimal only
    function inputDecimal(evt) {
        let theEvent = evt || window.event;
        let key;
        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            // Handle key press
            let keys = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(keys);
        }
        let regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault){ theEvent.preventDefault();}
        }
    }

    //Convert to off-day/claim
    // $('#convert_to_off_day').on('input', function (e) {
    //     let total_overused = $('#total_overused').val(),
    //         toOffDay = $(this).val();

    //     let result = opTwoInputs(total_overused, toOffDay, 'minus');
    //     result = (result !== null) ? result : 0 ;

    //     $('#convert_to_claim').val(result).css('color','red');
    // });

    //Convert to off-day/claim
    // $('#convert_to_claim').on('input', function (e) {
    //     let total_overused = $('#total_overused').val(),
    //         toClaim = $(this).val();

    //     let result = opTwoInputs(total_overused, toClaim, 'minus');
    //     result = (result !== null) ? result : 0 ;

    //     $('#convert_to_off_day').val(result).css('color','red');
    // });

    //Automatic rate calculator
    $('#basic_pay').on('input', function (e) {
        let basic = e.target.value; //basic pay value
        let baseRate = (basic / 26 / 8).toFixed(2); //calculate base rate

        //multiply each rate mode with base rate
        let base1half = (baseRate * 1.5), base2 = (baseRate * 2),
            base3 = (baseRate * 3), base4 = (baseRate * 4);
        //set null if value is 0.00
        base1half = (base1half === 0.00) ? null : twoDecimalPlaces(base1half);
        base2 = (base2 === 0.00) ? null : twoDecimalPlaces(base2);
        base3 = (base3 === 0.00) ? null : twoDecimalPlaces(base3);
        base4 = (base4 === 0.00) ? null : twoDecimalPlaces(base4);

        //pick all rate mode total hour value
        let n_hour = $('#normal_hour').val(), w_hour = $('#weekend_hour').val(),
            p_hour = $('#holiday_hour').val(), s_hour = $('#special_hour').val();

        $('#base_rate').text('RM '+baseRate);
        if (n_hour !== '' && base1half !== 'NaN'){ $('#normal_wageperhour').val(base1half);}
        if (w_hour !== '' && base2 !== 'NaN'){ $('#weekend_wageperhour').val(base2);}
        if (p_hour !== '' && base3 !== 'NaN'){ $('#holiday_wageperhour').val(base3);}
        if (s_hour !== '' && base4 !== 'NaN'){ $('#special_wageperhour').val(base4);}
    });

    //calculation rates 1.5
    $('#normal_hour, #normal_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#normal_hour').val();
        let wagePerHour = $('#normal_wageperhour').val();

        $('#normal_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 2.0
    $('#weekend_hour, #weekend_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#weekend_hour').val();
        let wagePerHour = $('#weekend_wageperhour').val();

        $('#weekend_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 3.0
    $('#holiday_hour, #holiday_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#holiday_hour').val();
        let wagePerHour = $('#holiday_wageperhour').val();

        $('#holiday_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //calculation rates 4.0 (special)
    $('#special_hour, #special_wageperhour, #basic_pay').on('input', function (e) {
        let hour = $('#special_hour').val();
        let wagePerHour = $('#special_wageperhour').val();

        $('#special_totalwages').val(opTwoInputs(hour, wagePerHour))
    });

    //Sum Total Wages
    $('#normal_hour, #normal_wageperhour, #normal_totalwages, #weekend_hour, #weekend_wageperhour, #weekend_totalwages, #holiday_hour, #holiday_wageperhour, #holiday_totalwages, #special_hour, #special_wageperhour, #special_totalwages, #basic_pay')
        .on('input', function (e) {
            //Total claim: pick value and sum it
            let normalTw = $('#normal_totalwages').val(),
                weekendTw = $('#weekend_totalwages').val(),
                publicTw = $('#holiday_totalwages').val(),
                specialTw = $('#special_totalwages').val();

            //set 0.00 if any picked value is null
            normalTw = (normalTw !== '') ? parseFloat(normalTw) : 0.00;
            weekendTw = (weekendTw !== '') ? parseFloat(weekendTw) : 0.00;
            publicTw = (publicTw !== '') ? parseFloat(publicTw) : 0.00;
            specialTw = (specialTw !== '') ? parseFloat(specialTw) : 0.00;

            let totalTw = normalTw + weekendTw + publicTw + specialTw;
            totalTw = (totalTw === 0.00) ? null : twoDecimalPlaces(totalTw);
            $('#total_claim').val(totalTw);
        });
</script>
</body>
</html>