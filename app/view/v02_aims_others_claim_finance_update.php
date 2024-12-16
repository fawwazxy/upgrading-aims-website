<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
session_start();
$ses_id = $_SESSION['SESS_ID'];
$id = $_GET['id'];
$staff_id = $_GET['staff_id'];
$month_claim = $_GET['month_claim'];
$suggested_month_claim = strtoupper(date('Y-m'));
$res = v02getDetailClaim($_GET['id'])->fetch_assoc();
$finance = v02getFinanceUse($id)->fetch_assoc();
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
    <style type="text/css">
        .claim-text{
            background-color:white;
            padding:8px;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> FINANCE
                    <a href="#" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>
                        Switch to Version 01
                    </a>
                    <a href="v02_aims_others_claim_finance_approval.php?staff_id=<? echo $res['staff_id']?>&month_claim=<? echo $res['month_claim']; ?>&verification=<?  echo ($res['finance_status'] == '1')? 'CHECKED' : 'UNCHECKED'?>&payment_status=<? echo ($res['payment_status'] == 'OPEN')? 'OPEN' : 'CLOSED'?>"
                       class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
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

        <div class="row" >
            <div class="col-sm-7">
                <form method="post" action="../controller/v02_aims_others_claim_finance_update_exec.php">
                    <input type="hidden" name="id" id="id" value="<? echo $id;?>">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <p class="claim-text" style="background-color: orange">Claim Details</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_no">Job No: <small class="text-muted">(optional)</small></label><br>
                                <input class="form-control" type="text" name="job_no" id="job_no" placeholder="Job Number"
                                       value="<? echo $res['job_no'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="head2">
                                    <label for="month_claim">Month Claim:</label><br>
                                    <input type="text" class="form-control" id="month_claim" name="month_claim"
                                           value="<? echo $res['month_claim']?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetime_departure">Departure:</label><br>
                                <input type="datetime-local" class="form-control" id="datetime_departure" name="datetime_departure"
                                       value="<? echo $res['datetime_departure'] ?>" readonly/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="datetime_arrival">Arrival:</label><br>
                                <input type="datetime-local" class="form-control" id="datetime_arrival" name="datetime_arrival"
                                       value="<? echo $res['datetime_arrival'] ?>" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Details Description:</label>
                                <textarea name="description" id="description" class="form-control" rows="5"
                                          readonly><? echo $res['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary" id="btnSubmit" onclick="return confirm('Confirm update form detail?')">SAVE CHANGES</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column -->
            <div class="col-sm-5">
                <div class="form-group row">
                    <div class="col-md-12">
                        <p class="claim-text" style="background-color: orange">Finance Use</p>
                        <form method="post" action="../controller/v02_aims_others_claim_finance_use_exec.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<? echo $id;?>">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><label for="advance">Advance</label></th>
                                    <td>
                                        <input class="form-control" type="number" step="0.01" name="advance"
                                               id="advance" value="<? echo $finance['advance']?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="expenditure">Less: Expenditure</label></th>
                                    <td>
                                        <input class="form-control" type="number" step="0.01" name="" id="expenditure"
                                               value="<? echo $res['total_claim']?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="refund">Refund</label></th>
                                    <td>
                                        <input class="form-control" type="number" step="0.01" name="refund"
                                               id="refund" value="<? echo $finance['refund']?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="outstanding">Outstanding</label></th>
                                    <td>
                                        <input class="form-control" type="number" step="0.01" name="outstanding"
                                               id="outstanding" value="<? echo $finance['outstanding']?>" required>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <? $check_status = [
                                        'color' => 'grey',
                                        'text' => 'PENDING',
                                   ];
                                if($res['finance_status'] == '1'){
                                    $check_status['color'] = 'green';
                                    $check_status['text'] = 'CHECKED';
                                }else if($res['finance_status'] == '0'){
                                    $check_status['color'] = 'red';
                                    $check_status['text'] = 'REJECTED';
                                }
                                ?>
                                <table style="width: 100%">
                                    <tr>
                                        <th class="text-left">
                                            Status: <span style="color: <? echo $check_status['color'] ?>">
                                                <? echo $check_status['text']; ?></span>
                                        </th>
                                        <td class="text-right">
                                            <button type="reset" class="btn btn-default" id="reset">RESET</button>
                                            <input type="submit" name="verification_status" class="btn btn-success" id="activate"
                                                   value="CHECK" onclick="return confirm('Confirm checked claim?')"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" colspan="2">
                                            <? if ($ses_id == '272'){ ?>
                                                <a class="btn btn-danger mt-2" href="#" data-toggle="modal" data-target="#returnModal"
                                                   id="#returnModal" data-id="<? echo $id; ?>" title="Return Claim to HR"><i class="fa fa-undo"></i> Return Claim</a>
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group row">
                    <div class="col-md-12">
                        <p class="claim-text" style="background-color: orange">Claim Cost Centre</p>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="3">Company: <? echo v02CompanyNameFromClaimId($res['id'])?>
                            </tr>
                            <tr style="background-color: lightgrey">
                                <th class="text-center">Cost Centre</th>
                                <th class="text-center">Type Claim</th>
                                <th class="text-center">RM</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $type_claim = v02getTypeClaimByClaimId($id);
                            while ($type = $type_claim->fetch_assoc()){
                                $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc();
                                ?>
                                <tr class="text-center">
                                    <td><? echo $desc['cost_centre'];?></td>
                                    <td><? echo $desc['description'];?></td>
                                    <td class="text-center">RM <?php echo $type['total']?></td>
                                    <td>
                                        <a href="#viewModal"
                                           id="clickToView" class="" data-toggle="modal" data-id="<? echo $type['id'];?>" data-get="<? echo $id?>"
                                           title=""><i class="fa fa-edit"></i></a>

                                        <a href="../controller/v02_aims_others_claim_cost_centre_delete_exec.php?id=<? echo $type['id'] ?>&claim_id=<? echo $id;?>" class="text-danger"
                                           title="Delete Selected Cost Centre" onclick="return confirm('Confirm delete cost centre?')"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                            <tfoot>
                            <tr class="text-center">
                                <td colspan="2" class="text-right" style="font-weight: bold">Total Claim</td>
                                <td>RM <? echo $res['total_claim'];?></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <p class="claim-text" style="background-color: orange">Attachment</p>
                <table style="width: 100%">
                    <tbody>
                    <? $attachment = v02getAttachment($id);
                    $extension = explode('.', $attachment);
                    $extension = end($extension); ?>
                    <tr>
                        <td style="width: 100%" class="text-center">
                            <? if(in_array($extension, ['jpg','JPG','jpeg','JPEG' ,'png','PNG','gif','GIF'])) { ?>
                                <img style="max-height:100vh;overflow-y: auto;" alt="attachment" class="img-responsive" width="auto" height="auto" src="<?php echo '../../othersclaimphoto/'.$attachment; ?>"/>
                            <? }else if($extension == 'pdf') { ?>
                                <iframe width="100%" height="1000" src="<?php echo '../../othersclaimphoto/'.$attachment; ?>" class="embed-responsive-item"></iframe>
                            <? }else{ ?>
                                <i class="text-muted">Attachment Not available</i>
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">UPDATE COST CENTRE</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <script>
                    $('#viewModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let getId = $(e.relatedTarget).data('get');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_list_finance_cc_modal.php',
                            data:{id:rowId,get_id:getId},
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

<!-- Modal Return Remarks -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">RETURN CLAIM FORM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="returnModal-body">
                <script type="text/javascript">
                    $('#returnModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_finance_return_remarks.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#returnModal-body').html(html);
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
        $('#advance').focusout(function (){
            let advance = $(this).val(),
                expenditure = $('#expenditure').val();

            let answer = advance - expenditure,
                refundValue = Math.max(0, answer),
                outstandingValue = Math.max(0, -answer);

            $(this).val(parseFloat(advance).toFixed(2));
            $('#refund').val(refundValue.toFixed(2));
            $('#outstanding').val(outstandingValue.toFixed(2));
        })
    });
</script>
</body>
</html>