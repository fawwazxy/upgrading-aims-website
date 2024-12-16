<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$id = $_GET['id'];
$month = $_GET['month'];
$year = $_GET['year'];
$staff_info = getStaffInfo($id)->fetch_assoc();
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> MONTHLY <i class="fa fa-caret-right"></i> STAFF LIST
                    <a href="senarai_keseluruhan_kehadiran.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px">Attendance List <i class="fa fa-caret-right"></i> <? echo $staff_info['name'] ?></label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover text-center" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Date</th>
                                <th class="text-center" style="width: 15%">Time In</th>
                                <th class="text-center" style="width: 15%">Time Out</th>
                                <th class="text-center" style="width: 10%">Status</th>
                                <th class="text-center" style="width: 10%">Map</th>
                                <th class="text-center" style="width: 20%">Total Work Hour</th>
                                <th class="text-center" style="width: 20%">Diff Work Hour</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getMonthlyListByStaff($id, $month, $year);
                            while($row_data = $data->fetch_assoc()) {
                                $total_work_hour = secondToHoursMinutesSeconds($row_data['total_time']);
                                if ($row_data['status'] == 0){
                                    $font_color = 'RED';
                                    $status = 'LATE';
                                } elseif ($row_data['status'] == 1) {
                                    $font_color = 'BLUE';
                                    $status = 'ON TIME';
                                } elseif ($row_data['status'] == 2) {
                                    $font_color = 'GREEN';
                                    $status = 'EARLY';
                                }
                                $current_time = time();
                                $time_in = strtotime($row_data['clock_in_time']);
                                $total_time = $current_time - $time_in;
                                $shift = getShiftDaily($row_data['today'], $row_data['staff_id']);
                                $not_count = $shift - $total_time;
                                if($row_data['clock_out_time'] == null){
                                    $total_current_work_hour = secondToHoursMinutesSeconds($total_time);
                                    if ($shift > $total_time ){
                                        $current_color = 'RED';
                                    } else
                                        $current_color = 'BLUE';
                                    $total_not_counted_work_hour = secondToHoursMinutesSeconds(abs($not_count));
                                    if ($not_count < 0) {
                                        $total_not_counted_work_hour = '-' . $total_not_counted_work_hour;
                                    }
                                } else {
                                    $total_current_work_hour = secondToHoursMinutesSeconds($row_data['total_time']);
                                    if ($shift > $total_current_work_hour){
                                        $current_color = 'RED';
                                    } else
                                        $current_color = 'BLUE';
                                    $total_not_counted_work_hour = secondToHoursMinutesSeconds($shift - $row_data['total_time']);
                                    if ($shift > $total_not_counted_work_hour ){
                                        $uncounted_color = 'RED';
                                    } else
                                        $uncounted_color = 'BLUE';
                                }
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $row_data['date']; ?></td>
                                    <td><? echo $row_data['time_in']; ?></td>
                                    <td><? echo $row_data['time_out']; ?></td>
                                    <td style="color: <?echo $font_color?>; font-weight: bold;"><? echo $status; ?></td>
                                    <td><button class="btn btn-info" onclick="return popitup('../view/v02_aims_attendance_map.php?lokasi=<? echo $row_data['clock_in_location'];?>&id=<? echo $row_data['id']?>')">Map</button></td>
                                    <td style="color: <?echo $current_color?>"><? echo $total_current_work_hour; ?></td>
                                    <td style="color: <?echo $uncounted_color?>"><? echo $total_not_counted_work_hour; ?></td>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>