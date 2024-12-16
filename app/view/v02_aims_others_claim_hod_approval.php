<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

$staff_id_verify = $_SESSION['SESS_ID'];
$verified_name = $_SESSION['SESS_NAME'];
$verification = ($_GET['verification'])?: 'PENDING';
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
        .rm-badge{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
            background-color: green;
        }
        .claim-status{
            color:WHITE;
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
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
            <div class="col-lg-12">
                <h1 class="page-header">
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> VERIFICATION
                    <a href="aims_others_claim_hod_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_others_claim_hod_list.php?verification=<? echo $verification?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
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
                            <th style="width: 20%">MONTH CLAIM</th>
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
                <div class="panel-body">
                    <form name="formActive" method="post" action="../controller/v02_aims_others_claim_verify.php">
                        <table style="width: 100%" id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">Date</th>
                                <th style="width: 30%">Detail Description</th>
                                <th style="width: 20%">Type Claim</th>
                                <th style="width: 10%" class="text-center">Cost</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 10%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $total_cost=0.00;
                            $claim_list = v02getDetailStaff($staff_id, $month_claim, $verification);
                            while($claim = $claim_list->fetch_assoc()) {
                                if (empty($claim['verify_by']) && empty($claim['verify_at'])){
                                    $hod_text_color = 'GREY';
                                    $hod_text_status = 'PENDING';
                                }else{
                                    if ($claim['verify_status'] == '1'){
                                        $hod_text_color = 'GREEN';
                                        $hod_text_status = 'VERIFIED';
                                    }else{
                                        $hod_text_color = 'RED';
                                        $hod_text_status = 'REJECTED';
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $claim['id']; ?>" style="margin: 0;"/>&nbsp;
                                        <label for="checkbox[]" style="margin: 0;"><?php echo $i++.'.'; ?></label>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status text-dark" style="background-color: rgba(0,0,0,0.1)">
                                            <small class="text-muted">Applied at</small><br>
                                            <? echo $claim['created_at']; ?></p>
                                        <p class="claim-status text-dark bg-danger">
                                            <small class="text-muted">Departure</small><br>
                                            <? echo $claim['datetime_departure']; ?></p>
                                        <p class="claim-status text-dark bg-success">
                                            <small class="text-muted">Return</small><br>
                                            <? echo $claim['datetime_arrival']; ?></p>
                                    </td>
                                    <td>
                                        <p>
                                            <b>Job Number: </b>
                                            <? echo ($claim['job_no']) ?:'<i class="text-muted" style="font-size: 12px"> -- No Data --</i>'?>
                                        </p>
                                        <p><b>Description: </b><br>
                                            <? echo (empty($claim['description'])) ? '<i class="text-muted" style="font-size: 12px">No Description</i>' : nl2br($claim['description'])?>
                                        </p>
                                    </td>
                                    <td>
                                        <ul>
                                            <? $type_claim = v02getTypeClaimByClaimId($claim['id']);
                                            while ($type = $type_claim->fetch_assoc()){
                                                ?>
                                                <li><? echo '<b>'.$type['cost_centre'].'</b>:<br> '.$type['cc_description'].
                                                        ' <br><span class="rm-badge">RM'.$type['total'].'</span>'?></li>
                                            <? }?>
                                        </ul>
                                    </td>
                                    <td class="text-center"><? echo 'RM '.$claim['total_claim']?></td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <?php echo $hod_text_color?>;"><?php echo $hod_text_status; ?></p>
                                        <? echo v02getStaffName($claim['verify_by'])?>
                                        <? echo '<br>'. $claim['verify_at']?>
                                    </td>
                                    <td class="text-center">
                                        <? if($claim['document_name'] != '') { ?>
                                            <a class="btn btn-warning" href="#claimAttachment" data-toggle="modal" data-id="<? echo $claim['id']; ?>"
                                               title="View Attachment">View Attachment</a>
                                        <? } else {
                                            echo '<a href="" class="btn btn-warning" data-toggle="modal" data-id=""
                                               title="View Attachment" disabled="disabled"><i class="text-muted" style="font-size: 12px">No Attachment</i></a><br>';
                                        } ?>
                                        <? if ($claim['verify_status'] == '0'){ ?>
                                            <a href="#viewAddRemarks" style="margin-bottom: 8px; margin-top: 5px"
                                               id="clickToAddRemarks" class="btn btn-primary" data-toggle="modal" data-id="<? echo $claim['id'];?>"
                                               title="Add Remarks">Reject Reason</a>
                                        <? } ?>
                                    </td>
                                </tr>
                                <? $total_cost+=$claim['total_claim'];
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr style="background-color:lightgrey;">
                                <th colspan="9">VERIFIED BY : <? echo $verified_name ?></th>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-center"><? echo '<b> RM '.number_format($total_cost, 2).'</b>' ?></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td style="background-color:white;" class="text-right" colspan="9">
                                    <input type="checkbox" id="select_all"/>&nbsp;
                                    <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>
                                    <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="VERIFY" <? if ($verification=='VERIFIED') echo 'disabled' ?>/>
                                    <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="REJECT" <? if ($verification=='REJECTED') echo 'disabled' ?>/>
                                    <input type="hidden" name="staff_id_verify" value="<? echo $staff_id_verify ?>">
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

<!-- Modal Add Remarks -->
<div class="modal fade" id="viewAddRemarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle2" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle2" style="font-size: 120%">REJECT REASON</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-addRemarks">
                <script>
                    $('#viewAddRemarks').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_other_claim_remarks_modal.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#modal-addRemarks').html(html);
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
                targets: [3, 4, 5, -1]
                // 0 = 1st column from left; -1 = 1st column from right
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



