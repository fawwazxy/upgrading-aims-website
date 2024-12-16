<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$selected_date = $_GET['dt'] ?: date('Y-m-d');
$branch=$_GET['branch'] ?: $_SESSION['SESS_CAWANGAN'];
$department=$_GET['department'] ?: 'AGIRSB';

$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$role_id = $_SESSION['SESS_ROLE'];
if (!in_array($department_sub, ['HR']) && !in_array($role_id, ['FOUNDER', 'SUPERADMIN'])){
    echo ("<script type='text/javascript'>
                alert('You are not authorized to view this page');
                window.history.back();
                </script>");
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> DAILY LIST
                    <a href="senarai_kehadiran.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row" style="margin: 8px 0">
            <form action="" method="get">
                <div class="col-md-2">
                    <select required class="form-control" name="branch" id="branch">
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","cawangan_kod",$branch);?>
                    </select>
                </div>
                <div class="col-md-5">
                    <select required class="form-control" name="department" id="department">
                        <? echo getDropDown("department","code_department","description",$department);?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="dt" id="dt" class="form-control" value="<? echo $selected_date ?>"
                           max="<? echo date('Y-m-d') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block font-weight-bold">Search &nbsp;<i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px">Attendance List</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Name</th>
                                    <th class="text-center" style="width: 20%">Clock In</th>
                                    <th class="text-center" style="width: 20%">Clock Out</th>
                                    <th class="text-center" style="width: 15%">Status</th>
                                    <th class="text-center" style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getAttendanceDailyList($selected_date, $branch, $department);
                            while($list = $data->fetch_assoc()) {
                                $belum_kira = getTotalWorkHourCurrentStaff($list['staff_ic']);
                                //Status
                                if ($list['status'] == 0){
                                    $font_color = 'RED';
                                    $status = 'LATE';
                                } elseif ($list['status'] == 1) {
                                    $font_color = 'BLUE';
                                    $status = 'ON TIME';
                                } elseif ($list['status'] == 2) {
                                    $font_color = 'GREEN';
                                    $status = 'EARLY';
                                }
                                $current_time = time();
                                $time_in = strtotime($list['clock_in_time']);
                                $total_time = $current_time - $time_in;
                                $shift = getShiftDaily($selected_date, $list['staff_id']);
                                $not_count = $shift - $total_time;
                                if($list['clock_out_time'] == null){
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
                                    $total_current_work_hour = secondToHoursMinutesSeconds($list['total_time']);
                                    if ($shift > $total_current_work_hour){
                                        $current_color = 'RED';
                                    } else
                                        $current_color = 'BLUE';
                                    $total_not_counted_work_hour = secondToHoursMinutesSeconds($shift - $list['total_time']);
                                    if ($shift > $total_not_counted_work_hour ){
                                        $uncounted_color = 'RED';
                                    } else
                                        $uncounted_color = 'BLUE';
                                }

                                /*$current_time = strtotime(date('h:i:s', time()));
                                $time_in = strtotime($list['time_in']);
                                $total_time = $current_time - $time_in;
                                $shift = getShiftDaily($selected_date, $list['staff_id']);
                                $not_count = $shift - $current_time;
                                if($list['time_out'] == ''){
                                    $total_current_work_hour = secondToHoursMinutesSeconds($total_time);
                                    $total_not_counted_work_hour = secondToHoursMinutesSeconds($not_count);
                                } else {
                                    $total_current_work_hour = $list['total'];
                                }*/
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><? echo $list['name']?><br>
                                        <b><? echo $list['staff_ic']; ?></b><br>
                                        <b>Total Current Work Hours: </b><span style="color: <?echo $current_color?>"><?echo $total_current_work_hour?></span><br>
                                        <b>Uncounted Work Hour: </b><span style="color: <?echo $uncounted_color?>"><?echo $total_not_counted_work_hour?></span>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td style="width: 30%"><b>Time </b></td>
                                                <td class="text-center" style="width: 15%">: </td>
                                                <td style="width: 55%"><?echo $list['time_in']?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Location </b></td>
                                                <td class="text-center">: </td>
                                                <td><? echo $list['clock_in_remark']?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Platform </b></td>
                                                <td class="text-center">: </td>
                                                <td><?echo $list['clock_in_method'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td style="width: 30%"><b>Time </b></td>
                                                <td class="text-center" style="width: 15%">: </td>
                                                <td style="width: 55%"><?echo $list['time_out']? : '<b>NOT LOG OUT</b>'?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Location </b></td>
                                                <td class="text-center">: </td>
                                                <td><? echo $list['clock_out_remark'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Platform </b></td>
                                                <td class="text-center">: </td>
                                                <td><?echo $list['clock_out_method'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="text-center" style="color: <?echo $font_color?>"><b><?echo $status?></b></td>
                                    <td class="text-center">
                                        <button class="btn btn-info" onclick="return popitup('../view/v02_aims_attendance_map.php?lokasi=<? echo $list['clock_in_location'];?>&id=<? echo $list['id']?>')">Map</button>
                                        <a href="../view/v02_aims_attendance_daily_report.php?date=<? echo $selected_date; ?>&id=<? echo $list['staff_id']; ?>" target="_blank"><button class="btn btn-info" type="button" >Daily Report</button></a>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>