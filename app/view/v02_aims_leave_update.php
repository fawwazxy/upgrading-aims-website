<?php
require "../controller/auth.php";
require "../model/v02_aims_leave_function.php";

//retrieve data for update page
$leave = getLeaveById($_GET['id'])->fetch_assoc();

$current_year = date('Y');
$year = (date('Y', strtotime($leave['start_date']))) ?: $current_year;

//get available balance from database
$available_balance = getDefaultLeaveBalance();
$leave_quota = getLeaveQuotaByStaffId($_SESSION['SESS_ID'], date('Y'));
while ($quota = $leave_quota->fetch_assoc()){
    $current_days = ($leave['leave_type'] == $quota['leave_type']) ? $leave['total_days'] : 0;
    $pending_leave = getCountLeave($quota['leave_type'], $quota['staff_id'], $quota['start_date'], $quota['end_date']);
    $available_balance[$quota['leave_type']] = $quota['current_balance'] - $pending_leave + $current_days;
}

//redirect user if no data was found or the leave application has been approve/rejected.
if($leave['id'] == ''){
    $issue = "No leave application information";
}
if ($leave['approval_status'] != ""){
    $issue = "Leave has been approved/rejected. Updating is restricted";
}
if ($issue != ""){
    echo "<script>alert('".$issue."');window.history.back();</script>";
    exit();
}
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
                    CUTI <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> UPDATE
                    <a href="aims_lv.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_leave_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_lv_migration_message.php"; ?>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-lg-12">
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><? echo $leave['name']; ?></td>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><? echo $leave['noic']; ?></td>
                    </tr>
                    <tr>
                        <th>Staff No</th>
                        <td class="colon">:</td>
                        <td id="no_staff_info"><? echo $leave['no_staff']; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td class="colon">:</td>
                        <td><? echo $leave['department_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><? echo $leave['department_sub']; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Update leave application</label>
                    </div>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <form method="post" action="../controller/v02_aims_leave_update_exec.php" enctype="multipart/form-data">
                                <input name="id" type="hidden" class="input-short" value="<? echo $leave['id'] ?>" />

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <b style="color: #cb0007">Reminder:</b>
                                        <ol style="font-weight: bold">
                                            <li>Use decimals .5 for HALF DAY [example: 0.5 / 1.5 / 2.5 / 3.5]</li>
                                        </ol>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label" for="created_at">Application date: <span style="color: red; ">*</span></label>
                                            <input class="form-control" type="text" id="created_at" name="" disabled
                                                   value="<? echo date('Y-m-d', strtotime($leave['created_at'])) ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label" for="start_date">Start date: <span style="color: red; ">*</span></label>
                                            <input class="form-control" type="date" id="start_date" name="start_date" value="<? echo $leave['start_date'] ?>" required>
                                            <b id="dateWarning" class="text-danger" style="display: none">Start date must be before end date</b>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label" for="end_date">End date <span style="color: red; ">*</span></label>
                                            <input class="form-control" type="date" id="end_date" name="end_date" value="<? echo$leave['end_date'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label" for="total_days">Total day <span style="color: red; ">*</span></label>
                                            <input class="form-control" type="number" id="total_days" name="total_days" value="<? echo $leave['total_days']?>"
                                                   min="0.5" step="0.5" max="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label" for="leave_type">Type of leave:  <span style="color: red; ">*</span></label><br>
                                            <? foreach (getLeaveType("", true) as $index => $type){
                                                $disabled_text = ($available_balance[$index] <= 0) ? "disabled" : "";
                                                $checked_text = ($leave['leave_type'] == $index) ? "checked" : "";
                                                if ($index == 'ul' && $available_balance['al'] < 1){
                                                    $disabled_text = "";
                                                }
                                                ?>

                                                <input type="radio" id="leave_type_<? echo $index ?>" name="leave_type" style="margin-left: 16px" required
                                                       value="<? echo $index?>" <? echo $disabled_text." ".$checked_text?> class="leave_type" data-max="<? echo $available_balance[$index] ?>">
                                                <label for="leave_type_<? echo $index ?>" class="font-weight-english"><? echo $type ?></label><br>

                                            <? } ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label" for="description">Reason for requesting leave:  <span style="color: red; ">**</span></label>
                                            <textarea class="form-control" rows="7" id="description" name="description" required><? echo $leave['description'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label" for="document">Attachment/Document</label>
                                            <? echo ($leave['document_url']) ? '<p>'.$leave['document_url'].'</p>' : '<p class="text-muted" style="font-style: italic">- No attachments saved -</p>'; ?>
                                            <label class="control-label" for="document">Update Attachment/Document <span class="text-muted">(pdf/jpg/png/HEIC/HEIF)</span></label>
                                            <input class="" type="file" id="document" name="document" accept=".jpg,.jpeg,.png,.gif,.pdf">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="4175639">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <button type="submit" id="submitLeaveBtn" class="btn btn-lg btn-block btn-primary" onclick="return Confirm()">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $("#start_date, #end_date").on('change',function(){
        let noStaff = $('#no_staff_info').text();
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let submitBtn = $('#submitLeaveBtn');
        let dateWarning = $('#dateWarning');

        $.ajax({
            type: 'POST',
            url: '../controller/v02_aims_leave_auto_count_days.php',
            data: {no_staff:noStaff, start_date: startDate, end_date:endDate},
            dataType: 'json',
            success:function (data){
                data = parseFloat(data).toFixed(1);
                $('#total_days').val(data);
            }
        })

        if (startDate > endDate){
            dateWarning.attr('style', 'display: block');
            submitBtn.attr('disabled', true);
        }else{
            dateWarning.attr('style', 'display: none');
            submitBtn.attr('disabled', false);
        }
    });

    $("#total_days").on('change',function(){
        let currentObj=$(this);
        let currentVal= currentObj.val();
        if(!isNaN(currentVal)){
            var updatedVal=parseFloat(currentVal).toFixed(1);
            currentObj.val(updatedVal);
        }
        else{
            currentObj.val("");
        }
    });

    $("input[name='leave_type']").on('change',function(){
        let max = $(this).data('max');
        if($(this).val() === 'ul'){
            max = 21
        }
        $('#total_days').attr('max', max);
    });

    $(document).ready(function(){
        let checkedRadio = $("input[type=radio]:checked").val();
        let max = $('#leave_type_'+checkedRadio).data('max');
        if (checkedRadio === 'ul'){
            max = 21;
        }
        $('#total_days').attr('max', max);
    });
</script>
</body>
</html>