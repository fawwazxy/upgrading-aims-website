<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$plate_no = ($_GET['plate_no'])?:'XX 8848';
$bdaymonth=($_GET['bdaymonth'])?:date('Y-m');
$status=($_GET['status'])?:'';
$app_status=($_GET['app_status'])?:'APPROVE';

$sys = getSys(1)->fetch_assoc();
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
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Transport Request Month Report</h1>
            </div>
        </div>

        <div class="row">
            <div style="padding-left:20px">
                <div class="row">
                    <form method="get" action="">
                        <div class="col-lg-2">
                            <input class="form-control" type="month" id="bdaymonth" name="bdaymonth" value="<? echo $bdaymonth; ?>">
                        </div>
                        <div class="col-lg-3" >
                            <select  required class="form-control" name="plate_no" id="plate_no">
                                <? echo getDropDownCarName($plate_no) ;?>
                            </select>
                        </div>
                        <div class="col-lg-1" >
                            <select  required class="form-control" name="status" id="status">
                                <option value="daily" <? if($status == 'daily') echo 'selected'; ?>>DAILY</option>
                                <option value="travel" <? if($status == 'travel') echo 'selected'; ?>>TRAVEL</option>
                            </select>
                        </div>
                        <div class="col-lg-2" >
                            <select  required class="form-control" name="app_status" id="app_status">
                                <option value="APPROVE" <? if($app_status == 'APPROVE') echo 'selected'; ?>>APPROVE</option>
                                <option value="DISAPPROVE" <? if($app_status == 'DISAPPROVE') echo 'selected'; ?>>DISAPPROVE</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-info">Search</button>
                            <a href="aims_carReserve_report.php" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                            <input type="submit" formtarget="_blank" formaction="../view/aims_carReserve_report_print.php" class="btn btn-warning" value="Print">
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Request List</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Applicant Name</th>
                                <th>Purpose</th>
                                <th>Destination</th>
                                <th>Reject Reason</th>
                                <th>Plate Number</th>
                                <th>Departure Milage</th>
                                <th>Return Milage</th>
                                <th>Duration</th>
                                <th>Inspection</th>
                                <th>Status of summon</th>
                                <th>Health Status & illness</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $car = getcarRequestList3($app_status,$bdaymonth,$_SESSION['SESS_NAME'],$status,$plate_no);
                            $i=1;
                            while($list_car = $car->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-center"><? echo $i++;?></td>
                                    <td class="text-center"><? echo $list_car['dep_date']; ?></td>
                                    <td class="text-center"><? echo $list_car['name']; ?></td>
                                    <td class="text-center"><? echo $list_car['purpose']; ?></td>
                                    <td class="text-center"><? echo $list_car['destination']; ?></td>
                                    <td class="text-center"><? echo $list_car['reason']; ?></td>
                                    <td class="text-center"><? echo $list_car['car_plate_no']; ?></td>
                                    <td class="text-center"><? echo $list_car['dep_milage']; ?></td>
                                    <td class="text-center"><? echo $list_car['return_milage']; ?></td>
                                    <td class="text-center"><? echo $list_car['dep_date']; ?> - <? echo $list_car['return_date']; ?></td>
                                    <td class="text-center"><? echo $list_car['status_incep']; ?></td>
                                    <td class="text-center"><? echo ($list_car['summon_status']) ?: "-"; ?></td>
                                    <td class="text-center">
                                        <?
                                        echo strtoupper(str_replace('_', ' ', $list_car['health_status']));
                                        echo '<p>'.$list_car['illness'].'</p>'; ?>
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>


    <script>

        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

    </script>

</body>

</html>