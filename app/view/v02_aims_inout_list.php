<?php
require "../controller/auth.php";
require "../model/v02_aims_inout_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$current_year = date('Y');
$year = ($_GET['year']) ?: '0';

//retrieve data for update page
$inout = getInOutById($_GET['id'])->fetch_assoc();
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
        .staffDetailTable tr{
            height: 24px;
        }
        .colon{
            padding: 0 16px;
        }
        .font-weight-english{
            font-weight: normal;
            font-style: italic;
        }
        .bg-expired{
            background-color: rgba(255, 160, 145, 0.51);
            color: #000000;
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
                    IN/OUT <sub class="version">Version 02</sub>
                    <a href="aims_inout.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_inout_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_name; ?>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_ic; ?>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_department; ?>
                    </tr>
                    <tr>
                        <th>Unit</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_department_sub; ?>
                    </tr>
                    <tr>
                        <th><label for="year">Show info for year:</label></th>
                        <td class="colon">:</td>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px">
                                <select class="form-control" name="year" id="year" style="width: 128px" onchange="filterForm.submit()">
                                    <option value="0" <? if ($year == '0') echo 'selected' ?>>All</option>
                                    <? for ($i=0;$i<3;$i++){
                                        $option=$current_year-$i;
                                        $selected = ($option == $year) ? "selected" : "";
                                        echo "<option ".$selected.">".$option."</option>";
                                    } ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-red" colspan="3">
                            Notes: Every staff is eligible to apply in/out for medical purpose 2 times each month with
                            maximum period of 2 hours for each application.
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-6" id="monthly_usage" data-id="<? echo $staff_id ?>">
                <script type="text/javascript">
                    $(document).ready(function() {
                        let id = $('#monthly_usage').data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_inout_monthly_usage.php',
                            data:{id:id},
                            success:function(html){
                                $('#monthly_usage').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="#InOutModal" class="btn btn-primary" data-toggle="modal">New In/Out</a>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>In/Out Permission List</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="inOut_list">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Date Applied On</th>
                                <th style="width: 10%">In/Out Info</th>
                                <th style="width: 10%">Support</th>
                                <th style="width: 10%">Approval</th>
                                <th style="width: 10%">HR Review</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $inout_list = getInOutList($staff_id, $year);

                            while ($list = $inout_list->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><? echo $i++?></td>
                                    <td>
                                        <? echo date('Y-m-d H:i:s a, l', strtotime($list['created_at'])); ?>
                                    </td>
                                    <td>
                                        <b>Description: </b><? echo $list['description']?><br>
                                        <b>Date: </b><? echo $list['date']?><br>
                                        <b>Time Out: </b><? echo date('h:i A', strtotime($list['time_out'])) ?><br>
                                        <b>Time In: </b><? echo date('h:i A', strtotime($list['time_in']))?><br>
                                    </td>
                                    <td>
                                        <?
                                        $support_by = ($list['support_by'] == '0') ? "Auto-Supported" : strtolower(getStaffName($list['support_by'])) ;
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
                                        $checked_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
                                        if ($list['hr_checked_status'] == '1') { echo "<b class='text-green'>CHECKED</b>"; }
                                        else if ($list['hr_checked_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>IN PROGRESS</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."</p>";
                                        echo "<p>".$checked_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -96px">
                                                <li><a style="display: block" href="#InOutAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <? if ($list['approve_status'] == ""){ //Block update if approved ?>
                                                    <li><a style="display: block" href="#UpdateInOutModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-pencil opt-icon"></i>Edit</a></li>
                                                <? }
                                                if ($list['hr_checked_status'] == ""){ //Block delete if checked ?>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_inout_delete_exec.php?id=<? echo $list["id"] ?>', 'Anda pasti untuk padam permohonan In/Out?')"
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
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<div class="modal fade" id="InOutModal" tabindex="-1" role="dialog" aria-labelledby="viewInOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewInOutModalLabel">New In/Out</h4>
            </div>
            <div class="modal-body" id="viewModalBody">
                <form method="post" action="../controller/v02_aims_inout_add_exec.php" enctype="multipart/form-data">
                    <input type="hidden" class="input-short" name="staff_id" value="<? echo $_SESSION['SESS_ID'];?>" />
                    <div class="form-group">

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label" for="date">Date: <span style="color: red; ">*</span></label>
                                    <input class="form-control" type="date" id="date" name="date" value="<? echo date('Y-m-d') ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label" for="time_out">Time Out: <span style="color: red; ">*</span></label>
                                    <input class="form-control" type="time" id="time_out" name="time_out" value="08:00:00" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="control-label" for="time_in">Time In: <span style="color: red; ">*</span></label>
                                    <input class="form-control" type="time" id="time_in" name="time_in" value="10:00:00" required>
                                </div>
                                <b id="timeWarning" style="font-size: 12px;color: red"></b>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="control-label" for="description">Description: <span style="color: red; ">*</span></label><br>
                            <textarea class="form-control" rows="2" id="description" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="document">Attachment/Document <span class="text-muted">(pdf/jpg/png/HEIC/HEIF)</span></label>
                            <input class="" type="file" id="document" name="document" accept=".jpg,.jpeg,.png,.gif,.pdf">
                            <input type="hidden" name="MAX_FILE_SIZE" value="4175639">
                        </div>
                        <br>
                        <input type="submit" id="submitBtn" class="btn btn-block btn-success btn-rounded btn-md ml-4" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UpdateInOutModal" tabindex="-1" role="dialog" aria-labelledby="UpdateInOutModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="UpdateInOutModalLabel">Update In/Out</h4>
            </div>
            <div class="modal-body" id="UpdateInOutModalBody">
                <script type="text/javascript">
                    $('#UpdateInOutModal').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_inout_update.php',
                            data:{id:id},
                            success:function(html){
                                $('#UpdateInOutModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
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
                            data:{id:id, edit:1},
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

<script>
    $(document).ready(function() {
        $('#inOut_list').DataTable({
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


    $('#time_out, #time_in').change(function (){
        let timeIn = $('#time_in').val(),
            timeOut = $('#time_out').val();

        timeIn = (timeIn.length === 5) ? timeIn+':00' : timeIn;
        timeOut = (timeOut.length === 5) ? timeOut+':00' : timeOut;

        let diffInMinutes = (convertDateForIos("1970-1-1 " + timeIn) - convertDateForIos("1970-1-1 " + timeOut)) / 1000 / 60;
        console.log(diffInMinutes);

        if(timeOut > timeIn){
            $('#timeWarning').html('TIME IN must be greater than TIME OUT<br>');
            $('#submitBtn').attr('disabled', true);
        }else if(diffInMinutes > 120){
            $('#timeWarning').html('Maximum In Out period is 2 hours<br>');
            $('#submitBtn').attr('disabled', true);
        }else{
            $('#timeWarning').html('');
            $('#submitBtn').attr('disabled', false);
        }
    });

    function convertDateForIos(date) {
        let arr = date.split(/[- :]/);
        date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
        return date;
    }
</script>
</body>
</html>