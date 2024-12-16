<?php
require "../controller/auth.php";
require "../model/v02_aims_leave_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

if ($staff_department_sub != 'HR' && $_SESSION['SESS_ID'] != '2') {
    echo "<script>
            alert('Halaman ini hanya tersedia untuk department HR')
            window.history.back();
            </script>";
    exit();
}

$hr_check = ($_GET['c']) ?: 'NULL';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
$leave_type = ($_GET['type']) ?: 'al';
$company = ($_GET['company']) ?: ($staff_department) ?: 'AGHSB';
$disabled = ($year == date('Y') && $month == '0' && $leave_type == 'al' && $company == 'AGHSB') ? "disabled" : "";
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
                    CUTI <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> SEMAKAN HR
                    <a href="list_cuti_HR_AL.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                <input type="hidden" name="c" value="<? echo $hr_check ?>">
                <div class="col-md-2">
                    <select class="form-control" id="type" name="type">
                        <? foreach (getLeaveType('', true) as $index => $value){
                            $selected = ($index == $leave_type) ? "selected" : "";?>
                            <option value="<? echo $index ?>" <? echo $selected ?>><? echo $value ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="company" name="company">
                        <? echo getDropdownCompany($company); ?>
                    </select>
                </div>
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
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info" formaction="" id="filterBtn">Cari</button>
                    <button type="submit" class="btn btn-success" formtarget="_blank" formaction="v02_aims_leave_print.php">Cetak</button>
<!--                    <a href="v02_aims_leave_print.php?c=NO&month=--><?// echo $month?><!--&year=--><?// echo $year?><!--&type=--><?// echo $leave_type?><!--&company=--><?// echo $company?><!--"-->
<!--                       class="btn btn-success">Cetak</a>-->
                    <a href="v02_aims_leave_support.php?c=<? echo $hr_check ?>" class="btn btn-default <? echo $disabled ?>"
                       style="background-color: rgb(188,188,188)" title="Set semula"><i class="fa fa-undo"></i></a>
                </div>
            </form>
        </div>


        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="v02_aims_leave_hr_check.php?c=NULL&month=<? echo $month?>&year=<? echo $year?>&type=<? echo $leave_type?>&company=<? echo $company?>"
                       class="<? if($hr_check=="NULL") echo 'active'?>">BAHARU </a>
                    <a href="v02_aims_leave_hr_check.php?c=YES&month=<? echo $month?>&year=<? echo $year?>&type=<? echo $leave_type?>&company=<? echo $company?>"
                       class="<? if($hr_check=="YES") echo 'active'?>">DISEMAK </a>
                    <a href="v02_aims_leave_hr_check.php?c=NO&month=<? echo $month?>&year=<? echo $year?>&type=<? echo $leave_type?>&company=<? echo $company?>"
                       class="<? if($hr_check=="NO") echo 'active'?>">DITOLAK </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <form name="checkMultiple" method="post" action="../controller/v02_aims_leave_check_multiple_exec.php">
                            <? if ($hr_check == 'NULL'){ ?>
                            <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                <input type="checkbox" id="select_all"/>&nbsp;
                                <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                <input type="submit" name="check_status" class="btn btn-success" id="activate" value="SEMAK"/>
                                <input type="submit" name="check_status" class="btn btn-danger" id="activate" value="BATAL"/>
                            </div>
                            <? } ?>
                            <table class="table table-hover" id="leave_support">
                                <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 11%">Tarikh mohon</th>
                                    <th style="width: 20%">Maklumat Pemohon</th>
                                    <th style="width: 15%">Maklumat Cuti</th>
                                    <th style="width: 15%">Sokongan/Kelulusan</th>
                                    <th style="width: 15%">Sebab</th>
                                    <th style="width: 12%">Semakan HR</th>
                                    <th style="width: 7%">Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i=1;
                                $leave_list = getLeaveCheckList($staff_id, $hr_check, $leave_type, $company, $month, $year);

                                while ($list = $leave_list->fetch_assoc()){
                                    $start_time = strtotime($list['start_date']);
                                    $end_time = strtotime($list['end_date']);

                                    $start_date_dmY = date('d/m/Y', $start_time);
                                    $end_date_dmY = date('d/m/Y', $end_time);

                                    $leave_date = ($list['start_date'] == $list['end_date'])
                                        ? "<b class='text-green'>" .getDayName(date('w', $start_time)).", ".$start_date_dmY."</b>"

                                        : "<b class='text-green'>".getDayName(date('w', $start_time)).", ".$start_date_dmY. "</b>
                                                hingga <b class='text-red'>" .getDayName(date('w', $end_time)).", ".$end_date_dmY."</b>";
                                    ?>
                                    <tr>
                                        <td>
                                            <? if($list['support_status'] == '1' && $list['approval_status'] == '1'){ ?>
                                                <input name="leave_id[]" type="checkbox" class="checkbox" id="leave_id[]" value="<?php echo $list['id']; ?>" />&nbsp;
                                            <? } ?>
                                            <label for="leave_id[]"><?php echo $i++.'.'; ?></label>
                                        </td>
                                        <td>
                                            <? echo $list['created_at'].", ";
                                            echo getDayName(date('w', strtotime($list['created_at']))); ?>
                                        </td>
                                        <td>
                                            <b>Nama: </b><? echo $list['name'] ?><br>
                                            <b>Bahagian: </b><? echo $list['department_id'] ?><br>
                                            <b>Unit: </b><? echo $list['department_sub'] ?><br>
                                        </td>
                                        <td>
                                            <b>Tarikh: </b><? echo $leave_date ?><br>
                                            <b>Jumlah: </b><? echo (float)$list['total_days']." hari" ?><br>
                                            <b>Jenis: </b><? echo getLeaveType($list['leave_type']) ?><br>
                                            <? echo ($list['balance_after_checked']) ? "<b>Baki: </b>".(float)$list['balance_after_checked']." hari" : ""; ?><br>
                                        </td>
                                        <!--<td>
                                            <b>Sokongan: <span class="text-green">DISOKONG</span></b>
                                            <p class="text-capitalize"><?/* echo strtolower(getStaffName($list['support_by'])) */?></p>
                                            <p><?/* echo date('d/m/Y h:i:s a', strtotime($list['support_at'])) */?></p>

                                            <b>Kelulusan:  <span class="text-green">LULUS</span></b>
                                            <p class="text-capitalize"><?/* echo strtolower(getStaffName($list['approval_by'])) */?></p>
                                            <p><?/* echo date('d/m/Y h:i:s a', strtotime($list['approval_at'])) */?></p>
                                        </td>-->

                                        <td>
                                            <b>Sokongan: </b>
                                            <?
                                            $support_by = ($list['support_by'] == '0') ? "Auto-Supported" : strtolower(getStaffName($list['support_by'])) ;
                                            $support_at = (!empty($list['support_at'])) ? date('d/m/Y h:i:s a', strtotime($list['support_at'])) : "";
                                            if ($list['support_status'] == '1') { echo "<b class='text-green'>DISOKONG</b>"; }
                                            else if ($list['support_status'] == '0') { echo "<b class='text-red'>TIDAK DISOKONG</b>"; }
                                            else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                            echo "<p class='text-capitalize'>".$support_by."</p>";
                                            echo "<p>".$support_at."</p>";
                                            ?>
                                            <b>Kelulusan: </b>
                                            <?
                                            $approval_by = ($list['approval_by'] == '0') ? "Auto-Approved" : strtolower(getStaffName($list['approval_by'])) ;
                                            $approval_at = (!empty($list['approval_at'])) ? date('d/m/Y h:i:s a', strtotime($list['approval_at'])) : "";
                                            if ($list['approval_status'] == '1') { echo "<b class='text-green'>LULUS</b>"; }
                                            else if ($list['approval_status'] == '0') { echo "<b class='text-red'>TIDAK LULUS</b>"; }
                                            else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                            echo "<p class='text-capitalize'>".$approval_by."</p>";
                                            echo "<p>".$approval_at."</p>";
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                            echo $list['description'];
                                            echo ($list['remark']) ? "<br><br><b>Catatan: </b><p>".$list['remark']."</p>" : "";
                                            ?>
                                        </td>
                                        <td>
                                            <?
                                            $hr_checked_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
                                            if ($list['hr_checked_status'] == '1') { echo "<b class='text-green'>DISEMAK</b>"; }
                                            else if ($list['hr_checked_status'] == '0') { echo "<b class='text-red'>DITOLAK</b>"; }
                                            else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                            echo "<p class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."</p>";
                                            echo "<p>".$hr_checked_at."</p>";
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -156px">
                                                    <li><a style="display: block" href="#leaveAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i>Lampiran</a></li>
                                                    <li><a style="display: block" href="#leaveModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-eye opt-icon"></i> Papar</a></li>
                                                    <li><a style="display: block" href="../view/v02_aims_leave_quota.php?id=<? echo $list['staff_id'] ?>" target="_blank"><i class="fa fa-bar-chart opt-icon"></i> Senarai Cuti & Kuota</a></li>
                                                    <li><a style="display: block" href="#remarkModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-thumb-tack opt-icon"></i> Catatan</a></li>
                                                    <? if ($list['hr_checked_status'] == ''){ //Block if checked/rejected
                                                        if($list['support_status'] == '1' && $list['approval_status'] == '1'){ ?>
                                                            <li><a style="color:#00a900; display: block" href="../controller/v02_aims_leave_check_exec.php?id=<? echo $list['id'] ?>&action=1"><i class="fa fa-check opt-icon"></i> Semak</a></li>
                                                        <? }
                                                        if($list['support_status'] != '' || $list['approval_status'] != ''){ ?>
                                                            <li><a style="color:#d60008; display: block" href="../controller/v02_aims_leave_check_exec.php?id=<? echo $list['id'] ?>&action=0"><i class="fa fa-times opt-icon"></i> Batal</a></li>
                                                        <? }
                                                    }?>
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


<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="viewLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewLeaveModalLabel">Papar maklumat cuti</h4>
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
                <h4 class="modal-title" id="viewLeaveAttachmentLabel">Lampiran cuti</h4>
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

<div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="viewRemarkLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewRemarkLabel">Catatan permohonan cuti</h4>
            </div>
            <form action="../controller/v02_aims_leave_remark_update_exec.php" method="post">
                <div class="modal-body" id="viewRemark">
                    <script type="text/javascript">
                        $('#remarkModal').on('show.bs.modal', function (e) {
                            let id = $(e.relatedTarget).data('id');
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_leave_remark.php',
                                data:{id:id},
                                success:function(html){
                                    $('#viewRemark').html(html);
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="updateQuotaBtn">Kemaskini Catatan</button>
                </div>
            </form>
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
            order: [1, 'desc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();

        // all checkbox checked if select all is checked
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