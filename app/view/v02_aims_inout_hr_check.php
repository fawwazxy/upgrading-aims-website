<?php
require "../controller/auth.php";
require "../model/v02_aims_inout_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

if ($staff_department_sub != 'HR' ) {
    echo "<script>
            alert('This page is only accessible to HR Department')
            window.history.back();
            </script>";
    exit();
}

$hr_check = ($_GET['c']) ?: 'NULL';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: '0';
$company = ($_GET['company']) ?: ($staff_department) ?: 'AGHSB';
$disabled = ($year == date('Y') && $month == '0' && $company == ($staff_department) ?: 'AGHSB') ? "disabled" : "";
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
                    IN/OUT <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> HR LIST
                    <a href="aims_inout_list_hr.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_inout_migration_message.php"; ?>
        </div>

        <div class="row">
            <form method="get" action="">
                <input type="hidden" name="c" value="<? echo $hr_check ?>">
                <div class="col-md-4">
                    <select class="form-control" id="$company" name="company">
                        <? echo getDropDownCompany($company);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="month" name="month">
                        <?echo getDropDownMonth($month) ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="month" name="year">
                        <?echo getDropdownYear($year) ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info" id="filterBtn">Search</button>
                    <button type="submit" class="btn btn-success" formtarget="_blank" formaction="v02_aims_inout_print.php">Print</button>
                    <a href="v02_aims_inout_hr_check.php?c=<? echo $hr_check ?>" class="btn btn-default <? echo $disabled ?>" style="background-color: rgb(188,188,188)">Reset</a>
                </div>
            </form>
        </div>


        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="v02_aims_inout_hr_check.php?c=NULL&month=<? echo $month ?>&year=<? echo $year?>&company=<? echo $company?>" class="tabLinks <? if($hr_check=="NULL") echo 'active'?>">
                        NEW </a>
                    <a href="v02_aims_inout_hr_check.php?c=YES&month=<? echo $month ?>&year=<? echo $year?>&company=<? echo $company?>" class="tabLinks <? if($hr_check=="YES") echo 'active'?>">
                        CHECKED </a>
                    <a href="v02_aims_inout_hr_check.php?c=NO&month=<? echo $month ?>&year=<? echo $year?>&company=<? echo $company?>" class="tabLinks <? if($hr_check=="NO") echo 'active'?>">
                        REJECTED </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <form name="checkMultiple" method="post" action="../controller/v02_aims_inout_check_multiple_exec.php">
                            <? if ($hr_check == 'NULL'){ ?>
                                <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                    <input type="checkbox" id="select_all"/>&nbsp;
                                    <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                    <input type="submit" name="check_status" class="btn btn-success" id="activate" value="CHECK"/>
                                    <input type="submit" name="check_status" class="btn btn-danger" id="activate" value="REJECT"/>
                                </div>
                            <? } ?>
                            <table class="table table-hover" id="InOut_hr_checked">
                                <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 20%">In/Out Info</th>
                                    <th style="width: 20%">Staff Info</th>
                                    <th style="width: 15%">Support</th>
                                    <th style="width: 15%">Approval</th>
                                    <th style="width: 15%">HR Review</th>
                                    <th style="width: 5%">Remark</th>
                                    <th style="width: 5%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i=1;
                                $inout_list = getInOutCheckList($staff_id, $hr_check, $company, $month, $year);
                                while ($list = $inout_list->fetch_assoc()){ ?>
                                <tr>
                                    <td>
                                        <? if($list['support_status'] == '1' && $list['approval_status'] == '1'){ ?>
                                            <input name="inout_id[]" type="checkbox" class="checkbox" id="inout_id[]" value="<?php echo $list['id']; ?>"/>&nbsp;
                                        <? } ?>
                                        <label for="inout_id[]"><?php echo $i++.'.'; ?></label>
                                    </td>
                                    <td><b>Applied on: </b><br>
                                        <? echo date('Y-m-d H:i:s a, l', strtotime($list['created_at'])); ?><br>
                                        <b>Description: </b><? echo $list['description']?><br>
                                        <b>Date: </b><? echo $list['date']?><br>
                                        <b>Time Out: </b><? echo date('h:i A', strtotime($list['time_out'])) ?><br>
                                        <b>Time In: </b><? echo date('h:i A', strtotime($list['time_in']))?><br>
                                    </td>
                                    <td>
                                        <b>Name: </b><? echo $list['name'] ?><br>
                                        <b>Department: </b><? echo $list['department_id'] ?><br>
                                        <b>Unit: </b><? echo $list['department_sub'] ?><br>
                                    </td>
                                    <td>
                                        <?
                                        $support_by = ($list['support_by'] == '0') ? "Auto-Supported" : strtolower(getStaffName($list['support_by']));
                                        $support_at = (!empty($list['support_at'])) ? date('d/m/Y h:i:s a', strtotime($list['support_at'])) : "";
                                        if ($list['support_status'] == '1') { echo "<b class='text-green'>SUPPORTED</b>"; }
                                        else if ($list['support_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>IN PROGRESS</b>"; }
                                        echo "<p class='text-capitalize'>".$support_by."</p>";
                                        echo "<p>".$support_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $approve_by = ($list['approve_by'] == '0') ? "Auto-Approved" : strtolower(getStaffName($list['approve_by']));
                                        $approve_at = (!empty($list['approve_at'])) ? date('d/m/Y h:i:s a', strtotime($list['approve_at'])) : "";
                                        if ($list['approve_status'] == '1') { echo "<b class='text-green'>APPROVED</b>"; }
                                        else if ($list['approve_status'] == '0') { echo "<b class='text-red'>DISAPPROVED</b>"; }
                                        else { echo "<b class='text-muted'>IN PROGRESS</b>"; }
                                        echo "<p class='text-capitalize'>".$approve_by."</p>";
                                        echo "<p>".$approve_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $hr_checked_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
                                        if ($list['hr_checked_status'] == '1') { echo "<b class='text-green'>CHECKED</b>"; }
                                        else if ($list['hr_checked_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>IN PROGRESS</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."</p>";
                                        echo "<p>".$hr_checked_at."</p>";
                                        ?>
                                    </td>
                                    <td><? echo ($list['remark']) ? "<p>".$list['remark']."</p>" : ""; ?></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -96px">
                                                <li><a style="display: block" href="#InOutAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <li><a style="display: block" href="#usageModal" data-toggle="modal" data-id="<? echo $list['staff_id'] ?>"><i class="fa fa-bar-chart opt-icon"></i>Monthly Usage</a></li>
                                                <? if ($list['hr_checked_status'] == ''){ //Block if supported/rejected
                                                if($list['support_status'] == '1' && $list['approve_status'] == '1'){ ?>
                                                    <li><a style="color:#00a900; display: block" href="../controller/v02_aims_inout_check_exec.php?id=<? echo $list['id'] ?>&action=1"><i class="fa fa-check opt-icon"></i>Check</a></li>
                                                <? }
                                                if($list['support_status'] != '' || $list['approve_status'] != ''){ ?>
                                                    <li><a style="color:#d60008; display: block" href="../controller/v02_aims_inout_check_exec.php?id=<? echo $list['id'] ?>&action=0"><i class="fa fa-times opt-icon"></i>Reject</a></li>
                                                <? }
                                                } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<div class="modal fade" id="InOutAttachment" tabindex="-1" role="dialog" aria-labelledby="viewInOutAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewInOutAttachmentLabel">In/Out Attachment</h4>
            </div>
            <div class="modal-body" id="viewAttachmentInOut">
                <script type="text/javascript">
                    $('#InOutAttachment').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_inout_attachment.php',
                            data:{id:id, edit:0},
                            success:function(html){
                                $('#viewAttachmentInOut').html(html);
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

<div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="viewRemarkLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewRemarkLabel">In/Out Remark</h4>
            </div>
            <form action="../controller/v02_aims_inout_remark_update_exec.php" method="post">
                <div class="modal-body" id="viewRemark">
                    <script type="text/javascript">
                        $('#remarkModal').on('show.bs.modal', function (e) {
                            let id = $(e.relatedTarget).data('id');
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_inout_remark.php',
                                data:{id:id},
                                success:function(html){
                                    $('#viewRemark').html(html);
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="updateQuotaBtn">Update Remark</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="usageModal" tabindex="-1" role="dialog" aria-labelledby="viewUsageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewRemarkLabel">In/Out Monthly Usage</h4>
            </div>
            <div class="modal-body" id="viewUsage">
                <script type="text/javascript">
                    $('#usageModal').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_inout_monthly_usage.php',
                            data:{id:id, staff_info:'yes'},
                            success:function(html){
                                $('#viewUsage').html(html);
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
        $('#InOut_hr_checked').DataTable({
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

        $('#select_all').on('click',function(){
            $('input[class="checkbox"]').prop('checked', this.checked);
        });

        // select all checked if all checkbox checked
        $('.checkbox').on('click',function(){
            $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
        });
    });
</script>

</body>
</html>
