<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
require "../model/lookup.php";

$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$role_id = $_SESSION['SESS_ROLE'];

$verification = ($_GET['verification'])?: 'UNCHECKED';
$payment_status = ($_GET['payment_status'])?:'OPEN';
$month=$_GET['month'] ?: 0;
$year= $_GET['year'] ?: date('Y');
$department_code = ($_GET['department_code'])?: '';
$review_status = $_GET['review'];
if($department_sub != 'FINACC' && $role_id != 'SUPERADMIN'){
    echo "<script type='text/javascript'>
            alert('This page is only for Finance & Account Department');
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> FINANCE CHECK
                    <a href="aims_otherclaim_financelist.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-bottom: 16px">
            <form method="get" action="">
                <input type="hidden" name="verification" id="verification" value="<? echo $verification?>">
                <input type="hidden" name="payment_status" id="payment_status" value="<? echo $payment_status?>">
                <div class="col-md-4">
                    <select class="form-control" id="department_code" name="department_code" required>
                        <option value="SB" <? if ($department_code == '') echo 'selected';?>>All Company</option>
                        <? echo getdropdown("department","code_department","description",$department_code);?>
                    </select>
                </div>
                <div class="col-md-2" style="margin-bottom: 8px">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-bottom: 8px">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </form>
        </div>

        <div class="tab">
            <a href="v02_aims_others_claim_finance_list.php?year=<? echo $year?>&department_code=<? echo $department_code;?>&verification=UNCHECKED&payment_status=OPEN"
               class="tabLinks <? if($verification == "UNCHECKED" && $payment_status == "OPEN") echo 'active'?>" title="Finance Status Unchecked">
                UNCHECKED </a>
            <a href="v02_aims_others_claim_finance_list.php?year=<? echo $year?>&department_code=<? echo $department_code;?>&verification=CHECKED&payment_status=OPEN"
               class="tabLinks <? if($verification == "CHECKED" && $payment_status == "OPEN") echo 'active'?>" title="Finance Status Checked">
                CHECKED </a>
            <a href="v02_aims_others_claim_finance_list.php?year=<? echo $year?>&department_code=<? echo $department_code;?>&verification=CHECKED&payment_status=CLOSED"
               class="tabLinks <? if($verification == "CHECKED" && $payment_status == "CLOSED") echo 'active'?>" title="Payment Status Closed">
                CLOSED </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No.</th>
                                <th class="text-center" style="width: 25%">Staff Info</th>
                                <th class="text-center" style="width: 20%">Month Claim</th>
                                <th class="text-center" style="width: 13%">HOD Status</th>
                                <th class="text-center" style="width: 13%">HR Status</th>
                                <th class="text-center" style="width: 13%">Finance Status</th>
                                <th class="text-center" style="width: 11%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $claim_by_month = v02getMonthClaimListFinance($department_code, $verification,$payment_status, $month, $year);
                            $i = 1;
                            while($month_claim = $claim_by_month->fetch_assoc()){
                                $finance_cc = v02getClaimListFinance($month_claim['staff_id'], $month_claim['month_claim'], $verification, $payment_status,$department_code);
                                if ($verification == "CHECKED") {
                                    $status_color = 'GREEN';
                                } else{
                                    $status_color = 'GREY';
                                }
                                if ($payment_status == 'CLOSED'){
                                    $payment_color = 'GREEN';
                                } else {
                                    $payment_color = 'RED';
                                }
                                ?>
                                <tr>
                                    <td><? echo $i++?></td>
                                    <td>
                                        <b>Name:</b> <?echo $month_claim['name'];?><br>
                                        <b>IC No:</b> <?echo $month_claim['noic'];?><br>
                                        <b>Position:</b> <?echo $month_claim['role_id'];?><br>
                                        <b>Department:</b> <?echo $month_claim['department_sub'];?><br>
                                        <b>Company:</b> <?echo $month_claim['department_id'];?>
                                    </td>
                                    <td class="text-center"><? echo $month_claim['month_claim']; ?></td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: GREEN">
                                            VERIFIED
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: GREEN">
                                            REVIEWED
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="claim-status" style="background-color: <? echo $status_color; ?>">
                                            <? echo $verification.' ('.$finance_cc.')'; ?>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank" href="v02_aims_others_claim_finance_approval.php?staff_id=<? echo $month_claim['staff_id']?>&month_claim=<? echo $month_claim['month_claim']?>&department_code=<? echo $department_code?>&verification=<? echo $verification?>&payment_status=<? echo $payment_status ?>"
                                           class="btn btn-sm btn-primary" title="Finance Action">ACTION</a>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            columnDefs: [{
                orderable: false,
                targets: [-1, -2, -3, -4]
            }]
        });
    });
</script>
</body>
</html>



