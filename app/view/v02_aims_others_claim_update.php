<?php
session_start();
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
$id = $_GET['id'];
$auth_id = $_SESSION['SESS_ID'];
$res = v02getDetailClaim($id)->fetch_assoc();
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> UPDATE
                    <? if ($sess_dept_sub == 'HR') { ?>
                    <a href="aims_others_claim_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>
                        Switch to Version 01
                    </a>
                    <? } ?>
                    <? if (in_array($sess_dept_sub,['HR','HR-SEA'])){ ?>
                        <? $back_href = ($sess_dept_sub == 'HR')?'v02_aims_others_claim_hr_list.php':'v02_aims_others_claim_hr_sea_list.php'; ?>
                        <a href="<? echo $back_href; ?>" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                            <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                            Back to list
                        </a>
                    <? } ?>
            </div>
        </div>
        <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
        </div>
        <div class="row" >
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-weight: bold; font-size: 20px">Claim Form</span>
                    </div>
                    <div class="panel-body">
                        <?
                        if ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){
                            $notice = ($res['finance_status'] == '1') ? "THIS CLAIM HAS BEEN PROCEED BY FINANCE" : "";
                            $disabled = ($res['finance_status'] == '1'  ) ? "disabled" : "";
                        }else{
                            $notice = ($res['verify_status'] != '') ? "THIS CLAIM FORM HAS BEEN VERIFIED/REJECTED. PLEASE CONTACT HR FOR ANY CHANGES" : "";
                            $disabled = ($res['verify_status'] != '') ? "disabled" : "";
                        }

                        if ($notice != ""){ ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="claim-text" style="background-color: lightcoral; color: white">
                                        <b>NOTICE : </b><? echo $notice ?></p>
                                </div>
                            </div>
                        <? } ?>

                        <form method="post" action="../controller/v02_aims_others_claim_update_exec.php">
                            <input type="hidden" name="id" id="id" value="<? echo $id;?>">
                            <? if($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
                                <input type="hidden" name="auth_id" id="auth_id" value="<? echo $auth_id; ?>">
                            <? } ?>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div id="head2">
                                            <label for="month_claim">Claim For The Month Ended:</label>
                                            <select class="form-control" id='month_claim' name="month_claim" <? echo $disabled; ?>>
                                                <? echo v02getDropDownMonthClaimSelectedNew($res['month_claim']) ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="job_no">Job Number <span class="small text-muted">(optional)</span>:</label>
                                        <input class="form-control" type="text" name="job_no" id="job_no"
                                               placeholder="Job Number" value="<? echo $res['job_no'] ?>" <? echo $disabled?>>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="datetime_departure">Date Time Departure:</label>
                                        <input type="datetime-local" class="form-control" id="datetime_departure" name="datetime_departure"
                                               value="<? echo $res['datetime_departure'] ?>" <? echo $disabled; ?>/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="datetime_arrival">Date Time Arrival:</label>
                                        <input type="datetime-local" class="form-control" id="datetime_arrival" name="datetime_arrival"
                                               value="<? echo $res['datetime_arrival'] ?>" <? echo $disabled; ?>/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Details Description&nbsp;:</label>
                                        <textarea name="description" id="description" class="form-control" rows="5"
                                                <? echo $disabled?>><? echo $res['description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 col-md-offset-3 text-right">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary" id="btnSubmit" <? echo $disabled; ?>
                                            onclick="return confirm('Confirm update form detail?')">Update</button>
                                </div>
                            </div>
                        </form>

                        <h4 class="section-header">Cost Centre of Claim</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th colspan="<? echo ($res['retrieve'] != $res['total']) ? 4 : 3 ?>">
                                    Company : <? echo v02CompanyNameFromClaimId($res['id'])?></th>
                                <th>
                                    <? if (empty($disabled)){ ?>
                                        <a href="#addCostCentre" id="clickToView" class="btn btn-primary btn-block" data-toggle="modal"
                                                data-id="<? echo $id ?>">Add</a>
                                    <? } ?>
                                </th>
                            </tr>
                            <tr style="background-color: lightgrey">
                                <th class="text-center">Cost Centre</th>
                                <th class="text-center">Type Claim</th>
                                <th class="text-center">Total</th>
                                <? if ($res['retrieve'] != $res['total']){
                                    echo '<th class="text-center" title="This column refer to adjustment of type claim & total by HR">HR Amendment</th>';
                                } ?>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $type_claim = v02getTypeClaimByRetrieveClaimId($id);
                            while ($type = $type_claim->fetch_assoc()){
                                $retrieve = getTypeClaimDescription($type['retrieve_claim_id'])->fetch_assoc(); /*user type claim*/
                                $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc(); /*hr amendment*/
                                ?>
                                <tr class="text-center">
                                    <td><? echo $retrieve['cost_centre'];?></td>
                                    <td><? echo $retrieve['description'];?></td>
                                    <td class="text-center"><? echo ($type['retrieve_total'] == "")?'':'RM '.$type['retrieve_total'] ?></td>
                                    <? if ($res['retrieve'] != $res['total']){
                                        echo '<td>'.$desc['cost_centre'].' - '.$desc['description'].'<br><b> RM '.$type['total'].'</b></td>';
                                    } ?>
                                    <td>
                                        <? if (empty($disabled)){ ?>
                                            <a href="#viewModal" id="clickToView" class="" data-toggle="modal" title="" <? echo $disabled?>
                                               data-id="<? echo $type['id'];?>" data-claim="<? echo $id?>">
                                                <i class="fa fa-edit"></i></a>
                                            <a href="../controller/v02_aims_others_claim_cost_centre_delete_exec.php?id=<? echo $type['id'] ?>&claim_id=<? echo $id;?>"
                                               class="text-danger" title="Delete Selected Cost Centre" onclick="return confirm('Confirm delete cost centre?')">
                                                <i class="fa fa-remove"></i></a>
                                        <? } ?>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                            <tfoot>
                            <tr style="background-color: #cbc1c1">
                                <td colspan="2"></td>
                                <td class="text-center"><b><? echo 'RM '.$res['retrieve'];?></b></td>
                                <? if ($res['retrieve'] != $res['total'] || $res['company_cc_id'] != $res['retrieve_claim_id']){
                                    echo '<td class="text-center"> <b>RM '.$res['total'].'</b></td>';
                                } ?>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<!-- Update cost centre modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">UPDATE COST CENTRE</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <script type="text/javascript">
                    $('#viewModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let claimId = $(e.relatedTarget).data('claim');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_list_cc_modal.php',
                            data:{id:rowId,claim_id:claimId},
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

<!--Add New Cost Centre Modal-->
<div class="modal fade" id="addCostCentre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Add Cost Centre to Current Claim</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-body2">
                <script>
                    $('#addCostCentre').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let hr = 'no';
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_claim_add_cc_modal.php',
                            data:{id:rowId, hr:hr},
                            success:function(html){
                                $('#modal-body2').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
</body>
</html>