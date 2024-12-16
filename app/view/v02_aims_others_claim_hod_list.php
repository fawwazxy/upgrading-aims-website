<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";

$staff_id = $_SESSION['SESS_ID'];
$verification = ($_GET['verification'])?: 'PENDING';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
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
        th {
            text-align: center;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> HOD VERIFICATION
                    <a href="aims_others_claim_hod_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                    </select>
                </div>
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-3" style="margin-bottom: 8px">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </form>
        </div>

        <div class="tab">
            <a href="v02_aims_others_claim_hod_list.php?year=<? echo $year?>&verification=PENDING"
               class="tabLinks <? if($verification == "PENDING") echo 'active'?>">
                NEW </a>
            <a href="v02_aims_others_claim_hod_list.php?year=<? echo $year?>&verification=VERIFIED"
               class="tabLinks <? if($verification == "VERIFIED") echo 'active'?>">
                VERIFIED </a>
            <a href="v02_aims_others_claim_hod_list.php?year=<? echo $year?>&verification=REJECTED"
               class="tabLinks <? if($verification == "REJECTED") echo 'active'?>">
                REJECTED </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="../controller/v02_aims_others_claim_list_verify.php" enctype="multipart/form-data">
                            <input type="hidden" name="staff_id" value="<? echo $staff_id ?>">
                            <input type="hidden" name="month" value="<? echo $month ?>">
                            <input type="hidden" name="year" value="<? echo $year ?>">
                            <input type="hidden" name="verification" value="<? echo $verification ?>">

                            <input type="checkbox" id="select_all"/>&nbsp;
                            <label for="select_all" style="font-size: medium;margin-right: 8px">Select All</label>
                            <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="VERIFY" <? if ($verification=='VERIFIED') echo 'disabled' ?>/>
                            <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="REJECT" <? if ($verification=='REJECTED') echo 'disabled' ?>/>


                            <table style="width: 100%" id="dataTables-example" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width:4%;">#</th>
                                    <th style="width:50%;">Staff Info</th>
                                    <th>Month Claim</th>
                                    <th>Status</th>
                                    <th style="width:10%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? $claim_by_month = v02getMonthClaimListHOD($staff_id, $verification, $month, $year);
                                $i = 1;
                                while($month_claim = $claim_by_month->fetch_assoc()){
                                    $claim_count = v02getClaimListByStaff($month_claim['staff_id'], $month_claim['month_claim'],$verification);
                                    if ($verification == "PENDING") {
                                        $status_color = 'GREY';
                                    } else if ($verification == "VERIFIED") {
                                        $status_color = 'GREEN';
                                    }else{
                                        $status_color = 'RED';
                                    } ?>
                                    <tr>
                                        <td>
                                            <input class="checkbox" id="checkbox[]" name="checkbox[]" type="checkbox"
                                                   value="<? echo $month_claim['staff_id'].'#'.$month_claim['month_claim']; ?>">
                                            <label for="checkbox[]" style="margin: 0;"><? echo $i++; ?></label>
                                        </td>
                                        <td>
                                            <b>Name:</b> <?echo $month_claim['name'];?><br>
                                            <b>IC No:</b> <?echo $month_claim['noic'];?><br>
                                            <b>Position:</b> <?echo $month_claim['role_id'];?><br>
                                            <b>Department:</b> <?echo $month_claim['department_sub'];?><br>
                                            <b>Company:</b> <?echo $month_claim['department_id'];?>
                                        </td>
                                        <td class="text-center"><? echo $month_claim['month_claim']; ?></td>
                                        <td class="text-center">
                                            <p class="claim-status" style="background-color: <? echo $status_color; ?>">
                                                <? echo $verification.' ('.$claim_count.')'; ?>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <a href="v02_aims_others_claim_hod_approval.php?staff_id=<? echo $month_claim['staff_id']?>&month_claim=<? echo $month_claim['month_claim']?>&verification=<? echo $verification?>"
                                               target="_blank" class="btn btn-primary">CLAIM INFO</a></td>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [-1]
                // 0 = 1st column from left; -1 = 1st column from right
            }]
        });
    });
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
</script>
</body>
</html>



