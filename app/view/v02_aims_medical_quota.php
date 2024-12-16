<?php
require "../controller/auth.php";
require "../model/v02_aims_medical_function.php";

if (!in_array($_SESSION['SESS_DEPARTMENT_SUB'],['HR','HR-SEA']) && $_SESSION['SESS_DEPARTMENT'] != 'SYSTEM'){
    echo "<script type='text/javascript'>
            alert('This page only accessible for HR Department.');
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
$year = ($_GET['year']) ?: '0';

$medical_quota = getMedicalQuotaByStaffId($staff_id, $year);
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
                    MEDICAL <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> QUOTA CONFIGURATION
                    <a href="aims_lv_tetapan_medical.php?id=<? echo $staff_id ?>&no_staff=<? echo $staff_no ?>" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_medical_migration_message.php"; ?>
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
                        <th><label for="year">Show info for year</label></th>
                        <td class="colon">:</td>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px">
                                <select class="form-control" name="year" id="year" style="width: 128px" onchange="filterForm.submit()">
                                    <option value="0" <? if ($year == '0') echo 'selected' ?>>All</option>
                                    <? for ($i=-1;$i<3;$i++){
                                        $option=$current_year-$i;
                                        $selected = ($option == $year) ? "selected" : "";
                                        echo "<option ".$selected.">".$option."</option>";
                                    } ?>
                                </select>
                                <input type="hidden" name="id" value="<? echo $staff_id ?>">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="#quotaModal" data-toggle="modal" class="btn btn-primary">Add Quota</a>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Individual Medical Claim Quota List</label>
                    </div>
                    <div class="panel-body" style="overflow: auto; padding: 0 0 64px">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 25%; background-color: #000000; color: #ffffff">Start/End</th>
                                <th class="text-center" style="width: 13%; background-color: rgba(145,145,145,0.5)">Entitled</th>
                                <th class="text-center" style="width: 13%; background-color: rgba(255,145,145,0.5)">Used</th>
                                <th class="text-center" style="width: 13%; background-color: rgba(150,211,255,0.5)">Current</th>
                                <th class="text-center" style="width: 13%; background-color: rgb(255,241,144)">Pending</th>
                                <th class="text-center" style="width: 13%; background-color: rgba(143,255,0,0.5)">Available</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? if ($medical_quota->num_rows < 1) { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">- No medical quota added by HR -</td>
                                </tr>
                            <? }else{
                                while($quota = $medical_quota->fetch_assoc()){
                                    $invalid = array();
                                    if($current_date < $quota['start_date']){
                                        $invalid['text'] = '<br><b class="text-warning">Upcoming... </b>';
                                        $invalid['bg-color'] = 'rgba(255,200,0,0.3)';
                                    }else if($current_date > $quota['end_date']){
                                        $invalid['text'] = '<br><b class="text-danger">Expired! </b>';
                                        $invalid['bg-color'] = 'rgba(255,13,0,0.3)';
                                    }else{
                                        $invalid['text'] = "";
                                        $invalid['bg-color'] = "transparent";
                                    }

                                    //Count for Balance Claim Table
                                    $used_medical = $quota['entitled_balance'] - $quota['current_balance'];
                                    $pending_medical = getCountPending($quota['staff_id'], $quota['start_date'], $quota['end_date']);
                                    $available_medical = $quota['current_balance'] - $pending_medical;
                                    ?>
                                    <tr style="background-color: <? echo $invalid['bg-color'] ?>">
                                        <th class="text-center">
                                            <? echo date('d/m/Y', strtotime($quota['start_date'])).' - '.date('d/m/Y', strtotime($quota['end_date']));
                                            echo $invalid['text']; ?>
                                        </th>
                                        <td class="text-center">RM <? echo number_format($quota['entitled_balance'], 2, '.', ',') ?></td>
                                        <td class="text-center">RM <? echo number_format($used_medical, 2, '.', '') ?></td>
                                        <td class="text-center">RM <? echo number_format($quota['current_balance'], 2, '.', ',') ?></td>
                                        <td class="text-center">RM <? echo number_format($pending_medical, 2, '.', ',') ?></td>
                                        <th class="text-center">RM <? echo number_format($available_medical, 2, '.', ',') ?></th>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -72px">
                                                    <li><a style="display: block" href="#quotaUpdate" data-toggle="modal" data-id="<? echo $quota['id'] ?>"><i class="fa fa-pencil opt-icon"></i> Update</a></li>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_medical_quota_delete_exec.php?id=<? echo $quota["id"] ?>','Are you sure to delete this medical quota?')"
                                                           style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <? }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<div class="modal fade" id="quotaModal" tabindex="-1" role="dialog" aria-labelledby="quotaFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="quotaFormModalLabel">Add new Medical Quota for <b><? echo $staff_name ?></b></h4>
            </div>
            <form method="post" action="../controller/v02_aims_medical_quota_add_exec.php">
                <div class="modal-body" id="quotaFormModal">
                    <input name="staff_id" type="hidden" class="input-short" value="<? echo $staff_id;?>" />

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="start_date">Quota Start Date: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="date" id="start_date" name="start_date" value="<? echo date('Y-m-d')?>">
                                <b id="dateWarning" class="text-danger" style="display: none">Start Date must before End Date</b>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="end_date">Quota End Date: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="date" id="end_date" name="end_date" value="<? echo date('Y-m-d', strtotime('+6 months'))?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="entitled_balance">Medical Quota: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" step="0.01" max="99999999.99" id="entitled_balance" name="entitled_balance" value="">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="current_balance">Current Balance: <span style="color: red; ">*</span></label>
                                <input class="form-control" type="number" step="0.01" max="99999999.99" id="current_balance" name="current_balance" value="">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="used_balance">Usage: </label>
                                <input class="form-control" type="text" id="used_balance" name="" value="" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="update_submitQuotaBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quotaUpdate" tabindex="-1" role="dialog" aria-labelledby="quotaUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="quotaUpdateLabel">Update Medical Quota for <b><? echo $staff_name ?></b></h4>
            </div>
            <form method="post" action="../controller/v02_aims_medical_quota_update_exec.php">
                <div class="modal-body" id="quotaUpdateModal">
                    <script type="text/javascript">
                        $('#quotaUpdate').on('show.bs.modal', function (e) {
                            let id = $(e.relatedTarget).data('id');
                            $('#updateQuotaBtn').attr('disabled', false);
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_medical_quota_update_modal.php',
                                data:{id:id},
                                success:function(html){
                                    $('#quotaUpdateModal').html(html);
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-lg btn-block btn-success" id="updateQuotaBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#entitled_balance, #current_balance').on('focusout', function (){
        let entitled = $('#entitled_balance');
        let current =  $('#current_balance');
        let ent_value = parseFloat(entitled.val()); ent_value = (entitled.val() !== '') ? ent_value.toFixed(2) : 0;
        let cur_value = parseFloat(current.val()); cur_value = (current.val() !== '') ? cur_value.toFixed(2) : 0;

        if($(this).attr('id') === 'entitled_balance'){
            cur_value = ent_value;
        }

        entitled.val(ent_value);
        current.val(cur_value);

        let used = (ent_value-cur_value).toFixed(2);

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