<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
$year = ($_GET['year'])?: date('Y');
$month = ($_GET['month'])?: '';
$company = ($_GET['company'])?: '0';
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
        .long-text {
            width: 500px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
            cursor: default;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> ANALYSIS <i class="fa fa-caret-right"></i> REPORT
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <blockquote class="migration-message bg-gradient-danger">
                <span class="blink-me" style="font-weight: bolder">
                    This page still under development
                </span>
                </blockquote>
            </div>
        </div>

        <div class="row">
            <form method="GET">
                <div class="col-md-1">
                    <select class="form-control" name="year" id="year">
                        <? echo getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="month" id="month">
                        <option value="">ALL MONTH</option>
                        <? $months = array("JANUARY", "FEBRUARY", "MARCH","APRIL","MAY","JUNE","JULY","AUGUST","SEPTEMBER","OCTOBER","NOVEMBER","DECEMBER");
                        for ($i = 0; $i < count($months); $i++) { ?>
                            <option value="<? echo $months[$i]; ?>" <? echo ($months[$i] == $month)?'selected':'' ?>><? echo $months[$i]; ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="company" name="company" required>
                        <option value="0" <? if ($company == '0') echo 'selected';?>>ALL COMPANY</option>
                        <? echo getCompanyDropdown($company); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a class="btn btn-default float-left" href="v02_aims_others_claim_analysis_report.php">Reset</a>
                </div>
            </form>
        </div>

        <div class="row" style="margin-top: 30px">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">LIST CLAIM REQUEST</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover w-100" id="dataTables-example">
                            <thead>
                            <tr>
                                <td style="width: 5%">#</td>
                                <th style="width: 12%">Date Applied</th>
                                <th style="width: 12%">Month Claim</th>
                                <th>Staff Info</th>
                                <!--<th style="width: 25%">Description</th>-->
                                <th  style="width: 10%">Amount (RM)</th>
                                <th style="width: 8%">Info</th>
                                <th style="width: 8%">Attachment</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $no = 1;
                            $total_amount = '';
                            $claim_list = getClaim($year, $month, $company);
                            while($claim = $claim_list->fetch_assoc()){
                                ?>

                                <tr>
                                    <td><? echo $no++; ?></td>
                                    <td><? echo $claim['created_at']; ?></td>
                                    <th><? echo $claim['month_claim']; ?></th>
                                    <td>
                                        <? echo $claim['name']. '<br>
                                    <small style="color: #808080; font-weight: bold">' .$claim['department_id'].' <br> '
                                            .$claim['department_sub'].'</small>'; ?>
                                    </td>
                                    <!--<td><p class="long-text" title="<?/* echo $claim['description']; */?>"><?/* echo $claim['description']; */?></p></td>-->
                                    <th class="text-center"><? echo $claim['total_claim']; ?></th>
                                    <td><a class="btn btn-info" style="display: block" href="#viewDetail" data-toggle="modal" data-id="<? echo $claim['id'] ?>">View</a></td>
                                    <td>
                                        <? if ($claim['document_name'] != '') {?>
                                            <a class="btn btn-warning" href="#claimAttachment" data-toggle="modal" data-id="<? echo $claim['id'];?>"
                                               title="View Attachment">Attachment</a>
                                        <? } else {
                                            echo '<p style="font-style: italic; font-size: 8pt; text-align: center;">No Attachment</p>';
                                        } ?>
                                    </td>
                                </tr>

                                <? $total_amount += $claim['total_claim']; } ?>

                            </tbody>
                            <tfoot class="bg-secondary">
                            <tr>
                                <td colspan="4"></td>
                                <th class="text-center"><? echo number_format($total_amount,2); ?></th>
                                <td colspan="2"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
            pageLength: 20,
            columnDefs: [{
                orderable: false,
                targets: [-1, -2, -3, -4]
            }]
        });
    });
</script>
</body>
</html>
