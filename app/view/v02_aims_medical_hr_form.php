<?php
include "../controller/auth.php";
require "../model/v02_aims_medical_function.php";

$id = $_GET['id'];
$staff_name = $_SESSION['SESS_NAME'];

$medical = getMedicalById($id)->fetch_assoc();
$medical_quota = getMedicalQuotaByStaffId($medical['staff_id'], $medical['receipt_date'])->fetch_assoc();

$filepath = '../../medicalphoto/'.$medical['document_name'];
$doc_name_array = explode('.',$medical['document_name']);
$file_type = end($doc_name_array);

//Count for Balance Claim Table
$used_medical = $medical_quota['entitled_balance'] - $medical_quota['current_balance'];
$pending_medical = getCountPending($medical_quota['staff_id'], $medical_quota['start_date'], $medical_quota['end_date']);
$available_medical = $medical_quota['current_balance'] - $pending_medical;

$action = "new";
if($medical['hr_verify_status'] == '1'){
    $action = "verified";
}else if ($medical['hr_verify_status'] == '0'){
    $action = "rejected";
}

if ($medical['hr_verify_status'] == ''){
    $input_current_balance = $medical_quota['current_balance'];
    $input_new_balance = $medical_quota['current_balance'] - $medical['total_claim'];
}else if ($medical['hr_verify_status'] == '1'){
    $input_current_balance = $medical['total_claim']+$medical['balance_after_approval'];
    $input_new_balance = $medical['balance_after_approval'];
}else{
    $input_current_balance = $medical['balance_after_approval'];
    $input_new_balance = $input_current_balance - $medical['total_claim'];
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
    <style>
        .verify-status{
            margin: 4px 8px;
            padding: 4px 16px;
            border: 3px solid grey;
            border-radius: 5px;
            font-weight:bold;
            color: grey;
            cursor: pointer;
        }

        .verify-status.active{
            border: 3px solid green;
            color: green;
            box-shadow: 0 0 8px 1px #19d919;
        }

        .verify-status.non-active{
            border: 3px solid #c60000;
            color: #c60000;
            box-shadow: 0 0 8px 1px #d91919;
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
                    <? include ('../../app/global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    MEDICAL <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> TOTAL MEDICAL CLAIM
                    <? if ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR') { ?>
                    <a href="aims_lv_medicalhr_form.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <? } ?>
                    <? $back_href = ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR-SEA')? 'v02_aims_medical_hr_sea_list.php':'v02_aims_medical_hr_list.php'; ?>
                    <a href="<? echo $back_href; ?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_medical_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><? echo $medical['name']; ?></td>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><? echo $medical['noic']; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td class="colon">:</td>
                        <td><? echo $medical['department_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><? echo $medical['department_sub']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th colspan="5" style="background-color: #000000; color: #ffffff">
                            Validity: <? echo date('d/m/Y', strtotime($medical_quota['start_date'])).' - '.date('d/m/Y', strtotime($medical_quota['end_date'])); ?>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 20%; background-color: rgba(145,145,145,0.5)">Entitled</th>
                        <th class="text-center" style="width: 20%; background-color: rgba(255,145,145,0.5)">Used</th>
                        <th class="text-center" style="width: 20%; background-color: rgba(150,211,255,0.5)">Current</th>
                        <th class="text-center" style="width: 20%; background-color: rgb(255,241,144)">Pending</th>
                        <th class="text-center" style="width: 20%; background-color: rgba(143,255,0,0.5)">Available</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">RM <? echo number_format($medical_quota['entitled_balance'], 2, '.', ',') ?></td>
                        <td class="text-center">RM <? echo number_format($used_medical, 2, '.', '') ?></td>
                        <td class="text-center">RM <? echo number_format($medical_quota['current_balance'], 2, '.', ',') ?></td>
                        <td class="text-center">RM <? echo number_format($pending_medical, 2, '.', ',') ?></td>
                        <th class="text-center">RM <? echo number_format($available_medical, 2, '.', ',') ?></th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">MEDICAL CLAIM</label>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="post" action="../controller/v02_aims_medical_hr_verify_exec.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<? echo $id; ?>">
                                    <input type="hidden" name="action" value="<? echo $action ?>">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_balance">Current Balance (RM): </label>
                                                <input type="text" class="form-control" id="current_balance" name="current_balance" value="<? echo number_format($input_current_balance, 2, '.', ''); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_claim">Total Claim (RM): </label>
                                                <input type="number" step="0.05" class="form-control" id="total_claim" name="total_claim" value="<? echo number_format($medical['total_claim'], 2, '.', ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_balance">New Balance (RM): </label>
                                                <input type="text" readonly class="form-control" id="new_balance" name="new_balance" value="<? echo number_format($input_new_balance, 2, '.', ''); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description: </label>
                                                <textarea class="form-control" id="description" disabled><? echo $medical['description'];?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="receipt_date">Receipt Date: </label>
                                                <input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<? echo $medical['receipt_date'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="remark">Remark: </label>
                                                <input type="text" class="form-control" id="remark" name="remark" value="<? echo $medical['remark'];?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="input_verify">Status: </label>
                                                <span id="hr_verify" data-value="1" class="verify-status <? if ($medical['hr_verify_status'] == '1') echo 'active';?>">Verify</span>
                                                <span id="hr_reject" data-value="0" class="verify-status <? if ($medical['hr_verify_status'] == '0') echo 'non-active';?>">Reject</span>
                                                <!-- Hide actual radio input -->
                                                <div style="display: none">
                                                    <input style="margin-left: 55px" type="radio" id="input_verify" name="hr_verify_status" <?php if($medical['hr_verify_status']=="1") {echo "checked";}?> value="1" required>
                                                    <input style="margin-left: 16px" type="radio" id="input_reject" name="hr_verify_status" <?php if($medical['hr_verify_status']=="0") {echo "checked";}?> value="0" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label style="margin-right: 10px">Verify by: </label><br>
                                            <?php echo (getStaffName($medical['hr_verify_by']) ?: '<i class="text-muted">- Medical claim is PENDING -</i>');?>
                                        </div>
                                        <? if ($medical['hr_verify_status'] == '0'){ ?>
                                            <div class="col-md-4">
                                                <a href="../controller/v02_aims_medical_reset_verification.php?id=<? echo $id ?>" class="btn btn-block btn-warning"
                                                   onclick="return confirm('Are you sure to reset? Verification & approval will be reverted to pending and re-opened. Action cannot be undone!')">
                                                    Reset Verification</a>
                                            </div>
                                        <? } ?>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block <? echo ($medical['hr_verify_status'] == '') ? 'btn-success' : 'btn-primary' ?>"
                                            <? if ($medical['hr_verify_status'] == '0' || $medical['cfo_approval_status'] != '' || $medical['ceo_approval_status'] != '') {
                                                echo 'disabled title="Form disabled to avoid miscalculation. Please reset if you want to update the claim."';
                                            }?>>
                                            <? echo ($medical['hr_verify_status'] == '') ? 'Save' : 'Update' ?></button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <div style="width: 100%;" class="text-center">
                                    <? echo (empty($medical['document_name'])) ? '' : '<b>Document: </b>'.$medical['document_name'];
                                    if(in_array(strtolower($file_type), ['jpg','jpeg','png','pneg'])) { ?>
                                    <img  class="img-responsive" src="<?echo $filepath;?>" alt="medical_attachment" width="100%" height="300">
                                    <? }else if(in_array(strtolower($file_type), ['heic','heif'])) { ?>
                                        <script type="text/javascript">
                                            $(document).ready(function (){
                                                fetch('<? echo $filepath ?>')
                                                    .then((res) => res.blob())
                                                    .then((blob) => heic2any({
                                                        blob,
                                                        toType: "image/jpg",
                                                        quality: 0.1,
                                                        gifInterval: 0.2,
                                                    }))
                                                    .then((conversionResult) => {
                                                        const url = URL.createObjectURL(conversionResult);
                                                        $('#heicImg').attr({'src': url, 'style': 'display: block'});
                                                        $('#loadingImg').attr('style', 'display:none')
                                                    })
                                                    .catch((e) => {
                                                        console.log(e);
                                                    });
                                            });
                                        </script>
                                        <i class="text-muted blink-me" style="margin-top: 32px; display: block" id="loadingImg">Loading HEIC/HEIF image...</i>
                                    <img class="img-responsive" id="heicImg" src="" alt="medical_attachment" width="100%" height="300">
                                    <? }else if(strtolower($file_type) == 'pdf') { ?>
                                        <iframe width="100%" height="300" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
                                    <? }else{ ?>
                                        <i class="text-muted">- No attachment -</i>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $('#total_claim').change(function (){
        let total_claim = $(this).val();
        let current_balance = parseFloat($('#current_balance').val());

        $(this).val(parseFloat(total_claim).toFixed(2));
        let total = (current_balance - total_claim).toFixed(2);
        $('#new_balance').val(total);
    });


    $(".verify-status").on('click',function(){
        let val = $(this).data('value');
        $(".verify-status").removeClass('active non-active');

        if (val === 1){
            $('#hr_verify').addClass('active');
            $('#input_verify').prop('checked', true);
        }else{
            $('#hr_reject').addClass('non-active');
            $('#input_reject').prop('checked', true);
        }
    });
</script>
</body>
</html>