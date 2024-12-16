<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'] ;
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_no = $_SESSION['SESS_NO_STAFF'];
$staff_company = $_SESSION['SESS_DEPARTMENT'];
$staff_department = $_SESSION['SESS_DEPARTMENT_SUB'];


$month=$_GET['month'] ?: 0;
$year= $_GET['year'] ?: date('Y');
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
        .claim-status{
            padding: 2px 5px;
            border-radius: 5px;
            font-weight:bold;
            color: #FFFFFF;
        }
        .text-dark{
            color: #000000;
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
            <div class="col-md-12">
                <h1 class="page-header">
                    CLAIM <sub class="version">Version 02</sub>
                    <a href="aims_others_claim_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-md-11">
                <table style="width: 100%">
                    <tr>
                        <th style="width: 18%">Name</th>
                        <th style="width: 2%">:</th>
                        <td><?php echo $staff_name; ?></td>
                    </tr>

                    <tr>
                        <th>IC No</th>
                        <th>:</th>
                        <td><?php echo $staff_ic; ?></td>
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

                    <tr>
                        <th>Show information for the month claim</th>
                        <th>:</th>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px">
                                <select required class="form-control" name="month" id="month" onchange="filterForm.submit()">
                                    <? echo v02getDropDownMonth($month);?>
                                </select>
                                <select required class="form-control" name="year" id="year" onchange="filterForm.submit()">
                                    <? echo v02getDropDownYear($year);?>
                                </select>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-1 text-right">
                <a href="v02_aims_others_claim_form.php" class="btn btn-primary">Add New</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>List Others Claim</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead >
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th class="text-center" style="width: 10%">Date</th>
                                <th style="width: 20%;">Description</th>
                                <th class="text-center" style="width: 8%;">Total</th>
                                <th class="text-center">HOD</th>
                                <th class="text-center">HR</th>
                                <th class="text-center">Finance</th>
                                <th class="text-center">EC/CEO</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $claim = v02OthersClaim($staff_id, $month, $year);
                            $i=1;
                            while($list = $claim->fetch_assoc()) {
                                //HOD status -> PENDING / VERIFIED / UNVERIFIED
                                if (empty($list['verify_by']) && empty($list['verify_at'])){
                                    $hod_text_color = 'GREY';
                                    $hod_text_status = 'PENDING';
                                }else{
                                    if ($list['verify_status'] == '1' && $list['verify_by'] == 'AUTO VERIFIED'){
                                        $hod_text_color = 'GREEN';
                                        $hod_text_status = 'NO SUPPORT NEEDS';
                                    } elseif ($list['verify_status'] == '1'){
                                        $hod_text_color = 'GREEN';
                                        $hod_text_status = 'VERIFIED';
                                    }else{
                                        $hod_text_color = 'RED';
                                        $hod_text_status = 'REJECTED';
                                    }
                                }
                                //HR status -> PENDING / REVIEWED / DISAPPROVED
                                if (empty($list['review_by']) && empty($list['review_at'])){
                                    $hr_text_color = 'GREY';
                                    $hr_text_status = 'PENDING';
                                }else{
                                    if ($list['review_status'] == '1'){
                                        $hr_text_color = 'GREEN';
                                        $hr_text_status = 'REVIEWED';
                                    }else{
                                        $hr_text_color = 'RED';
                                        $hr_text_status = 'DISAPPROVED';
                                    }
                                }
                                //CEO status -> PENDING / APPROVE / DISAPPROVED
                                if (empty($list['approve_by']) && empty($list['approve_at'])){
                                    $ceo_text_color = 'GREY';
                                    $ceo_text_status = 'PENDING';
                                }else{
                                    if ($list['approve_status'] == '1'){
                                        $ceo_text_color = 'GREEN';
                                        $ceo_text_status = 'APPROVED';
                                    }else{
                                        $ceo_text_color = 'RED';
                                        $ceo_text_status = 'DISAPPROVED';
                                    }
                                }
                                // Finance Status -> CHECK / UNCHECKED
                                if($list['finance_status']== '1') {
                                    $finance_text_color = 'GREEN';
                                    $finance_text_status = 'CHECKED';
                                } else {
                                    $finance_text_color = 'GREY';
                                    $finance_text_status = 'UNCHECKED';
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="text-center">
                                        <p class="claim-status text-dark" style="background-color: rgba(0,0,0,0.1)">
                                            <small class="text-muted">Applied at</small><br>
                                            <? echo $list['created_at']; ?></p>
                                        <p class="claim-status text-dark bg-danger">
                                            <small class="text-muted">Departure</small><br>
                                            <? echo $list['datetime_departure']; ?></p>
                                        <p class="claim-status text-dark bg-success">
                                            <small class="text-muted">Return</small><br>
                                            <? echo $list['datetime_arrival']; ?></p>
                                    </td>
                                    <td>
                                        <? echo 'MONTH CLAIM: <b>'.$list['month_claim'].'</b><br><br>'?>
                                        <? echo nl2br($list['description']);?>
                                        <? echo (empty($list['remarks'])) ? '' :
                                            '<p class="claim-status" style="font-weight: bold;margin-top: 10px; color: black;background-color: lightgrey">REMARKS : <br>- '.$list['remarks'].'</p>'
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="">RM <? echo $list['total_claim'] ?></p>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hod_text_color?>"><?php echo $hod_text_status; ?></p>
                                        <? echo ($list['verify_by'] == 'AUTO VERIFIED')? '' :
                                            v02getStaffName($list['verify_by']).'<br>'.$list['verify_at']; ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hr_text_color?>"><?php echo $hr_text_status; ?></p>
                                        <? echo ($list['review_status'] == '1' || $list['review_status'] == '0')?
                                            v02getStaffName($list['review_by']).'<br>'.$list['review_at'] : ''; ?>
                                        <p style="font-weight: bold; margin-top: 24px">Status:</p>
                                        <? echo ($list['claim_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>'
                                                .v02getStaffName($list['claim_by']).'<br>'.$list['claim_at'] :
                                            '<p class="claim-status" style="background-color: red;">OPEN</p>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <? echo ($list['finance_status']== '1' || $list['finance_status'] == '0') ?
                                            '<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>'
                                            .v02getStaffName($list['finance_by']).'<br>'.$list['finance_at']
                                            :'<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>'; ?>
                                        <p style="font-weight: bold; margin-top: 24px">Payment:</p>
                                        <? echo ($list['payment_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>
                                            '.v02getStaffName($list['payment_by']).'<br>'.$list['payment_at']
                                            :'<p class="claim-status" style="background-color: red;">OPEN</p>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $ceo_text_color?>"><?php echo $ceo_text_status; ?></p>
                                        <? echo ($list['approve_status'] == '1' || $list['approve_status'] == '0')?
                                            v02getStaffName($list['approve_by']).'<br>'.$list['approve_at'] : ''; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -64px">
                                                <li><a style="display: block" href="#viewModal" data-toggle="modal" data-id="<? echo $list['id'] ?>">
                                                        <i class="fa fa-eye opt-icon"></i>View</a></li>
                                                <li><a style="display: block" href="#claimAttachment" data-toggle="modal" data-id="<? echo $list['id']; ?>">
                                                        <i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <li><a style="display: block" href="v02_aims_others_claim_update.php?id=<? echo $list['id']; ?>">
                                                        <i class="fa fa-pencil opt-icon"></i>Update</a></li>
                                                <? if ($list['review_status'] != '1'){ ?>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_others_claim_delete_exec.php?id=<? echo $list["id"] ?>')"
                                                           style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                <? } ?>
                                            </ul>
                                        </div>

                                        <!--<br>

                                        <a style="font-weight: bold; margin-bottom: 8px; margin-top: 5px" class="btn btn-block btn-warning" title="Print This Claim"
                                           onclick="return popitup('v02_aims_others_claim_report.php?id=<?/* echo $list_others_claim['id'];*/?>')">PRINT</a>-->
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

<!-- Modal View Detail -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">View Details</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <!--Modal Script-->
                <script type="text/javascript">
                    $('#viewModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_view_modal.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#modal-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="claimAttachment" tabindex="-1" role="dialog" aria-labelledby="viewClaimAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewClaimAttachmentLabel">Claim Attachment</h4>
            </div>
            <div class="modal-body" id="viewClaimAttachment">
                <script type="text/javascript">
                    $('#claimAttachment').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_attachment.php',
                            data:{id:id, edit:1},
                            success:function(html){
                                $('#viewClaimAttachment').html(html);
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
        $('#dataTables-example').DataTable({
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [2, -1, -2, -3, -4, -5]
            }]
        });
    });
</script>
</body>
</html>