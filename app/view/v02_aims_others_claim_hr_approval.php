<?php
session_start();
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

$sess_id = $_SESSION['SESS_ID'];
$sess_dept_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

$staff_id = $_GET['staff_id'];
$month_claim = $_GET['month_claim'];
$claim_status = ($_GET['claim_status'])?:'OPEN';
$verification = ($_GET['verification'])?: 'PENDING';
$department_code = ($_GET['department_code'])?: '';
$staff = v02getStaffDetails($staff_id)->fetch_assoc();

$back_href = ($sess_dept_sub == 'HR')?'v02_aims_others_claim_hr_list.php':'v02_aims_others_claim_hr_sea_list.php';
$page_name = ($sess_dept_sub == 'HR')?'HR':'HR-SEA';
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
            color:WHITE;
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> <? echo $page_name; ?> REVIEWAL
                    <? if ($sess_dept_sub == 'HR') { ?>
                    <a href="aims_others_claim_hr_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <? } ?>
                    <a href="<? echo $back_href; ?>?department_code=<? echo $department_code?>&verification=<? echo $verification?>&claim_status=<? echo $claim_status?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-heading">
                    <table style="width: 100%">
                        <tr>
                            <th style="width: 15%">STAFF NAME</th>
                            <td style="width: 35%">: <? echo $staff['name']?></td>
                            <th style="width: 20%">CLAIM FOR THE MONTH ENDED</th>
                            <td style="width: 30%">: <? echo $month_claim?></td>
                        </tr>
                        <tr>
                            <th>IC</th>
                            <td>: <? echo $staff['noic'] ?></td>
                            <th>ROLE</th>
                            <td>: <? echo $staff['role_id']?></td>
                        </tr>
                        <tr>
                            <th>DEPARTMENT</th>
                            <td>: <? echo $staff['department_sub']?></td>
                            <th>COMPANY</th>
                            <td>: <? echo $staff['department_id']?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body" style="overflow: auto">
                    <form name="" method="post" action="../controller/v02_aims_others_claim_review.php">
                        <table style="width: 100%" id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Detail Description</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">HOD</th>
                                <th class="text-center">HR</th>
                                <th class="text-center">Finance</th>
                                <th class="text-center">EC/CEO</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $total_cost=0.00;
                            $claim_list = v02getDetailStaffHR($department_code,$staff_id,$month_claim,$verification,$claim_status);
                            while($claim = $claim_list->fetch_assoc()) {
                                //Claim status
                                if($claim['claim_status'] == 'OPEN'){
                                    $link_action = 'CLOSED';
                                    $link_color = 'GREEN';
                                }else{
                                    $link_action = 'OPEN';
                                    $link_color = 'RED';
                                }

                                //HOD status -> PENDING / VERIFIED / UNVERIFIED
                                if (empty($claim['verify_by']) && empty($claim['verify_at'])){
                                    $hod_text_color = 'GREY';
                                    $hod_text_status = 'PENDING';
                                }else{
                                    if ($claim['verify_status'] == '1' && $claim['verify_by'] == 'AUTO VERIFIED'){
                                        $hod_text_color = 'GREEN';
                                        $hod_text_status = 'NO SUPPORT NEEDS';
                                    } elseif ($claim['verify_status'] == '1' ){
                                        $hod_text_color = 'GREEN';
                                        $hod_text_status = 'VERIFIED';
                                    }else{
                                        $hod_text_color = 'RED';
                                        $hod_text_status = 'REJECTED';
                                    }
                                }

                                //HR status
                                if (empty($claim['review_by']) && empty($claim['review_at'])){
                                    $hr_text_color = 'GREY';
                                    $hr_text_status = 'PENDING';
                                }else{
                                    if ($claim['review_status'] == '1'){
                                        $hr_text_color = 'GREEN';
                                        $hr_text_status = 'REVIEWED';
                                    }else{
                                        $hr_text_color = 'RED';
                                        $hr_text_status = 'DISAPPROVED';
                                    }
                                }

                                //CEO status
                                if (empty($claim['approve_by']) && empty($claim['approve_at'])){
                                    $ceo_text_color = 'GREY';
                                    $ceo_text_status = 'PENDING';
                                }else{
                                    if ($claim['approve_status'] == '1'){
                                        $ceo_text_color = 'GREEN';
                                        $ceo_text_status = 'APPROVED';
                                    }else{
                                        $ceo_text_color = 'RED';
                                        $ceo_text_status = 'DISAPPROVED';
                                    }
                                }

                                // Finance Status -> CHECK / UNCHECKED
                                if($claim['finance_status']== '1') {
                                    $finance_text_color = 'GREEN';
                                    $finance_text_status = 'CHECKED';
                                } else {
                                    $finance_text_color = 'GREY';
                                    $finance_text_status = 'UNCHECKED';
                                }

                                // Payment Status -> PAID / UNPAID
                                if (empty($claim['payment_status']) && empty($claim['payment_at'])){
                                    $payment_text_color = 'RED';
                                    $payment_text_status = 'UNPAID';
                                }else{
                                    if ($claim['payment_status'] == 'CLOSED'){
                                        $payment_text_color = 'GREEN';
                                        $payment_text_status = 'PAID';
                                    }else{
                                        $payment_text_color = 'RED';
                                        $payment_text_status = 'UNPAID';
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?
                                        if ($claim_status == 'CLOSED'){
                                            ?>
                                            <label style="margin: 0;"><?php echo $i++.'.'; ?></label>
                                            <?
                                        } else {
                                            ?>
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $claim['id']; ?>" style="margin: 0;" />&nbsp;
                                            <label for="checkbox[]" style="margin: 0;"><?php echo $i++.'.'; ?></label>
                                            <?
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <span style="display: none;"><? echo date('d/m/Y',strtotime($claim['created_at'])) ?></span>
                                        <?
                                        echo '<p class="claim-status" style="background-color: black">'.date('d/m/Y',strtotime($claim['created_at'])).'<br>'.date('l',strtotime($claim['created_at'])).'</p>';
                                        ?>
                                    </td>
                                    <td>
                                        <p><? echo (empty($claim['description'])) ? '<i class="text-muted" style="font-size: 12px">No Description</i>' : nl2br($claim['description'])?></p>
                                        <b>Departure: </b><? echo $claim['datetime_departure']<>'0000-00-00 00:00:00' ? $claim['datetime_departure'] : '<i class="text-muted" style="font-size: 12px">-- No Data --</i>';?><br>
                                        <b>Arrival: </b><? echo $claim['datetime_arrival']<>'0000-00-00 00:00:00' ? $claim['datetime_arrival'] : '<i class="text-muted" style="font-size: 12px">-- No Data --</i>';?>
                                        <? echo (empty($claim['remarks'])) ? '' :
                                            '<p class="claim-status" style="font-weight: bold;margin-top: 10px; color: black;background-color: lightgrey">REMARK: <br>- '.nl2br($claim['remarks']).'</p>'
                                        ?>
                                        <? if ($claim['finance_remarks'] != '' && $claim['review_status'] == '') { ?>
                                            <br><br>
                                            <div class="alert alert-danger">
                                                <p><span style="color: black; font-weight: bold">Remark Return Claim:</span> <? echo nl2br($claim['finance_remarks']); ?></p>
                                            </div>
                                        <? } ?>
                                        <? if ($claim['tracking_no']){
                                           echo '<br><br><p class="claim-status" style="background-color: #d9a264"><b>Tracking No:</b> ' .$claim['tracking_no'].'</p>';
                                        }?>
                                    </td>
                                    <td class="text-center">
                                        <? echo 'RM '.$claim['total_claim']?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hod_text_color?>;"><?php echo $hod_text_status; ?></p>
                                        <?
                                        echo ($claim['verify_by'] == 'AUTO VERIFIED')? '' :
                                            v02getStaffName($claim['verify_by']).'<br>'.$claim['verify_at'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hr_text_color?>"><?php echo $hr_text_status; ?></p>
                                        <?
                                        echo ($claim['review_status'] == '1' || $claim['review_status'] == '0')?
                                            v02getStaffName($claim['review_by']).'<br>'.$claim['review_at'] : '';
                                        ?>
                                        <br><br>
                                        <p><b>Status:</b></p>
                                        <? echo ($claim['review_status'] == '1' && $claim['claim_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>'
                                            .v02getStaffName($claim['claim_by']).'<br>'.$claim['claim_at'] :
                                            '<p class="claim-status" style="background-color: red;">OPEN</p>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?
                                        echo ($claim['finance_status']== '1') ?
                                            '<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>'
                                            .v02getStaffName($claim['finance_by']).'<br>'.$claim['finance_at']
                                            :'<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>';
                                        ?>
                                        <br><br>
                                        <p><b>Payment:</b></p>
                                        <?
                                        echo ($claim['finance_status'] == '1' && $claim['payment_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: '.$payment_text_color.'"> '.$payment_text_status.'</p>'.$claim['payment_at']
                                            :'<p class="claim-status" style="background-color: '.$payment_text_color. ';">UNPAID</p>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $ceo_text_color?>"><?php echo $ceo_text_status;?></p>
                                        <?
                                        echo ($claim['approve_status'] == '1' || $claim['approve_status'] == '0')?
                                            v02getStaffName($claim['approve_by']).'<br>'.$claim['approve_at'] : '';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -64px">
                                                <? if ($claim['verify_status'] == '1' && $claim['review_status'] == '1'){ ?>
                                                    <li><a href="../controller/v02_aims_others_claim_hr_close_or_open_claim_exec.php?id=<? echo $claim['id'];?>&action=<? echo $link_action ?>"
                                                           style="display: block; color: <? echo $link_color ?>;" class="text-capitalize" title="Close/Open Claim Status" onclick="return confirm('Confirm Close the Claim Status?')">
                                                            <i class="fa fa-lock opt-icon"></i> <? echo strtolower(str_replace('D','',$link_action)) ?></a>
                                                <? } ?>
                                                <li><a style="display: block" href="#viewDetail" data-toggle="modal" data-id="<? echo $claim['id'] ?>">
                                                        <i class="fa fa-eye opt-icon"></i>View</a></li>
                                                <li><a style="display: block" href="#claimAttachment" data-toggle="modal" data-id="<? echo $claim['id']; ?>">
                                                        <i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <li><a style="display: block" href="v02_aims_others_claim_update.php?id=<? echo $claim['id']; ?>" target="_blank">
                                                        <i class="fa fa-edit opt-icon"></i>Update</a></li>

                                                <li><a style="display: block" data-id="<? echo $claim['id'];?>"
                                                       data-toggle="modal" href="#trackingNo"
                                                       id="clickToViewDetail"><i class="fa fa-paper-plane opt-icon"></i>Tracking No</a></li>

                                                <? if (empty($claim['remarks'])){ ?>
                                                    <li><a style="display: block" href="#viewAddRemark" data-toggle="modal" data-id="<? echo $claim['id'];?>">
                                                            <i class="fa fa-plus opt-icon"></i>Add Remark</a></li>
                                                <? }else{ ?>
                                                    <li><a style="display: block; color: #d70000" href="../controller/v02_aims_others_claim_hr_delete_remarks_exec.php?id=<? echo $claim['id'];?>"
                                                           onclick="return confirm('Confirm Delete Remark?')">
                                                            <i class="fa fa-trash opt-icon"></i>Delete Remark</a></li>
                                                <? }

                                                if ($claim['finance_status'] == '1' || $claim['payment_status'] == 'CLOSED'){ ?>
                                                    <li><a onclick="confirmDel('../controller/v02_aims_others_claim_delete_exec.php?id=<? echo $claim["id"] ?>')"
                                                           style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                <? } ?>
                                                <li><a style="display: block" target="_blank" href="../view/v02_aims_others_claim_print.php?id=<? echo $claim['id'] ?>&orientation=landscape">
                                                        <i class="fa fa-print opt-icon"></i> Print</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <? $total_cost+=$claim['total_claim'];
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td style="background-color:white;" colspan="3">
                                    <b>REVIEWED BY: <? echo $_SESSION['SESS_NAME'] ?></b>
                                </td>

                                <td class="text-center" style="background-color:white;">
                                    <b>Total : <? echo '<br> RM '.number_format($total_cost, 2) ?></b>
                                </td>
                                <td style="background-color:white;" class="text-right" colspan="5">
                                    <? if ($claim_status != 'CLOSED'){ ?>
                                        <input type="checkbox" id="select_all"/>&nbsp;
                                        <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>
                                        <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="REVIEW" <? if ($verification=='REVIEWED') echo 'disabled' ?>/>
                                        <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="REJECT" <? if ($verification=='REJECTED') echo 'disabled' ?>/>
                                    <? } ?>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">View Details</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-view">
                <script>
                    $('#viewDetail').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_view_modal.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#modal-view').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Remark -->
<div class="modal fade" id="viewAddRemark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle2" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle2" style="font-size: 120%">ADD REMARK</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-addRemark">
                <script>
                    $('#viewAddRemark').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_remarks_modal.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#modal-addRemark').html(html);
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

<div class="modal fade" id="trackingNo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Tracking Number Form</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-tracking">
                <script>
                    $('#trackingNo').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_tracking_view_modal.php',
                            data:{id:id},
                            success:function(html){
                                $('#modal-tracking').html(html);
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
        $('#dataTables-example').DataTable({
            columnDefs: [{
                orderable: false,
                targets: [2, -1, -2, -3, -4, -5]
            }]
        });
    });

    // all checkbox checked if select all is checked
    $('#select_all').on('click',function(){
        $('input[class="checkbox"]').prop('checked', this.checked);
    });

    // select all checked if all checkbox checked
    $('.checkbox').on('click',function(){
        $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
    });
</script>
</body>
</html>



