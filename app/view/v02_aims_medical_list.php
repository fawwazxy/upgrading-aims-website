<?php
include "../controller/auth.php";
require "../model/v02_aims_medical_function.php";
require "../model/lookup.php";

$sys = getSys(1)->fetch_assoc();

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$current_date = date('Y-m-d');
$current_year = date('Y');
$year = ($_GET['year']) ?: "0";

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
                    MEDICAL CLAIM <sub class="version">Version 02</sub>
                    <a href="aims_lv_medical_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
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
                    <tr>
                        <th><label for="year">Display Info for year</label></th>
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
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12" style="overflow: auto;">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 25%; background-color: #000000; color: #ffffff">Start/End</th>
                        <th class="text-center" style="width: 15%; background-color: rgba(145,145,145,0.5)">Entitled</th>
                        <th class="text-center" style="width: 15%; background-color: rgba(255,145,145,0.5)">Used</th>
                        <th class="text-center" style="width: 15%; background-color: rgba(150,211,255,0.5)">Current</th>
                        <th class="text-center" style="width: 15%; background-color: rgb(255,241,144)">Pending</th>
                        <th class="text-center" style="width: 15%; background-color: rgba(143,255,0,0.5)">Available</th>
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
                            </tr>
                        <? }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="v02_aims_medical_form.php" class="btn btn-primary">New Medical Claim</a>
            </div>
        </div>

        <div class="row" style="margin-top: 16px; overflow: auto">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Medical Claim List</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 6%" class="text-center">No.</th>
                                <th style="width: 19%">Medical Claim Info</th>
                                <th style="width: 10%">Amount</th>
                                <th style="width: 15%">HR</th>
                                <th style="width: 15%">CFO</th>
                                <th style="width: 15%">CEO</th>
                                <th style="width: 13%">Status</th>
                                <th style="width: 7%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $medical_list = getMedicalList($staff_id, $year);
                            while($medical = $medical_list->fetch_assoc()){
                                ?>
                                <tr>
                                    <td class="text-center"><? echo $i++;?></td>
                                    <td>
                                        <p><b>Receipt date: </b><? echo date('Y-m-d, l', strtotime($medical['receipt_date'])); ?></p>
                                        <p><b>Description: </b><? echo ucfirst($medical['description']);?></p>
                                        <p><b>Applied on: </b><? echo $medical['created_at'];?></p>
                                    </td>
                                    <td>
                                        <b>Total Claim: </b><br>
                                        <b class="text-green">RM <? echo $medical['total_claim'];?></b><br>
                                        <b>Claim Balance:  </b><br>
                                        <? echo (empty($medical['balance_after_approval']))
                                            ? '<i style="font-size: 12px; color: #616161">- Pending -</i>'
                                            : '<b class="text-primary">RM '.$medical['balance_after_approval'].'</b>' ?>
                                    </td>
                                    <td>
                                        <?
                                        $hr_verify_at = (!empty($medical['hr_verify_at'])) ? date('d/m/Y h:i:s a', strtotime($medical['hr_verify_at'])) : "";
                                        if ($medical['hr_verify_status'] == '1') { echo "<b class='text-green'>VERIFIED</b>"; }
                                        else if ($medical['hr_verify_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($medical['hr_verify_by']))."</p>";
                                        echo "<p>".$hr_verify_at."</p>";
                                        echo "<span class='font-italic'>".$medical['remark']."</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $cfo_approval_at = (!empty($medical['cfo_approval_at'])) ? date('d/m/Y h:i:s a', strtotime($medical['cfo_approval_at'])) : "";
                                        if ($medical['cfo_approval_status'] == '1') { echo "<b class='text-green'>APPROVED</b>"; }
                                        else if ($medical['cfo_approval_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($medical['cfo_approval_by']))."</p>";
                                        echo "<p>".$cfo_approval_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $ceo_approval_at = (!empty($medical['ceo_approval_at'])) ? date('d/m/Y h:i:s a', strtotime($medical['ceo_approval_at'])) : "";
                                        if ($medical['ceo_approval_status'] == '1') { echo "<b class='text-green'>APPROVED</b>"; }
                                        else if ($medical['ceo_approval_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                                        else { echo "<b class='text-muted'>PENDING</b>"; }
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($medical['ceo_approval_by']))."</p>";
                                        echo "<p>".$ceo_approval_at."</p>";
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        $closed_at = (!empty($medical['payment_closed_at'])) ? date('d/m/Y h:i:s a', strtotime($medical['payment_closed_at'])) : "";
                                        echo ($medical['payment_closed_at'] == '') ? "<b class='text-red'>OPEN</b>" : "<b class='text-green'>CLOSED</b>";
                                        echo "<p class='text-capitalize'>".strtolower(getStaffName($medical['payment_closed_by']))."</p>";
                                        echo "<p>".$closed_at."</p>";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuMedical" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuMedical">
                                                <li><a style="display: block" href="#medicalAttachment" data-toggle="modal" data-id="<? echo $medical['id']?>"><i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <? if ($medical['hr_verify_status'] == "") { //Block update if verified ?>
                                                    <li><a style="display: block" href="../view/v02_aims_medical_update.php?id=<? echo $medical['id'] ?>"><i class="fa fa-pencil opt-icon"></i>Update</a></li>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_medical_delete_exec.php?id=<? echo $medical["id"] ?>','Are you sure to delete medical claim application?')"
                                                           style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i>Delete</a></li>
                                                <?  } ?>
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


<div class="modal fade" id="medicalAttachment" tabindex="-1" role="dialog" aria-labelledby="viewMedicalAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewMedicalAttachmentLabel">Medical Claim Attachment</h4>
            </div>
            <div class="modal-body" id="viewAttachmentMedical">
                <script type="text/javascript">
                    $('#medicalAttachment').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_medical_attachment.php',
                            data:{id:id, edit:1},
                            success:function(html){
                                $('#viewAttachmentMedical').html(html);
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>