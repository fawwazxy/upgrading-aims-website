<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
require "../model/lookup.php";

$staff_id = $_SESSION['SESS_ID'];
$department_code=($_GET['department_code']) ?: '';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
$verification = ($_GET['verification'])?: 'PENDING';
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
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
        }

        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }
        /* Style the buttons inside the tab */
        .tab a {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 16px;
            text-decoration: none;
            color: #000000;
            border-radius: 5%;
        }
        /* Change background color of buttons on hover */
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }
        /* Create an active/current tablink class */
        .tab a.active {
            background-color: #FFA500;
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
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-bottom: 16px">
            <form method="GET" action="">
                <input type="hidden" name="verification" id="verification" value="<? echo $verification?>">
                <div class="col-md-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </SELECT>
                </div>
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <select required class="form-control" name="department_code" id="department_code">
                        <option value="SB" <? if ($department_code == '') echo 'selected';?>>All Company</option>
                        <? echo getdropdown("department","code_department","description",$department_code);?>
                    </select>
                </div>
                <div class="col-lg-3" style="margin-bottom: 8px">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </form>
        </div>

        <div class="tab">
            <a href="v02_aims_others_claim_ceo_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=PENDING"
               class="tabLinks <? if($verification == "PENDING") echo 'active'?>">
                NEW </a>
            <a href="v02_aims_others_claim_ceo_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=APPROVED"
               class="tabLinks <? if($verification == "APPROVED") echo 'active'?>">
                APPROVED </a>
            <a href="v02_aims_others_claim_ceo_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=DISAPPROVED"
               class="tabLinks <? if($verification == "DISAPPROVED") echo 'active'?>">
                DISAPPROVED </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="../controller/v02_aims_others_claim_list_approve.php" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="year" value="<? echo $year; ?>">
                            <input type="hidden" name="month" value="<? echo $month; ?>">
                            <input type="hidden" name="verification" value="<? echo $verification; ?>">
                            <input type="hidden" name="department_code" value="<? echo $department_code; ?>">
                            <!--Select All checkbox here -->
                            <input type="checkbox" id="select_all"/>&nbsp;
                            <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>
                            <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="APPROVE" <? if ($verification=='APPROVED') echo 'disabled' ?>/>
                            <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="DISAPPROVE" <? if ($verification=='DISAPPROVED') echo 'disabled' ?>/>
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th class="text-center" style="width: 30%">Staff Info</th>
                                    <th class="text-center" style="width: 15%">Month Claim</th>
                                    <th class="text-center" style="width: 10%">HOD</th>
                                    <th class="text-center" style="width: 10%">HR</th>
                                    <th class="text-center" style="width: 10%">Finance</th>
                                    <th class="text-center" style="width: 10%">EC/CEO</th>
                                    <th class="text-center" style="width: 10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $claim_by_month = v02getMonthClaimListCEO($department_code, $staff_id, $verification, $month, $year);
                                $i = 1;
                                $sum_claim=0;
                                while($month_claim = $claim_by_month->fetch_assoc()){
                                    if ($verification == "PENDING") {
                                        $status_color = 'GREY';
                                    } else if ($verification == "APPROVED") {
                                        $status_color = 'GREEN';
                                    }else{
                                        $status_color = 'RED';
                                    }
                                    $ceo_cc = v02claimListCeoVerification($month_claim['staff_id'], $month_claim['month_claim'], $verification);
                                    ?>
                                    <tr>
                                        <td>
                                            <input class="checkbox" id="checkbox[]" name="checkbox[]" type="checkbox"
                                                   value="<? echo $month_claim['staff_id'].'#'.$month_claim['month_claim']; ?>">
                                            <label for="checkbox[]" style="margin: 0;"><? echo $i++; ?></label>
                                        </td>
                                        <td>
                                            <b>Name:</b> <?echo $month_claim['name'];?><br>
                                            <b>IC No:</b> <?echo $month_claim['noic'];?><br>
                                            <b>Department:</b> <?echo $month_claim['department_sub'];?><br>
                                            <b>Company:</b> <?echo $month_claim['department_id'];?>
                                        </td>
                                        <td class="text-center">
                                            <? echo $month_claim['month_claim'];
                                            echo '<br><span class="claim-status" style="background-color: black; font-size: 20px">
                                                        RM '.$month_claim['total'].'</span>'; ?>

                                        </td>
                                        <td class="text-center">
                                            <p class="claim-status" style="background-color: green">VERIFIED</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="claim-status" style="background-color: green">REVIEWED</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="claim-status" style="background-color: green">CHECKED</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="claim-status" style="background-color: <? echo $status_color; ?>">
                                                <? echo $verification.' ('.$ceo_cc.')'; ?>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary" data-month="<? echo $month_claim['month_claim']?>" title="View detail popup"
                                               data-staff="<? echo $month_claim['staff_id']; ?>" data-toggle="modal" data-verification="<? echo $verification; ?>"
                                               href="#viewClaim" id="clickToViewDetail">
                                                <i class="fa fa-regular fa-exclamation-circle"></i>
                                            </a>
                                            <a class="btn btn-sm btn-success" target="_blank" title="Expand list"
                                               href="v02_aims_others_claim_ceo_approval.php?staff_id=<? echo $month_claim['staff_id'] ?>&month_claim=<? echo $month_claim['month_claim'] ?>&verification=<? echo $verification ?>">
                                                <i class="fa fa-regular fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <? $sum_claim+=$month_claim['total']; } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-center">
                                        <b>TOTAL (<? echo $i-1; ?>)</b><br>
                                        <span class="claim-status" style="background-color: #106600; font-size: 20px">
                                            <? echo 'RM'.number_format($sum_claim, 2, '.', ','); ?></span>
                                    </td>
                                    <td colspan="5"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>

    <!-- Modal View Detail -->
    <div class="modal fade" id="viewClaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">View Claim</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="modal-view">
                    <script>
                        $('#viewClaim').on('show.bs.modal', function (e) {
                            let staff = $(e.relatedTarget).data('staff');
                            let month = $(e.relatedTarget).data('month');
                            let verification = $(e.relatedTarget).data('verification');
                            $.ajax({
                                type:'POST',
                                url:'v02_aims_others_claim_ceo_list_modal.php',
                                data:{staff_id:staff,month_claim:month,verification:verification},
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
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [-1, -2, -3, -4, -5]
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



