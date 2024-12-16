<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
require "../model/lookup.php";

$verification = ($_GET['verification'])?: 'PENDING';
$department_code = ($_GET['department_code']) ?: '';
$staff_id = $_GET['staff_id'];
$month_claim = $_GET['month_claim'];
$staff = v02getStaffDetails($staff_id)->fetch_assoc();
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
        .claim-status{
            color:white;
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> APPROVAL
                    <a href="aims_others_claim_ceo_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_others_claim_ceo_list.php?department_code=<? echo $department_code?>&verification=<? echo $verification?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
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
                    <form method="post" action="../controller/v02_aims_others_claim_approve_exec.php">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Date</th>
                                <th style="width: 15%">Detail Description</th>
                                <th style="width: 10%" class="text-center">Total</th>
                                <th style="width: 12%" class="text-center">HOD</th>
                                <th style="width: 12%" class="text-center">HR</th>
                                <th style="width: 12%" class="text-center">Finance</th>
                                <th style="width: 12%" class="text-center">EC/CEO</th>
                                <th style="width: 12%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $total_cost=0.00;
                            $claim_list = v02getClaimDetailByStaffCeo($staff_id,$month_claim,$verification);
                            while($claim = $claim_list->fetch_assoc()) {
                                //HOD status -> VERIFIED / NO SUPPORT NEEDS
                                if ($claim['verify_status'] == '1' && $claim['verify_by'] == 'AUTO VERIFIED'){
                                    $hod_text_color = 'GREEN';
                                    $hod_text_status = 'NO SUPPORT NEEDS';
                                } else {
                                    $hod_text_color = 'GREEN';
                                    $hod_text_status = 'VERIFIED';
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
                                ?>
                                <tr>
                                    <td>
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $claim['id']; ?>" style="margin: 0;" />&nbsp;
                                        <label for="checkbox[]" style="margin: 0;"><?php echo $i++.'.'; ?></label>
                                    </td>
                                    <td>
                                        <small class="text-muted">Departure:</small><br>
                                        <b style="color: #870b00"><? echo date('d/m/Y h:i:sA', strtotime($claim['datetime_departure'])); ?></b><br>
                                        <small class="text-muted">Return:</small><br>
                                        <b style="color: #008701"><? echo date('d/m/Y h:i:sA', strtotime($claim['datetime_arrival'])); ?></b><br>
                                        <small class="text-muted">Applied on:</small><br>
                                        <b><? echo date('d/m/Y h:i:sA', strtotime($claim['created_at'])); ?></b>
                                    </td>
                                    <td>
                                        <? echo nl2br($claim['description']);
                                        echo (empty($claim['remarks'])) ? '' :
                                            '<p class="claim-status" style="font-weight: bold;margin-top: 10px; color: black;background-color: lightgrey">REMARKS : <br>- '.nl2br($claim['remarks']).'</p>'
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <? echo 'RM '.$claim['total_claim']?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hod_text_color?>;">
                                            <?php echo $hod_text_status; ?></p>
                                        <? echo ($claim['verify_by'] == 'AUTO VERIFIED')? '' :
                                            v02getStaffName($claim['verify_by']).'<br>'.$claim['verify_at']; ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: green">REVIEWED</p>
                                        <? echo ($claim['review_status'] == '1' || $claim['review_status'] == '0')?
                                            v02getStaffName($claim['review_by']).'<br>'.$claim['review_at'] : ''; ?>

                                        <p style="font-weight: bold; margin-top: 24px">Status:</p>
                                        <? echo ($claim['claim_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>'.v02getStaffName($claim['finance_by']).'<br>'.$claim['claim_at'] :
                                            '<p class="claim-status" style="background-color: red;">OPEN</p>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <? echo ($claim['finance_status']== '1' || $claim['finance_status'] == '0') ?
                                            '<p class="claim-status" style="background-color: green">CHECKED</p>'.v02getStaffName($claim['finance_by']).'<br>'.$claim['finance_at']
                                            :'<p class="claim-status" style="background-color: grey;">UNCHECKED</p>'; ?>

                                        <p style="font-weight: bold; margin-top: 24px">Payment:</p>
                                        <? echo ($claim['payment_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>'.v02getStaffName($claim['payment_by']).'<br>'.$claim['payment_at']
                                            :'<p class="claim-status" style="background-color: red;">OPEN</p>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $ceo_text_color?>"><?php echo $ceo_text_status;?></p>
                                        <? echo ($claim['approve_status'] == '1' || $claim['approve_status'] == '0') ?
                                            v02getStaffName($claim['approve_by']).'<br>'.$claim['approve_at'] : '';
                                        ?>
                                    </td>

                                    <td class="text-center">
                                        <a href="#viewDetail" id="clickToViewDetail" class="btn btn-primary" data-toggle="modal" data-id="<? echo $claim['id'];?>"
                                           title="View Claim" style="margin-left: 2px"><i class="fa fa-info-circle"></i></a>
                                        <? if ($claim['document_name'] != '') {?>
                                            <a class="btn btn-warning" href="#claimAttachment" data-toggle="modal" data-id="<? echo $claim['id'];?>"
                                               title="View Attachment"><i class="fa fa-file-picture-o"></i></a>
                                        <? } ?>
                                    </td>
                                </tr>
                                <? $total_cost+=$claim['total_claim'];
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td style="background-color:white;" colspan="3">
                                    <b>APPROVED BY : <? echo $_SESSION['SESS_NAME'] ?></b>
                                </td>

                                <td class="text-center" style="background-color:white;">
                                    <b>Total : <? echo '<br> RM '.number_format($total_cost, 2) ?></b>
                                </td>
                                <td style="background-color:white;" class="text-right" colspan="5">
                                    <input type="checkbox" id="select_all"/>&nbsp;
                                    <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>
                                    <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="APPROVE" <? if ($verification=='APPROVED') echo 'disabled' ?>/>
                                    <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="DISAPPROVE" <? if ($verification=='DISAPPROVED') echo 'disabled' ?>/>
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

<!-- Modal View Detail -->
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
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_view_modal.php',
                            data:{id:rowid},
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



