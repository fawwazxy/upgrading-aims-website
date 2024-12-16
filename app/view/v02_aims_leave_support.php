<?php
require "../controller/auth.php";
require "../model/v02_aims_leave_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$support = ($_GET['s']) ?: 'NULL';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
$disabled = ($year == date('Y') && $month == '0') ? "disabled" : "";
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
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
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

        /* Change background color of buttons on hover */
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        /* Create an active/current tablink class */
        .tab a.active {
            background-color: #FFA500;
        }

        /* Style the tab content */
        .tabContent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .lv-status{
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
                    LEAVE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> SUPPORT
                    <a href="senarai_kelulusan_cuti.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_lv_migration_message.php"; ?>
        </div>

        <div class="row">
            <form method="get" action="">
                <input type="hidden" name="s" value="<? echo $support ?>">
                <div class="col-md-2">
                    <select class="form-control" id="month" name="month">
                        <? echo getDropDownMonth($month) ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="month" name="year">
                        <? echo getDropdownYear($year) ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-info" id="filterBtn">Search</button>
                    <a href="v02_aims_leave_support.php?s=<? echo $support ?>" class="btn btn-default <? echo $disabled ?>" style="background-color: rgb(188,188,188)">Reset</a>
                </div>
            </form>
        </div>


        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="v02_aims_leave_support.php?s=NULL&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($support=="NULL") echo 'active'?>">
                        PENDING </a>
                    <a href="v02_aims_leave_support.php?s=YES&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($support=="YES") echo 'active'?>">
                        SUPPORTED </a>
                    <a href="v02_aims_leave_support.php?s=NO&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($support=="NO") echo 'active'?>">
                        REJECTED </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="leave_support">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Application date</th>
                                <th style="width: 20%">Applicant information</th>
                                <th style="width: 15%">Leave information</th>
                                <th style="width: 15%">Support</th>
                                <th style="width: 15%">Reason</th>
                                <th style="width: 10%">Remarks</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $leave_list = getLeaveSupportList($staff_id, $month, $year, $support);

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
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td>
                                        <? echo $list['created_at'].", ";
                                        echo date('l', strtotime($list['created_at'])); ?>
                                    </td>
                                    <td>
                                        <b>Name: </b><? echo $list['name'] ?><br>
                                        <b>Company: </b><? echo $list['department_id'] ?><br>
                                        <b>Department: </b><? echo $list['department_sub'] ?><br>
                                    </td>
                                    <td>
                                        <b>Date: </b><? echo $leave_date ?><br>
                                        <b>Total: </b><? echo (float)$list['total_days']." ".$day ?><br>
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
                                    <td><? echo $list['description'] ?></td>
                                    <td><? echo $list['remark'] ?></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a style="display: block" href="#leaveAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <li><a style="display: block" href="#leaveModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-eye opt-icon"></i> Info</a></li>
                                                <? if ($list['support_status'] == ''){ //Block if supported/rejected ?>
                                                    <li><a style="color:#00a900; display: block" href="../controller/v02_aims_leave_support_exec.php?id=<? echo $list['id'] ?>&action=1"><i class="fa fa-check opt-icon"></i> Support</a></li>
                                                    <li><a style="color:#d60008; display: block" href="../controller/v02_aims_leave_support_exec.php?id=<? echo $list['id'] ?>&action=0"><i class="fa fa-times opt-icon"></i> Reject</a></li>
                                                <? }?>
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
        <? include ('../global/footer.php'); ?>
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
                            data:{id:id, edit:0},
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
        $('#leave_support').DataTable({
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