<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
$auth_id = $_SESSION['SESS_ID'];
$auth_name = $_SESSION['SESS_NAME'];

$staff_id = $_GET['staff_id'];
$verification = ($_GET['verification'])?: 'UNCHECKED';
$month_claim = $_GET['month_claim'];
$payment_status = ($_GET['payment_status'])?: 'OPEN';
$department_code = ($_GET['department_code'])?: '';
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> FINANCE CHECK
                    <a href="aims_claim_financeuse.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_others_claim_finance_list.php?department_code=SB&verification=<? echo $verification?>&payment_status=<? echo $payment_status?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
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
                            <th style="width: 15%">Staff Name</th>
                            <td style="width: 35%">: <? echo $staff['name']?></td>
                            <th>Department</th>
                            <td>: <? echo $staff['department_sub']?></td>
                        </tr>
                        <tr>
                            <th>IC Number</th>
                            <td>: <? echo $staff['noic'] ?></td>
                            <th style="width: 15%">Month Claim</th>
                            <td style="width: 35%">: <? echo $month_claim?></td>
                        </tr>
                        <tr>
                            <th>Payroll</th>
                            <td>: <? echo $staff['department_id']?></td>
                            <? if ($department_code != ''){ ?>
                                <th>Company Claim</th>
                                <td>: <? echo $department_code ?></td>
                            <? } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <form method="post" action="../controller/v02_aims_others_claim_check.php">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th style="width: 20%">Detail Description</th>
                                <th class="text-center" style="width: 10%">Total</th>
                                <th class="text-center">HOD</th>
                                <th class="text-center">HR</th>
                                <th class="text-center">Finance</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $total_cost=0.00;
                            $claim_list = v02getDetailStaffFinance($staff_id,$month_claim,$verification,$payment_status,$department_code);
                            while($claim = $claim_list->fetch_assoc()) {
                                //HOD status
                                if ($claim['verify_status'] == '1' && $claim['verify_by'] == 'AUTO VERIFIED'){
                                    $hod_text_status = 'NO SUPPORT NEEDS';
                                } else {
                                    $hod_text_status = 'VERIFIED';
                                }
                                // Finance Status -> CHECK / UNCHECKED
                                if($claim['finance_status']== '1') {
                                    $finance_text_color = 'GREEN';
                                    $finance_text_status = 'CHECKED';
                                } else {
                                    $finance_text_color = 'GREY';
                                    $finance_text_status = 'UNCHECKED';
                                }
                                ?>
                                <tr>
                                    <td>
                                        <? if ($payment_status == 'OPEN'){ ?>
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $claim['id']; ?>" style="margin: 0;" />&nbsp;
                                        <? } ?>
                                        <label for="checkbox[]" style="margin: 0;"><?php echo $i++.'.'; ?></label>
                                    </td>
                                    <td class="text-center">
                                        <? echo '<p class="claim-status" style="background-color: black">'.date('d/m/Y',strtotime($claim['created_at'])).'<br>'.date('l',strtotime($claim['created_at'])).'</p>'; ?>
                                    </td>
                                    <td>
                                        <? echo nl2br($claim['description']).'<br>'; ?>
                                        <? echo '<b>Departure:</b> '.$claim['datetime_departure'].'<br> <b>Arrival:</b> '.$claim['datetime_arrival'] ?>
                                        <? echo (empty($claim['remarks'])) ? '' :
                                            '<p class="claim-status" style="font-weight: bold;margin-top: 10px; color: black;background-color: lightgrey">REMARKS : <br>- '.nl2br($claim['remarks']).'</p>'
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?
                                        echo 'RM '.$claim['total_claim'];
                                        $tracking_color = ($payment_status == 'OPEN')?'grey':'green';
                                        if(!empty($claim['tracking_no'])){ ?>
                                            <hr>
                                            <b>Tracking No:</b>
                                            <p class="claim-status" style="background-color: <? echo $tracking_color ?>"><? echo $claim['tracking_no'] ?></p>
                                        <? } ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: green"><?php echo $hod_text_status; ?></p>
                                        <? echo ($claim['verify_by'] == 'AUTO VERIFIED')? '' :
                                            v02getStaffName($claim['verify_by']).'<br>'.$claim['verify_at'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: green">REVIEWED</p>
                                        <?
                                        echo ($claim['review_status'] == '1' || $claim['review_status'] == '0')?
                                            v02getStaffName($claim['review_by']).'<br>'.$claim['review_at'] : '';
                                        ?>
                                        <br><br>
                                        <p><b>Status:</b></p>
                                        <? echo ($claim['review_status'] == '1' && $claim['claim_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">CLOSED</p>'.$claim['claim_at'] :
                                            '<p class="claim-status" style="background-color: red;">OPEN</p>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?
                                        echo ($claim['finance_status']== '1' || $claim['finance_status'] == '0') ?
                                            '<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>'.v02getStaffName($claim['finance_by']).'<br>'.$claim['finance_at']
                                            :'<p class="claim-status" style="background-color: '.$finance_text_color.'">'.$finance_text_status.'</p>';
                                        ?>
                                        <br><br>
                                        <p><b>Payment:</b></p>
                                        <?
                                        echo ($claim['finance_status'] == '1' && $claim['payment_status'] == 'CLOSED') ?
                                            '<p class="claim-status" style="background-color: green">PAID</p>'.$claim['payment_at'].'<br>'
                                            :'<p class="claim-status" style="background-color: red;">UNPAID</p>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -64px">
                                                <? if ($claim['payment_status'] == 'OPEN'){ ?>
                                                    <? if ($claim['finance_status'] == '1'){?>
                                                        <li><!--<a style="display: block;color: #2ea000" href="#paidPayment" data-toggle="modal" data-id="<?/* echo $claim['id'];*/?>">
                                                                <i class="fa fa-print opt-icon"></i>Close Payment</a>-->
                                                            <a style="display: block;color: #2ea000" href="../controller/v02_aims_others_claim_finance_close_payment_exec.php?id=<? echo $claim['id']; ?>"><i class="fa fa-print opt-icon"></i>Close Payment</a>
                                                        </li>
                                                        <li><a style="display: block" href="v02_aims_others_claim_finance_update.php?id=<? echo $claim['id']; ?>&month_claim=<? echo $month_claim; ?>&staff_id=<? echo $staff_id; ?>">
                                                                <i class="fa fa-dollar opt-icon"></i>Re-calculate amount</a>
                                                        </li>
                                                    <? }else{ ?>
                                                        <li><a style="display: block;color: #2ea000" href="v02_aims_others_claim_finance_update.php?id=<? echo $claim['id']; ?>&month_claim=<? echo $month_claim; ?>&staff_id=<? echo $staff_id; ?>">
                                                                <i class="fa fa-arrow-right opt-icon"></i>Proceed</a>
                                                        </li>
                                                    <? }
                                                }else{ ?>
                                                    <li><a style="display: block" href="../controller/v02_aims_others_claim_finance_open_payment_exec.php?id=<? echo $claim['id'];?>"
                                                           onclick="return confirm('Confirm Open Payment?')">
                                                            <i class="fa fa-print opt-icon"></i>Open Payment</a></li>
                                                <? } ?>
                                                <li><a style="display: block" href="#viewDetail" data-toggle="modal" data-id="<? echo $claim['id'] ?>">
                                                        <i class="fa fa-eye opt-icon"></i>View</a></li>
                                                <? if ($claim['document_name'] != '') {?>
                                                    <li><a style="display: block" href="#claimAttachment" data-toggle="modal" data-id="<? echo $claim['id']; ?>">
                                                            <i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                <? } ?>
                                                <li><a style="display: block" href="../view/v02_aims_others_claim_print.php?id=<? echo $claim['id'] ?>" target="_blank">
                                                        <i class="fa fa-print opt-icon"></i>Print</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <? $total_cost+=$claim['total_claim'];
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="background-color:white;" colspan="3">
                                    CHECKED BY : <? echo $auth_name ?>
                                </th>
                                <th class="text-center" style="background-color:white;">
                                    <? echo 'RM '.number_format($total_cost, 2) ?>
                                </th>
                                <td style="background-color:white;" class="text-right" colspan="4">
                                    <? if ($payment_status != 'CLOSED'){ ?>
                                        <input type="checkbox" id="select_all"/>&nbsp;
                                        <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>
                                        <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="UNCHECK" <? if ($verification=='UNCHECKED') echo 'disabled' ?>/>
                                        <input type="hidden" name="auth_id" value="<? echo $auth_id ?>">
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
<!-- Modal Attachment -->

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

<!-- Modal Payment -->
<div class="modal fade" id="paidPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Tracking Number</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-payment">
                <script>
                    $('#paidPayment').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_tracking_modal.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#modal-payment').html(html);
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
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [2, -1, -2, -3, -4]
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

    function popitup(url) {
        newWindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newWindow.focus()}
        return false;
    }
</script>
</body>
</html>



