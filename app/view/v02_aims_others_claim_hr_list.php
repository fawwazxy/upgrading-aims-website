<?php
include "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
require "../model/lookup.php";

$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$role_id = $_SESSION['SESS_ROLE'];

$verification = ($_GET['verification'])?: 'PENDING';
$claim_status = ($_GET['claim_status'])?:'OPEN';
$month=$_GET['month'] ?: 0;
$year= $_GET['year'] ?: date('Y');
$department_code = ($_GET['department_code'])?: '';
$review_status = $_GET['review'];

if($department_sub != 'HR' && !in_array($role_id, ['FOUNDER', 'MANAGER', 'SUPERADMIN'])){
    echo "<script type='text/javascript'>
            alert('Bahagian ini hanya untuk kegunaan Human Resource Department sahaja');
            window.history.back();
            </script>";
    exit();
}
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
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> HR REVIEWAL
                    <a href="aims_others_claim_hr_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                <input type="hidden" name="claim_status" id="claim_status" value="<? echo $claim_status?>">
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-lg-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <select required class="form-control" name="department_code" id="department_code">
                        <option value="SB" <? if ($department_code == 'SB') echo 'selected';?>>ALL COMPANY</option>
                        <? echo getdropdown("department","code_department","description",$department_code);?>
                    </select>
                </div>
                <div class="col-lg-3" style="margin-bottom: 8px">
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="v02_aims_others_claim_hr_list.php?department_code=SB&verification=PENDING&payment_status=OPEN" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                </div>
            </form>
        </div>

        <div class="tab">
            <a href="v02_aims_others_claim_hr_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=PENDING&claim_status=OPEN"
               class="tabLinks <? if($verification == "PENDING" && $claim_status == "OPEN") echo 'active'?>">
                NEW </a>
            <a href="v02_aims_others_claim_hr_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=REVIEWED&claim_status=OPEN"
               class="tabLinks <? if($verification == "REVIEWED" && $claim_status == "OPEN") echo 'active'?>">
                REVIEWED</a>
            <a href="v02_aims_others_claim_hr_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=REJECTED&claim_status=OPEN"
               class="tabLinks <? if($verification == "REJECTED" && $claim_status == "OPEN") echo 'active'?>">
                REJECTED </a>
            <a href="v02_aims_others_claim_hr_list.php?year=<? echo $year?>&month=<? echo $month?>&department_code=<? echo $department_code;?>&verification=REVIEWED&claim_status=CLOSED"
               class="tabLinks <? if($verification == "REVIEWED" && $claim_status == "CLOSED") echo 'active'?>">
                CLOSED</a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table style="width: 100%;" id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 4%">#</th>
                                <th style="width: 25%">Staff Info</th>
                                <th style="width: 10%">Month Claim</th>
                                <th style="width: 13%">HOD Status</th>
                                <th style="width: 13%">HR Status</th>
                                <? if ($verification != 'PENDING'){
                                    ?>
                                    <th style="width: 13%">FINANCE Status</th>
                                    <th style="width: 13%">CEO/CHAIRMAN Status</th>
                                    <?
                                }?>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $claim_by_month = v02getMonthClaimListHR($department_code, $verification,$claim_status,$month, $year);
                            $i = 1;
                            while($month_claim = $claim_by_month->fetch_assoc()){
                                $count_total = v02getCountTotalByStaff($month_claim['staff_id'],$month_claim['month_claim']);
                                $claim_count = v02getClaimListHR($department_code, $month_claim['staff_id'], $month_claim['month_claim'], $verification);
                                $finance_cc = v02getClaimListHrFinance($month_claim['staff_id'], $month_claim['month_claim']);
                                $ceo_cc = v02getClaimListCEO($month_claim['staff_id'], $month_claim['month_claim']);

                                if ($verification == "PENDING") {
                                    $status_color = 'GREY';
                                } else if ($verification == "REVIEWED") {
                                    $status_color = 'GREEN';
                                }else {
                                    $status_color = 'RED';
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><? echo $i++?></td>
                                    <td>
                                        <b>Name:</b> <?echo $month_claim['name'];?><br>
                                        <b>IC No:</b> <?echo $month_claim['noic'];?><br>
                                        <b>Position:</b> <?echo $month_claim['role_id'];?><br>
                                        <b>Department:</b> <?echo $month_claim['department_sub'];?><br>
                                        <b>Company:</b> <?echo $month_claim['department_id'];?>
                                        <? if ($month_claim['finance_remarks'] != '' && $month_claim['review_status'] == '') { ?>
                                            <br><br>
                                            <div class="alert alert-danger">
                                                <p><span style="color: black; font-weight: bold">Remark Return Claim:</span> <? echo nl2br($month_claim['finance_remarks']); ?></p>
                                            </div>
                                        <? } ?>
                                    </td>
                                    <td class="text-center">
                                        <? echo $month_claim['month_claim']; ?>
                                    </td>

                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: GREEN">
                                            VERIFIED
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <? echo $status_color; ?>">
                                            <? echo $verification.' ( '.array_sum($claim_count).' / '.$count_total.' )'; ?>
                                        </p>
                                        <? if($verification == "REVIEWED"){
                                            if ($claim_status == "OPEN"){
                                                echo '<p class="claim-status" style="background-color: red">OPEN'.' ( '.$claim_count['OPEN'].' )</p>';
                                            }else{
                                                echo '<p class="claim-status" style="background-color: green">CLOSED'.' ( '.$claim_count['CLOSED'].' / '.$count_total.' )</p>';
                                            }
                                        }?>
                                    </td>
                                    <? if ($verification != 'PENDING'){ ?>
                                        <td class="text-center">
                                            <? echo ($finance_cc['pending'] != 0)? '<p class="claim-status" style="background-color: grey">PENDING ('.$finance_cc['pending'].')</p>':''?>
                                            <? echo ($finance_cc['checked'] != 0)? '<p class="claim-status" style="background-color: green">CHECKED ('.$finance_cc['checked'].')</p>':''?>
                                            <? echo ($finance_cc['closed'] != 0)? '<p class="claim-status" style="background-color: green">CLOSED ('.$finance_cc['closed'].')</p>':''?>
                                        </td>
                                        <td class="text-center">
                                            <? echo ($ceo_cc['pending'] != 0)? '<p class="claim-status" style="background-color: grey">PENDING ('.$ceo_cc['pending'].')</p>':''?>
                                            <? echo ($ceo_cc['approved'] != 0)? '<p class="claim-status" style="background-color: green">APPROVED ('.$ceo_cc['approved'].')</p>':''?>
                                            <? echo ($ceo_cc['rejected'] != 0)? '<p class="claim-status" style="background-color: red">REJECTED ('.$ceo_cc['rejected'].')</p>':''?>
                                        </td>
                                    <? } ?>
                                    <td class="text-center">
                                        <a target="_blank" href="v02_aims_others_claim_hr_approval.php?staff_id=<? echo $month_claim['staff_id']?>&department_code=<? echo $department_code;?>&month_claim=<? echo $month_claim['month_claim']?>&verification=<? echo $verification?>&claim_status=<? echo $claim_status ?>"
                                           class="btn btn-warning" title="HR Action">HR Action</a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            columnDefs: [{
                orderable: false,
                targets: [-1, -2, -3]
            }]
        });
    });
</script>
</body>
</html>



