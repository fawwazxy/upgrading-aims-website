<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$shift_list = getShiftList();
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
        .d-none{
            display: none;
        }
        .float-right{
            float: right;
        }
        .status-pill{
            padding: 4px 12px;
            color: #303030;
            border-radius: 12px;
            font-weight: bold;
        }
        .status-pill-start{
            background-color: rgba(0,255,229,0.3)
        }
        .status-pill-end{
            background-color: rgba(255,191,0, 0.3)
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> SHIFT CONFIGURATION
                    <a href="masa_mula_bekerja.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px">Work Shift list</label>
                        <a href="#addShift" data-toggle="modal" class="btn btn-primary float-right">New shift</a>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="shift_list">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th class="text-center">Time</th>
                                <th>Period</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            foreach ($shift_list as $list){
                                $time = getShiftTime($list['start_time'], $list['work_hour'], $list['break_hour']);?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list['code']; ?></td>
                                    <td><? echo $list['description']; ?></td>
                                    <td class="text-center" style="font-size: 20px">
                                        <span class="status-pill status-pill-start">
                                            <? echo $time['start']; ?></span>
                                        -
                                        <span class="status-pill status-pill-end">
                                            <? echo $time['end']; ?></span>
                                    </td>
                                    <td>
                                        <span><b>Work:</b> <? echo $time['work']; ?></span><br>
                                        <span style="color: <? echo ($list['break_hour'] == 0) ? '#be0008': 'inherit'?>">
                                            <b>Break:</b> <? echo $time['break']; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-pill" style="background-color: <? echo $list['status'] ? '#9fff76' : '#ffea76' ?>">
                                            <? echo $list['status'] ? 'Active' : 'Not active'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#updateShift" data-toggle="modal" data-id="<? echo $list['id'] ?>"
                                           class="btn btn-info">Update</a>
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

<div class="modal fade" id="addShift" tabindex="-1" role="dialog" aria-labelledby="addShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addShiftModalLabel">Add new working shift</h4>
            </div>
            <div class="modal-body" id="addShiftModalBody">
                <form action="../controller/v02_aims_attendance_shift_add_exec.php" method="post">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="code">Shift Code <span style="color: red; ">*</span></label>
                                <input class="form-control" type="text" id="code" name="code" value="" maxlength="12" placeholder="P-01" required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label" for="description">Description</label>
                                <input class="form-control" type="text" id="description" name="description" value=""
                                       placeholder="Normal working hour (0800 - 1700)">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="start_time_add">Start Time <span style="color: red; ">*</span></label>
                                <input class="form-control" type="time" id="start_time_add" name="start_time" value="15:00:00" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="end_time_add">End Time <span style="color: red; ">*</span></label>
                                <input class="form-control" type="time" id="end_time_add" name="" value="00:00:00" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="status">Status <span style="color: red; ">*</span></label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="work_hour_add">Work Hour(s) <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" id="work_hour_add" name="work_hour" value="8.0" step="0.5" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="break_hour_add">Break Hour(s) <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" id="break_hour_add" name="break_hour" value="1.0" step="0.5" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateShift" tabindex="-1" role="dialog" aria-labelledby="updateShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="updateShiftModalLabel">Update working shift</h4>
            </div>
            <div class="modal-body" id="updateShiftModalBody">
                <script type="text/javascript">
                    $('#updateShift').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_attendance_shift_update.php',
                            data:{id:id},
                            success:function(html){
                                $('#updateShiftModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#shift_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            order: [3, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });

    $("#work_hour_add, #break_hour_add").on('change',function(){
        let currentObj=$(this);
        let currentVal= currentObj.val();
        let totalHour = parseFloat($('#work_hour_add').val()) + parseFloat($('#break_hour_add').val());
        let startTime = new Date ("1970-01-01 " + $('#start_time_add').val());

        if(!isNaN(currentVal)){
            let updatedVal=parseFloat(currentVal).toFixed(1);
            currentObj.val(updatedVal);

            $('#end_time_add').val(addHoursAndMinutesToTime(startTime, totalHour));
        }
        else{
            currentObj.val("0.0");
            $('#end_time_add').val("00:00:00");
        }
    });

    $("#start_time_add").on('change',function() {
        let startTime = new Date ("1970-01-01 " + $(this).val());
        let totalHour = parseFloat($('#work_hour_add').val()) + parseFloat($('#break_hour_add').val());

        if(!isNaN(totalHour)){
            $('#end_time_add').val(addHoursAndMinutesToTime(startTime, totalHour));
        }
    });
</script>
<script src="../custom-script/attendance-shift.js"></script>
</body>
</html>