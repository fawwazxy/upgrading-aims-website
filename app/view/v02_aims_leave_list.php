<?php
require "../controller/auth.php";
require "../model/v02_aims_leave_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$current_date = date('Y-m-d');
$current_year = date('Y');
$year = ($_GET['year']) ?: $current_year;
$leave_type = ($_GET['leave_type']) ?: 'all';

$leave_quota = getLeaveQuotaByStaffId($staff_id, $year);
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
                    LEAVE <sub class="version">Version 02</sub>
                    <a href="aims_lv.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_lv_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_name; ?></td>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_ic; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_department; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_department_sub; ?></td>
                    </tr>
                    <tr>
                        <th><label for="year">Show information for the year</label></th>
                        <td class="colon">:</td>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px">
                                <select class="form-control" name="year" id="year" style="width: 128px" onchange="filterForm.submit()">
                                    <? for ($i=-1;$i<3;$i++){
                                        $option=$current_year-$i;
                                        $selected = ($option == $year) ? "selected" : "";
                                        echo "<option ".$selected.">".$option."</option>";
                                    } ?>
                                </select>
                                <input type="hidden" name="leave_type" value="<? echo $leave_type ?>">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="overflow: auto">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%; background-color: rgb(0,0,0); color: white">Leave Type</th>
                        <th style="width: 15%; background-color: rgba(145,145,145,0.5)">Leave Quota</th>
                        <th style="width: 15%; background-color: rgba(255,145,145,0.5)">Usage</th>
                        <th style="width: 15%; background-color: rgba(150,211,255,0.5)">Current Balance</th>
                        <th style="width: 15%; background-color: rgb(255,241,144)">In Process</th>
                        <th style="width: 15%; background-color: rgba(143,255,0,0.5)">Available Balance</th>
                    </tr>
                    </thead>
                    <? if (mysqli_num_rows($leave_quota) < 1) { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">- No leave quota added by HR -</td>
                        </tr>
                    <? }else{
                        while($quota = $leave_quota->fetch_assoc()){
                            $invalid = array();
                            if($current_date < $quota['start_date']){
                                $invalid['text'] = '<b class="text-warning">Upcoming... </b>';
                                $invalid['bg-color'] = 'rgba(255,200,0,0.3)';
                            }else if($current_date > $quota['end_date']){
                                $invalid['text'] = '<b class="text-danger">Expired! </b>';
                                $invalid['bg-color'] = 'rgba(255,13,0,0.3)';
                            }else{
                                $invalid['text'] = "";
                                $invalid['bg-color'] = "transparent";
                            }

                            $used_leave = $quota['entitled_balance'] - $quota['current_balance'];
                            $pending_leave = getCountLeave($quota['leave_type'], $quota['staff_id'], $quota['start_date'], $quota['end_date']);
                            $available_balance = $quota['current_balance'] - $pending_leave;
                            ?>
                            <tr style="background-color: <? echo $invalid['bg-color'] ?>">
                                <td>
                                    <?
                                    echo $invalid['text'];
                                    echo "<span class='font-weight-english'>".getLeaveType($quota['leave_type'])."</span>"
                                    ?>
                                    <span style="font-size: 12px">(
                                                    <?
                                                    echo date('d/m/Y', strtotime($quota['start_date']));
                                                    echo " - ";
                                                    echo date('d/m/Y', strtotime($quota['end_date']));
                                                    ?>
                                                )</span>
                                </td>
                                <td><? echo $quota['entitled_balance'] ?></td>
                                <td><? echo number_format($used_leave, 1) ?></td>
                                <td><? echo $quota['current_balance'] ?></td>
                                <td><? echo $pending_leave ?></td>
                                <td style="font-weight: bold"><? echo number_format($available_balance, 1) ?></td>
                            </tr>
                        <? }
                    } ?>
                    <tr style="width: 25%; background-color: rgb(110,110,110); color: white">
                        <th colspan="6">Non-quota leave type information</th>
                    </tr>
                    <? foreach (getLeaveQuotaList(false) as $item){
                        $usage = getCountLeave($item, $staff_id, $year."-01-01", $year."-12-31", 1);
                        $pending_leave = getCountLeave($item, $staff_id, $year."-01-01", $year."-12-31");
                        ?>
                        <tr>
                            <td>
                                <?
                                echo "<span class='font-weight-english'>".getLeaveType($item)."</span>"
                                ?>
                                <span style="font-size: 12px">(
                                            <?
                                            echo "01/01/".$year;
                                            echo " - ";
                                            echo "31/12/".$year;
                                            ?>
                                        )</span>
                            </td>
                            <td><span class="no-data">- None -</span></td>
                            <td><? echo number_format($usage, 1) ?></td>
                            <td><span class="no-data">- None -</span></td>
                            <td><? echo $pending_leave ?></td>
                            <td><span class="no-data">- None -</span></td>
                        </tr>
                    <? } ?>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="../view/v02_aims_leave_form.php" class="btn btn-primary">New Leave</a>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <label for="leave_type" style="font-size: 18px">List of individual leave applications</label>
                            </div>
                            <div class="col-md-3">
                                <form method="get" action="" name="leaveTypeForm" id="leave_type_form" onchange="leaveTypeForm.submit()">
                                    <input type="hidden" name="year" value="<? echo $year ?>">
                                    <select class="form-control" name="leave_type" id="leave_type">
                                        <option value="all">All</option>
                                        <? foreach (getDistinctLeave($staff_id, $year) as $index){ ?>
                                            <option value="<? echo $index?>" <? if ($index == $leave_type) echo 'selected' ?>><? echo getLeaveType($index) ?></option>
                                        <? } ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="leave_list">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Application date</th>
                                <th style="width: 15%">Leave Information</th>
                                <th style="width: 15%">Support</th>
                                <th style="width: 15%">Approval</th>
                                <th style="width: 15%">HR Check</th><??>
                                <th style="width: 10%">Reason</th>
                                <th style="width: 10%">Remarks</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $leave_list = getLeaveListByYear($staff_id, $year, $leave_type);

                            while ($list = $leave_list->fetch_assoc()){
                                $start_time = strtotime($list['start_date']);
                                $end_time = strtotime($list['end_date']);

                                $start_date_dmY = date('d/m/Y', $start_time);
                                $end_date_dmY = date('d/m/Y', $end_time);

                                $leave_date = ($list['start_date'] == $list['end_date'])
                                    ? "<b class='text-green'>" .date('l', $start_time).", ".$start_date_dmY."</b>"

                                    : "<b class='text-green'>".date('l', $start_time).", ".$start_date_dmY. "</b>
                                            until <b class='text-red'>" .date('l', $end_time).", ".$end_date_dmY."</b>";

                                $day = ($list['total_days'] > 1)?'days':'day';
                                $hr_day = ($list['balance_after_checked'] > 1)?'days':'day';
                                ?>
                                <tr>
                                    <td><? echo $i++?></td>
                                    <td>
                                        <? echo $list['created_at'].", ";
                                        echo date('l', strtotime($list['created_at'])); ?>
                                    </td>
                                    <td>
                                        <b>Date: </b><? echo $leave_date ?><br>
                                        <b>Total: </b><? echo (float)$list['total_days']." ".$day; ?><br>
                                        <b>Type: </b><? echo getLeaveType($list['leave_type']) ?><br>
                                    </td>
                                    <td>
                                        <?
                                        $support_by = ($list['support_by'] == '0') ? "Auto-Supported" : strtolower(getStaffName($list['support_by'])) ;
                                        $support_at = (!empty($list['support_at'])) ? date('d/m/Y h:i:s a', strtotime($list['support_at'])) : "";
                                        if ($list['support_status'] == '1') { echo "<b class='text-green'>SUPPORTED</b>"; }
                                        else if ($list['support_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".$support_by."</p>";
                                        echo "<p>".$support_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $approval_by = ($list['approval_by'] == '0') ? "Auto-Approved" : strtolower(getStaffName($list['approval_by'])) ;
                                        $approval_at = (!empty($list['approval_at'])) ? date('d/m/Y h:i:s a', strtotime($list['approval_at'])) : "";
                                        if ($list['approval_status'] == '1') { echo "<b class='text-green'>APPROVED</b>"; }
                                        else if ($list['approval_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".$approval_by."</p>";
                                        echo "<p>".$approval_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $approval_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
                                        if ($list['hr_checked_status'] == '1') { echo "<b class='text-green'>CHECKED</b>"; }
                                        else if ($list['hr_checked_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."</p>";
                                        echo "<p>".$approval_at."</p>";
                                        ?>
                                    </td>
                                    <td><? echo $list['description'] ?></td>
                                    <td>
                                        <? if ($list['balance_after_checked'] != null && $list['balance_after_checked'] > -0.5) {
                                            echo '<b>Balance:</b> '.$list['balance_after_checked'].' '.$hr_day;
                                        }
                                        echo $list['remark'] ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a style="display: block" href="#leaveAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i> Attachment</a></li>
                                                <li><a style="display: block" href="#leaveModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-eye opt-icon"></i> Info</a></li>
                                                <? if ($list['approval_status'] == ""){ //Block update if approved ?>
                                                    <li><a style="display: block" href="../view/v02_aims_leave_update.php?id=<? echo $list['id'] ?>"><i class="fa fa-pencil opt-icon"></i> Update</a></li>
                                                <? }
                                                if ($list['hr_checked_status'] == ""){ //Block delete if checked ?>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_leave_delete_exec.php?id=<? echo $list["id"] ?>', 'Are you sure to delete leave application?')"
                                                           style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                <? } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="viewLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewLeaveModalLabel">Show leave information</h4>
            </div>
            <div class="modal-body" id="viewModalBody">
                <script type="text/javascript">
                    $('#leaveModal').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_leave_view_modal.php',
                            data:{id:id},
                            success:function(html){
                                $('#viewModalBody').html(html);
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

<div class="modal fade" id="leaveAttachment" tabindex="-1" role="dialog" aria-labelledby="viewLeaveAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewLeaveAttachmentLabel">Leave attachment</h4>
            </div>
            <div class="modal-body" id="viewAttachmentLeave">
                <script type="text/javascript">
                    $('#leaveAttachment').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_leave_attachment.php',
                            data:{id:id, edit:1},
                            success:function(html){
                                $('#viewAttachmentLeave').html(html);
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#leave_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [0, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>