<?php
require "../controller/auth.php";
require "../model/lookup.php";
require "../model/v02_aims_medical_function.php";

$sys = getSys(1)->fetch_assoc();

$id = $_GET['id'];
$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$medical = getMedicalById($id)->fetch_assoc();

$quota = getMedicalQuotaByStaffId($staff_id, '0', true)->fetch_assoc();
$available_medical = 9999; //set default limit claim

//Count for Balance Claim Table
$used_medical = $quota['entitled_balance'] - $quota['current_balance'];
$pending_medical = getCountPending($quota['staff_id'], $quota['start_date'], $quota['end_date']);
$available_medical = $quota['current_balance'] - $pending_medical;
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
                    MEDICAL <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> UPDATE
                    <a href="aims_lv_medical_form.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_medical_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "../view/v02_aims_medical_migration_message.php";?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="staffDetailsTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><?php echo $staff_name?></td>
                    </tr>

                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><?php echo $staff_ic?></td>
                    </tr>

                    <tr>
                        <th>Company</th>
                        <td class="colon">:</td>
                        <td><?php echo $staff_department?></td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><?php echo $staff_department_sub ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-4" style="overflow: auto">
                <table class="table table-hover table-bordered">
                    <tr style="background-color: #f5f5f5">
                        <th colspan="2">Current Medical Claim Balance</th>
                    </tr>
                    <? if ($quota['current_balance'] == ''){ ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">- No medical quota added -</td>
                        </tr>
                    <? }else{?>
                        <tr style="border-bottom: 2px solid black">
                            <th class="text-center" style="width: 35%; background-color: #000000; color: #ffffff;">
                                Validity</th>
                            <th class="text-center" style="65%">
                                <? echo date('d/m/Y', strtotime($quota['start_date'])).' - '.date('d/m/Y', strtotime($quota['end_date'])); ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 15%; background-color: rgba(145,145,145,0.5)">Entitled</th>
                            <td class="text-center">RM<? echo number_format((float)$quota['entitled_balance'], 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 15%; background-color: rgba(255,145,145,0.5)">Used</th>
                            <td class="text-center">RM<? echo number_format((float)$used_medical, 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 15%; background-color: rgba(150,211,255,0.5)">Current</th>
                            <td class="text-center">RM<? echo number_format((float)$quota['current_balance'], 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 15%; background-color: rgb(255,241,144)">Pending</th>
                            <td class="text-center">RM<? echo number_format((float)$pending_medical, 2, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 15%; background-color: rgba(143,255,0,0.5)">Available</th>
                            <th class="text-center">RM<? echo number_format((float)$available_medical, 2, '.', ',') ?></th>
                        </tr>
                    <? } ?>
                </table>
            </div>

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Medical Claim Form</label>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="../controller/v02_aims_medical_update_exec.php" enctype="multipart/form-data">
                            <input id="id" name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <b style="color: #cb0007">Reminder</b>
                                    <ol style="font-weight: bold">
                                        <li>Please attached together supporting document</li>
                                        <li>The form must be verified by human resource department</li>
                                    </ol>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="receipt_date">Date Receipt <span style="color: red; ">*</span></label>
                                        <input type="date" class="input form-control" name="receipt_date" id="receipt_date"
                                               value="<? echo $medical['receipt_date'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="total_claim">Total (RM) <span style="color: red;">*</span></label>
                                        <input class="input form-control" type="number" id="total_claim" name="total_claim"
                                               min="0" max="<?echo $available_medical+$medical['total_claim'] ?>" step="0.1" value="<? echo $medical['total_claim'] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input class="input form-control" type="text" size="50" id="description" name="description" value="<? echo $medical['description'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label">Attachment</label>
                                        <? echo ($medical['document_name']) ? '<p>'.$medical['document_name'].'</p>' : '<p class="text-muted" style="font-style: italic">- No attachment was uploaded -</p>'; ?>
                                        <label class="control-label" for="document">Update Attachment <span style="color: red; ">*</span><span class="text-muted">&nbsp;(pdf/jpg/png/HEIC/HEIF)</span></label>
                                        <input type="file" accept=".jpg,.png,.pdf,.heic,.heif" name="document" id="document">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<script>
    $("#total_claim").on('change',function(){
        let currentObj=$(this);
        let currentVal= currentObj.val();
        if(!isNaN(currentVal)){
            let updatedVal=parseFloat(currentVal).toFixed(2);
            currentObj.val(updatedVal);
        }
        else{
            currentObj.val("");
        }
    });
</script>
</body>
</html>