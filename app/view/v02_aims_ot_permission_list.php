<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'] ;
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_no = $_SESSION['SESS_NO_STAFF'];
$staff_company = $_SESSION['SESS_DEPARTMENT'];
$staff_department = $_SESSION['SESS_DEPARTMENT_SUB'];

$month = $_GET['month'] ?: 0;
$year = $_GET['year'] ?: date('Y');

if (in_array($staff_department, ["HR-AGMA", "OPERATION-AGMSB", "OPERATION-BUNKER"])) {
    echo "<script>
            alert('This form cannot be filled by HR-AGMA, OPERATION-AGMSB, AND OPERATION-BUNKER')
            window.history.back();
            </script>";
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <? require "../global/header.php"; ?>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> PERMISSION
                    <a href="aims_otpermission_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-lg-8">
                <table style="width: 100%">
                    <tr>
                        <th style="width: 14%">Name</th>
                        <th style="width: 2%">:</th>
                        <td><?php echo $staff_name; ?></td>
                    </tr>

                    <tr>
                        <th>IC No</th>
                        <th>:</th>
                        <td><?php echo $staff_ic; ?></td>
                    </tr>

                    <tr>
                        <th>Staff No</th>
                        <th>:</th>
                        <td><?php echo $staff_no; ?></td>
                    </tr>

                    <tr>
                        <th>Company</th>
                        <th>:</th>
                        <td><?php echo $staff_company; ?></td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <th>:</th>
                        <td><?php echo $staff_department; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row" style="margin: 16px 0">
            <form method="get" action="">
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-lg-3" style="margin-bottom: 8px">
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="v02_aims_ot_permission_list.php" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                </div>
            </form>
            <div class="col-lg-5">
                <a href="v02_aims_ot_permission_form.php" class="btn btn-primary" style="float: right; font-weight: bold; margin: 0 4px">New OT Permission</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Overtime Permission List</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Mode</th>
                                <th style="width: 10%">Date</th>
                                <th style="width: 20%">Approval</th>
                                <th style="width: 25%">Description</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Remark</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $ot = v02getOtPermissionList($staff_id,$year,$month);
                            $i=1;
                            while($otp = $ot->fetch_assoc()) {
                                $status_color = ""; $status_text = "";
                                if (empty($otp['approval_at'])){
                                    $status_color="text-secondary"; $status_text="PENDING";
                                }else{
                                    if ($otp['approval_status'] == '0'){
                                        $status_color="text-danger"; $status_text="DISAPPROVED";
                                    }
                                    else{
                                        $status_color="text-success"; $status_text="APPROVED";
                                    }
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++.'.'; ?></td>
                                    <td><?php echo getRateMode($otp['rate_mode']); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($otp['created_at'])); ?></td>
                                    <td><?php echo ($otp['approval_id'] == '0') ? "Auto-Approval" : getStaffName($otp['approval_id']) ; ?></td>
                                    <td><?php echo nl2br($otp['description']); ?></td>
                                    <td class="text-center">
                                        <p class="<? echo $status_color; ?>" style="font-weight:bold;"><? echo $status_text; ?></p>
                                        <p><? echo $otp['approval_at']; ?></p>
                                    </td>
                                    <td class="text-center"><?php echo $otp['remark']; ?></td>
                                    <td class="text-center">
                                        <div class="row">
                                            <? if (empty($otp['approval_at'])){ ?>
                                                <a href="#updateOTP" data-toggle="modal" data-id="<? echo $otp['id'];?>" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i>
                                                </a>
                                            <? }else{
                                                if ($otp['claim_status'] == 0 && $otp['approval_status'] == 1){?>
                                                    <a href="v02_aims_ot_form.php?otp_id=<? echo $otp['id']; ?>"
                                                       class="btn btn-sm btn-success" title="Claim your overtime">
                                                        <i class="fa fa-arrow-right"></i></a>
                                                <? }else if ($otp['claim_status'] == 1){ ?>
                                                    <span class="btn btn-default disabled" title="You have submitted Overtime Claim Application"
                                                       style="background-color: rgba(136,136,136,0.75);color: #ffffff; font-weight: bold; cursor: help">
                                                        Claimed <i class="fa fa-check-circle"></i></span>
                                                <? }
                                            } ?>

                                            <? if($otp['claim_status'] == 0){ ?>
                                                <a href="../controller/v02_aims_ot_permission_delete_exec.php?id=<? echo $otp['id']; ?>" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure you want to delete?');">
                                                    <i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i>
                                                </a>
                                            <? }?>
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
        <? include "../global/footer.php"; ?>
    </div>

    <div class="modal fade" id="updateOTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">EDIT OVERTIME PERMISSION</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#updateOTP').on('show.bs.modal', function (e) {
                            let rowid = $(e.relatedTarget).data('id');
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_ot_permission_update.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
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
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [2, 'desc']
            });
        });
    </script>
</div>
</body>
</html>