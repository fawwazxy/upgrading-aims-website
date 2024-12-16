<?php
require "../controller/auth.php";
require "../model/v02_aims_leave_function.php";

if (!in_array($_SESSION['SESS_DEPARTMENT_SUB'],['HR','HR-SEA']) && $_SESSION['SESS_DEPARTMENT'] != 'SYSTEM'){
    echo "<script type='text/javascript'>
            alert('Laman yang diakses hanya dibenarkan kepada staf HR sahaja');
            window.history.back();
            </script>";
    exit();
}

$staff_id = $_GET['id'];
$staff_info = getStaffInfo($staff_id)->fetch_assoc();

$staff_name = $staff_info['name'];
$staff_ic = $staff_info['noic'];
$staff_no = $staff_info['no_staff'];
$staff_department = $staff_info['department_id'];
$staff_department_sub = $staff_info['department_sub'];

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
                    CUTI <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> KONFIGURASI KUOTA
                    <a href="staff_update_cuti.php?id=<? echo $staff_id ?>&no_staff=<? echo $staff_no ?>" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                <!--                        <h3 style="margin-top: 0; text-decoration: underline">Maklumat Peribadi</h3>-->
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Nama Penuh</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_name; ?></td>
                    </tr>
                    <tr>
                        <th>No. kad pengenalan</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_ic; ?></td>
                    </tr>
                    <tr>
                        <th>Bahagian</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_department; ?></td>
                    </tr>
                    <tr>
                        <th>Unit</th>
                        <td class="colon">:</td>
                        <td><? echo $staff_department_sub; ?></td>
                    </tr>
                    <tr>
                        <th><label for="year">Paparkan maklumat bagi tahun</label></th>
                        <td class="colon">:</td>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px">
                                <input type="hidden" name="id" value="<? echo $staff_id ?>">
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
            <div class="col-lg-12 text-right">
                <a href="#quotaModal" data-toggle="modal" class="btn btn-primary">Tambah Kuota</a>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12" style="overflow: auto">
