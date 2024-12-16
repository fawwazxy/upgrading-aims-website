<?php
include "../controller/auth.php";
require "../model/lookup.php";
require "../model/v02_aims_ot_function.php";

if ($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR-SEA' && !in_array($_SESSION['SESS_ID'],['1','2','81'])) {
    echo "<script>
            alert('This section can only be accessed by person in charge for OVERTIME FORM verification/approval')
            window.history.back();
            </script>";
    exit();
}

$payment = ($_GET['payment']) ?: 'OPEN';
$review = ($_GET['review']) ?: 'NULL';
$company = ($_GET['company']) ?: 'AGSHIMSB';
$month = (isset($_GET['month'])) ? $_GET['month'] : date('m');
$year = $_GET['year'] ?: date('Y');
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
        /* Style the tab */
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

        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        .tab a.active {
            background-color: #FFA500;
        }

        .tabContent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .ot-status{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
        }

        .mb-8px{
            margin-bottom: 8px;
        }

        .text-center th{
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CLAIM
                    <i class="fa fa-caret-right"></i> HR-SEA REVIEW
                </h1>
            </div>
        </div>
        <div class="row" style="margin-bottom: 16px">
            <form action="" method="get">
                <div class="col-md-4">
                    <select required class="form-control" name="company" id="company">
                        <? echo getHRSeaCompany($company);?>
                    </select>
                </div>
                <input type="hidden" name="review" value="<? echo $review ?>">
                <input type="hidden" name="payment" value="<? echo $payment ?>">
                <div class="col-md-2">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Filter</button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="tab">
                        <a href="v02_aims_ot_hr_sea_list.php?company=<? echo $company;?>&review=NULL&payment=OPEN&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($review=="NULL" && $payment == "OPEN") echo 'active'?>">NEW </a>
                        <a href="v02_aims_ot_hr_sea_list.php?company=<? echo $company;?>&review=YES&payment=OPEN&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($review=="YES" && $payment == "OPEN") echo 'active'?>">REVIEWED </a>
                        <a href="v02_aims_ot_hr_sea_list.php?company=<? echo $company;?>&review=NO&payment=CLOSED&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($review=="NO" && $payment == "CLOSED") echo 'active'?>">REJECTED </a>
                        <a href="v02_aims_ot_hr_sea_list.php?company=<? echo $company;?>&review=YES&payment=CLOSED&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($review=="YES" && $payment == "CLOSED") echo 'active'?>">CLOSED </a>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 7%">No.</th>
                                <th style="width: 26%">Staff Info</th>
                                <th style="width: 10%">Month</th>
                                <th style="width: 13%">HOD</th>
                                <th style="width: 13%" class="text-center">HR</th>
                                <th style="width: 13%">EC / CEO</th>
                                <th style="width: 10%">Payment</th>
                                <th style="width: 8%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $month_listing = v02getOtHRReview($company, $month, $year);
                            while ($month = $month_listing->fetch_assoc()){
                                //run query for table ot & ot_date for every month session id
                                $count_status = v02countOtStatusFromMonthSessionID($month['id'], $review, $payment);

                                if ($count_status > 0){
                                    if ($review == 'NULL'){
                                        $review_text = "PENDING";
                                        $review_color = "GREY";
                                    }else if ($review == 'YES'){
                                        $review_text = "REVIEWED";
                                        $review_color = "GREEN";
                                    }else{
                                        $review_text = "REJECTED";
                                        $review_color = "RED";
                                    }

                                    $pending_count = 0;
                                    $approve_count = 0;
                                    $disapprove_count = 0;
                                    $count_total = v02countTotalOTFromMonthSessionID($month['id']);

                                    $ot_by_month = v02getOtApproval($month['id']);
                                    while ($row = $ot_by_month->fetch_assoc()){
                                        if (empty($row['approved_by']) && empty($row['approved_at'])){
                                            $pending_count++;
                                        }else{
                                            if ($row['approved_status'] == '1'){
                                                $approve_count++;
                                            }else{
                                                $disapprove_count++;
                                            }
                                        }
                                    }?>
                                    <tr class="text-center">
                                        <td><?echo $i++;?></td>
                                        <td class="text-left">
                                            <b>Name:</b> <?echo $month['name'];?><br>
                                            <b>IC No:</b> <?echo $month['noic'];?><br>
                                            <b>Staff No:</b> <?echo $month['no_staff'];?><br>
                                            <b>Department:</b> <?echo $month['department_sub'];?><br>
                                            <b>Company:</b> <?echo $month['department_id'];?>
                                        </td>
                                        <td>
                                            <? echo $month['month_session']?>
                                            <!-- Show row count for each status -->
                                            <p class="ot-status" style="background-color: #000000; margin-top: 16px">OT Count:<br><? echo $count_status.' / '.$count_total?></p>
                                        </td>
                                        <td><p class="ot-status" style="background-color:GREEN;">VERIFIED</p></td>
                                        <td>
                                            <p class="ot-status" style="background-color: <? echo $review_color ?>">
                                                <? echo $review_text;?>
                                            </p>
                                        </td>
                                        <td>
                                            <? if ($review == 'NULL'){
                                                echo '<p class="ot-status mb-8px" style="background-color:GREY">PENDING</p>';
                                            }else{
                                                echo ($pending_count>0) ? '<p class="ot-status mb-8px" style="background-color:GREY">PENDING ('.$pending_count.')</p>' : '';
                                                echo ($approve_count>0) ? '<p class="ot-status mb-8px" style="background-color:GREEN">APPROVED ('.$approve_count.')</p>' : '';
                                                echo ($disapprove_count>0) ? '<p class="ot-status mb-8px" style="background-color:RED">DISAPPROVED ('.$disapprove_count.')</p>' : '';
                                            } ?>
                                        </td>
                                        <td>
                                            <p class="ot-status" style="background-color:<? echo ($payment == 'OPEN') ? 'RED' : 'GREEN';?>;">
                                                <? echo $payment ?></p>
                                        </td>
                                        <td>
                                            <? if ($payment != 'CLOSE') {?>
                                                <a href="v02_aims_ot_hr_update_form.php?id=<? echo $month['id'];?>" class="btn btn-sm btn-block btn-warning"
                                                   style="font-weight: bold;">HR ACTION</a>
                                            <?}?>

                                            <a href="v02_aims_ot_print.php?id=<? echo $month['id'];?>" class="btn btn-sm btn-block btn-success" target="_blank"
                                               style="font-weight: bold;">PRINT &nbsp;<i class="fa fa-print"></i></a>

                                            <? if ($review == 'YES' && $payment == 'OPEN') {?>
                                                <a href="../controller/v02_aims_ot_hr_close_exec.php?id=<? echo $month['id'];?>" style="font-weight: bold;"
                                                   class="btn btn-sm btn-block btn-success <? echo ($approve_count >= $count_status) ? '' : 'disabled'?>"
                                                   onclick="return confirm('Confirm Close payment? Action cannot be undone..')">CLOSE</a>
                                            <?}?>
                                        </td>
                                    </tr>
                                <? }
                            } ?>
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
            responsive: true
        });
    });
</script>
</body>
</html>