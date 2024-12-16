<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$current_year = date('Y');
$month = $_GET['month'] ?: date('m');
$year = $_GET['year'] ?: $current_year;
$branch=$_GET['branch'] ?: $_SESSION['SESS_CAWANGAN'];
$department=$_GET['department'] ?: 'AGHSB';
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> MONTHLY LIST
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

        <div class="row" style="margin: 8px 0">
            <form action="" method="get">
                <div class="col-md-2">
                    <select required class="form-control" name="branch" id="branch">
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","cawangan_kod",$branch);?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select required class="form-control" name="department" id="department">
                        <? echo getDropDown("department","code_department","description",$department);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="month" id="month">
                        <? foreach (getMonthArray() as $index => $name){ ?>
                            <option value="<? echo $index ?>" <? echo ($index == $month) ? 'selected' : '' ?>>
                                <? echo $name ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="year" id="year">
                        <? for($i=0; $i<5; $i++){
                            $option_year = $current_year - $i;?>
                            <option value="<? echo $option_year ?>" <? echo ($option_year == $year) ? 'selected' : ''; ?>>
                                <? echo $option_year ?>
                            </option>
                        <? } ?>
                    </select>
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
                                <th class="text-center" style="width: 12%">Status</th>
                                <th class="text-center" style="width: 15%">Total Work Time</th>
                                <th class="text-center" style="width: 15%">Total Time Balance</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getAttendanceMonthlyList($month, $year, $branch, $department);
                            while($row_data = $data->fetch_assoc()) {
                                //Count Awal, Tepat, & Lewat
                                $attendance = personalAttendanceSummary($row_data['staff_id'], $month, $year);
                                //Work Hour Calculation
                                $work_hour_array = workHourArray($row_data['noic'], $month, $year);
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row_data['name']; ?><br> <b><? echo $row_data['noic']; ?></b></td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td style="width: 50%"><b>Early </b></td>
                                                <td style="width: 15%">: </td>
                                                <td style="width: 20%"><b style="color: green; font-size: 16px"><?echo $attendance['2'] ?: '0' ?></b></td>
                                                <td style="width: 15%"> Hari</td>
                                            </tr>
                                            <tr>
                                                <td><b>On Time </b></td>
                                                <td>: </td>
                                                <td><b style="color: purple; font-size: 16px"><? echo $attendance['1'] ?: '0'?></b></td>
                                                <td> Hari</td>
                                            </tr>
                                            <tr>
                                                <td><b>Late </b></td>
                                                <td>: </td>
                                                <td><b style="color: red; font-size: 16px"><?echo $attendance['0'] ?: '0' ?></b></td>
                                                <td> Hari</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="text-center"><?php echo $work_hour_array['sum']; ?></td>
                                    <td class="text-center"><?php echo $work_hour_array['difference']; ?></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a target="_blank" style="display: block" href="v02_aims_attendance_monthly_list_staff.php?id=<?echo $row_data['staff_id']?>&month=<?echo $month?>&year=<?echo $year?>">
                                                        <i class="fa fa-list opt-icon"></i> Staff Attendance List</a></li>
                                                <li><a target="_blank" style="display: block" href="v02_aims_attendance_monthly_report.php?id=<?echo $row_data['staff_id']?>&month=<?echo $month?>&year=<?echo $year?>">
                                                        <i class="fa fa-file-o opt-icon"></i> Attendance Monthly Report</a></li>
                                                <li><a target="_blank" style="display: block" href="v02_aims_attendance_electronic_time_card_print.php?id=<?echo $row_data['staff_id']?>&month=<?echo $month?>&year=<?echo $year?>">
                                                        <i class="fa fa-clock-o opt-icon"></i> Electronic Time Card</a></li>
                                            </ul>
                                        </div>
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