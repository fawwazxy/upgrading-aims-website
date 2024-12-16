<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$current_year = date('Y');
$month = $_GET['month'] ?: date('m');
$year = $_GET['year'] ?: $current_year;
$current_date = time();

$staff_id = $_SESSION['SESS_ID'];
$staff_name = $_SESSION['SESS_NAME'];
$staff_ic = $_SESSION['SESS_NOKP'];
$staff_no = $_SESSION['SESS_NO_STAFF'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];
$staff_department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
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
                    PERSONAL ATTENDANCE REPORT <sub class="version">v02</sub>
                    <a href="analisa_kehadiran_peribadi.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="staffDetailTable">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_name; ?>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_ic; ?>
                    </tr>
                    <tr>
                        <th>Staff No</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_no; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_department; ?>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td class="colon">:</td>
                        <td><?echo $staff_department_sub; ?>
                    </tr>
                    <tr>
                        <th><label for="year">Show info for year:</label></th>
                        <td class="colon">:</td>
                        <td>
                            <form method="get" action="" name="filterForm" class="form-inline" style="margin-bottom: 16px" onchange="filterForm.submit()">
                                <select required class="form-control" name="year" id="year">
                                    <? for($i=0; $i<5; $i++){
                                        $option_year = $current_year - $i;?>
                                        <option value="<? echo $option_year ?>" <? echo ($option_year == $year) ? 'selected' : ''; ?>>
                                            <? echo $option_year ?>
                                        </option>
                                    <? } ?>
                                </select>

                            </form>
                        </td>
                    </tr>
                </table>
            </div>
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
                                <th class="text-center">Month</th>
                                <th class="text-center" style="width: 20%">Status</th>
                                <th class="text-center" style="width: 15%">Total Work Time</th>
                                <th class="text-center" style="width: 15%">Total Time Balance</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $x=1;
                            $months = array("January" => "01", "February" => "02","March" => "03", "April" => "04","May" => "05", "June" => "06",
                                "July" => "07", "August" => "08","September" => "09", "October" => "10","November" => "11", "December" => "12");

                            $currentMonth = date('m');
                            $currentYear = date('Y');

                            foreach ($months as $months_name => $month){
                                if ($currentYear == $year && $month > $currentMonth) {
                                    break;
                                }
                                    //count early on, on time, late
                                    $attendance = personalAttendanceSummary($staff_id, $month, $year);
                                    //calculate total work
                                    $work_hour_array = workHourArray($staff_ic, $month, $year);

                                    ?>

                                    <tr>
                                        <td class="text-center"><?echo $x++; ?></td>
                                        <td class="text-center"><? echo $months_name;?></td>
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
                                                    <li><a target="_blank" style="display: block" href="v02_aims_attendance_monthly_list_staff.php?id=<?echo $staff_id?>&month=<?echo $month?>&year=<?echo $year?>">
                                                            <i class="fa fa-list opt-icon"></i> Attendance List</a></li>
                                                    <li><a target="_blank" style="display: block" href="v02_aims_attendance_monthly_report.php?id=<?echo $staff_id?>&month=<?echo $month?>&year=<?echo $year?>">
                                                            <i class="fa fa-file-o opt-icon"></i> Attendance Monthly Report</a></li>
                                                    <li><a target="_blank" style="display: block" href="v02_aims_attendance_electronic_time_card_print.php?id=<?echo $staff_id?>&month=<?echo $month?>&year=<?echo $year?>">
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