<!--                <label></label>-->
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th colspan="7" class="text-center" style="background-color: rgb(0,0,0); color: white">
                            Senarai kuota cuti individu
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 25%; background-color: rgb(110,110,110); color: white">Jenis Cuti</th>
                        <th style="width: 15%; background-color: rgba(120,0,220,0.3)">Kuota cuti</th>
                        <th style="width: 15%; background-color: rgba(255,145,145,0.5)">Penggunaan</th>
                        <th style="width: 15%; background-color: rgba(150,211,255,0.5)">Baki terkini</th>
                        <th style="width: 15%; background-color: rgb(255,241,144)">Dalam Proses</th>
                        <th style="width: 15%; background-color: rgba(143,255,0,0.5)">Baki tersedia</th>
                        <th style="width: 15%; background-color: #FFFFFF">Tindakan</th>
                    </tr>
                    </thead>
                    <? if (mysqli_num_rows($leave_quota) < 1) { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">- Tiada kuota cuti ditambah oleh HR -</td>
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
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave">
                                            <li><a style="display: block" href="#quotaUpdate" data-toggle="modal" data-id="<? echo $quota['id'] ?>"><i class="fa fa-pencil opt-icon"></i> Kemaskini</a></li>
                                            <li><a onclick="confirmDel('../controller/v02_aims_leave_quota_delete_exec.php?id=<? echo $quota["id"] ?>','Anda pasti untuk padam permohonan cuti?')"
                                                   style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Padam</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <? }
                    } ?>
                    <tr style="width: 25%; background-color: rgb(110,110,110); color: white">
                        <th colspan="7">Maklumat jenis cuti tanpa kuota</th>
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
                            <td><span class="no-data">- Tiada -</span></td>
                            <td><? echo number_format($usage, 1) ?></td>
                            <td><span class="no-data">- Tiada -</span></td>
                            <td><? echo $pending_leave ?></td>
                            <td><span class="no-data">- Tiada -</span></td>
                            <td style="background-color: rgb(110,110,110)"></td>
                        </tr>
                    <? } ?>
                </table>
            </div>
        </div><div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <label for="leave_type" style="font-size: 18px">Senarai permohonan cuti individu</label>
                            </div>
                            <div class="col-md-3">
                                <form method="get" action="" name="leaveTypeForm" id="leave_type_form" onchange="leaveTypeForm.submit()">
                                    <input type="hidden" name="id" value="<? echo $staff_id ?>">
                                    <input type="hidden" name="year" value="<? echo $year ?>">
                                    <select class="form-control" name="leave_type" id="leave_type">
                                        <option value="all">Semua</option>
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
                                <th style="width: 10%">Tarikh mohon</th>
                                <th style="width: 15%">Maklumat Cuti</th>
                                <th style="width: 15%">Sokongan</th>
                                <th style="width: 15%">Kelulusan</th>
                                <th style="width: 15%">Semakan HR</th>
                                <th style="width: 10%">Sebab</th>
                                <th style="width: 10%">Catatan</th>
                                <th style="width: 5%">Tindakan</th>
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
                                    ? "<b class='text-green'>" .getDayName(date('w', $start_time)).", ".$start_date_dmY."</b>"

                                    : "<b class='text-green'>".getDayName(date('w', $start_time)).", ".$start_date_dmY. "</b>
                                            hingga <b class='text-red'>" .getDayName(date('w', $end_time)).", ".$end_date_dmY."</b>";
                                ?>
                                <tr>
                                    <td><? echo $i++?></td>
                                    <td>
                                        <? echo $list['created_at'].", ";
                                        echo getDayName(date('w', strtotime($list['created_at']))); ?>
                                    </td>
                                    <td>
                                        <b>Tarikh: </b><? echo $leave_date ?><br>
                                        <b>Jumlah: </b><? echo (float)$list['total_days']." hari" ?><br>
                                        <b>Jenis: </b><? echo getLeaveType($list['leave_type']) ?><br>
                                    </td>
                                    <td>
                                        <?
                                        $support_by = ($list['support_by'] == '0') ? "Auto-Approval" : strtolower(getStaffName($list['support_by'])) ;
                                        $support_at = (!empty($list['support_at'])) ? date('d/m/Y h:i:s a', strtotime($list['support_at'])) : "";
                                        if ($list['support_status'] == '1') { echo "<b class='text-green'>DISOKONG</b>"; }
                                        else if ($list['support_status'] == '0') { echo "<b class='text-red'>TIDAK DISOKONG</b>"; }
                                        else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                        echo "<p class='text-capitalize'>".$support_by."</p>";
                                        echo "<p>".$support_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $approval_at = (!empty($list['approval_at'])) ? date('d/m/Y h:i:s a', strtotime($list['approval_at'])) : "";
                                        if ($list['approval_status'] == '1') { echo "<b class='text-green'>LULUS</b>"; }
                                        else if ($list['approval_status'] == '0') { echo "<b class='text-red'>TIDAK LULUS</b>"; }
                                        else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($list['approval_by']))."</p>";
                                        echo "<p>".$approval_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $approval_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
                                        if ($list['hr_checked_status'] == '1') { echo "<b class='text-green'>DISEMAK</b>"; }
                                        else if ($list['hr_checked_status'] == '0') { echo "<b class='text-red'>DITOLAK</b>"; }
                                        else { echo "<b class='text-muted'>DALAM PROSES</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."</p>";
                                        echo "<p>".$approval_at."</p>";
                                        ?>
                                    </td>
                                    <td><? echo $list['description'] ?></td>
                                    <td>
                                        <? if ($list['balance_after_checked'] != null && $list['balance_after_checked'] > -0.5) {
                                            echo '<b>Baki:</b> '.$list['balance_after_checked'].' hari';
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
                                                <li><a style="display: block" href="#leaveAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i>Lampiran</a></li>
                                                <li><a style="display: block" href="#leaveModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-eye opt-icon"></i> Papar</a></li>
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

<!-- Modal 1: Add Leave Quota -->
<div class="modal fade" id="quotaModal" tabindex="-1" role="dialog" aria-labelledby="quotaFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="quotaFormModalLabel">Tambah kuota cuti bagi <b><? echo $staff_name ?></b></h4>
            </div>
            <form method="post" action="../controller/v02_aims_leave_quota_add_exec.php">
                <div class="modal-body" id="quotaFormModal">
                    <input name="staff_id" type="hidden" class="input-short" value="<? echo $staff_id;?>" />

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="leave_type">Jenis cuti: <span style="color: red; ">*</span></label>
                                <select class="form-control" name="leave_type" id="leave_type">
                                    <optgroup label="Cuti berkuota">
                                        <? foreach (getLeaveQuotaList(true) as $index){ ?>
                                            <option value="<? echo $index?>"><? echo getLeaveType($index) ?></option>
                                        <? } ?>
                                    </optgroup>
                                    <!--<optgroup label="Cuti tanpa kuota (tidak disarankan)">
                                        <?/* foreach (['ul', 'sl', 'cl', 'hl', 'rlu'] as $index){ */?>
                                            <option value="<?/* echo $index*/?>"><?/* echo getLeaveType($index) */?></option>
                                        <?/* } */?>
                                    </optgroup>-->
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="start_date">Tarikh mula kuota: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="date" id="start_date" name="start_date" value="<? echo date('Y-m-d')?>">
                                <b id="dateWarning" class="text-danger" style="display: none">Tarikh mula mestilah sebelum tarikh akhir</b>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="end_date">Tarikh akhir kuota: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="date" id="end_date" name="end_date" value="<? echo date('Y-m-d', strtotime('+6 months'))?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="entitled_balance">Kuota cuti: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" step="0.5" id="entitled_balance" name="entitled_balance" value="">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="current_balance">Baki terkini: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" step="0.5" id="current_balance" name="current_balance" value="">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="used_balance">Penggunaan: </label>
                                <input class="form-control" type="text" id="used_balance" name="" value="" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="submitQuotaBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Update Leave Quota -->
<div class="modal fade" id="quotaUpdate" tabindex="-1" role="dialog" aria-labelledby="quotaUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="quotaUpdateLabel">Kemaskini kuota cuti bagi <b><? echo $staff_name ?></b></h4>
            </div>
            <form method="post" action="../controller/v02_aims_leave_quota_update_exec.php">
                <div class="modal-body" id="quotaUpdateModal">
                    <script type="text/javascript">
                        $('#quotaUpdate').on('show.bs.modal', function (e) {
                            let id = $(e.relatedTarget).data('id');
                            $('#updateQuotaBtn').attr('disabled', false);
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_leave_quota_update_modal.php',
                                data:{id:id},
                                success:function(html){
                                    $('#quotaUpdateModal').html(html);
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="updateQuotaBtn">Kemaskini</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Leave Info -->
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

<!-- Modal 4: Leave Attachment -->
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

    $('#entitled_balance, #current_balance').on('focusout', function (){
        let entitled = $('#entitled_balance');
        let current =  $('#current_balance');
        let ent_value = parseFloat(entitled.val()); ent_value = (entitled.val() !== '') ? ent_value.toFixed(1) : 0;
        let cur_value = parseFloat(current.val()); cur_value = (current.val() !== '') ? cur_value.toFixed(1) : 0;

        if($(this).attr('id') === 'entitled_balance'){
            cur_value = ent_value;
        }

        entitled.val(ent_value);
        current.val(cur_value);

        let used = (ent_value-cur_value).toFixed(1);

        $('#used_balance').val(used);
    });


    $("#start_date, #end_date").on('change',function(){
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let dateWarning = $('#dateWarning');
        let submitBtn = $('#submitQuotaBtn');

        if (startDate > endDate){
            dateWarning.attr('style', 'display: block');
            submitBtn.attr('disabled', true);
        }else{
            dateWarning.attr('style', 'display: none');
            submitBtn.attr('disabled', false);
        }
    });
</script>
</body>
</html>