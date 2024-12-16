<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$current_year = date('Y');
$year = ($_GET['year']) ?: $current_year;
$staff_id = $_GET['staff_id'];

$workday_calendar = getWorkdayCalendar($year, true);
$mainCalendarExisted = count($workday_calendar) > 0;

if (empty($staff_id)){
    echo "<script type='text/javascript'>
        alert('No staff info detected. Please check URL/Contact IT department');
        window.history.back();
    </script>";
    exit();
}

$staff = getStaffInfo($staff_id)->fetch_assoc();

$individual_calendar = getIndividualCalendar($staff['id'], $year,true);
$individualCalendarExisted = count($individual_calendar) > 0;

$box_color = [
    'workday' => '#d3ffd3',
    'off-day' => '#fff0d2',
    'public' => '#ffd0d0'
]; ?>
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
        .border-radius-0{
            border-radius: 0;
        }
        .px-slight{
            padding-left: 5%;
            padding-right: 5%;
        }
        .ml-4{
            margin-left: 4px;
        }
        .ml-16{
            margin-left: 16px;
        }
        .mr-16{
            margin-right: 16px;
        }
        .d-none{
            display: none;
        }
        .float-right{
            float: right;
        }
        .calendar-day{
            font-weight: bold;
            font-size: 20px;
        }
        .day-description{
            font-size: 10px;
            width: 90%;
            height: 2em;
            text-decoration: none;
            padding: 2px;
            border: 1px solid #a7a7a7;
            border-radius: 3px;
            text-align: center;
            overflow-y: hidden;
            text-overflow: ellipsis;
            display: block;
        }
        .tag-blue{
            color: #4d4dff;
            border-color: #4d4dff;
        }
        .day-description:hover{
            text-decoration: none;
        }
        .table-faded{
            border: 1px solid #b3b3b3;
            background-color: #eeeeee /*#c9ffc9*/;
        }
        .table-faded > thead > tr > th,
        .table-faded > thead > tr > td,
        .table-faded > tbody > tr > th,
        .table-faded > tbody > tr > td{
            border: 1px solid #b3b3b3;
        }
        .box-transparent:disabled{
            background-color:transparent;
            cursor: default;
            font-weight: bold;
        }
        .badge-notes{
            font-style: italic;
            margin-right: 16px;
        }
        .day-type{
            padding: 4px 8px;
            border: 2px solid white;
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CALENDAR
                    <i class="fa fa-caret-right"></i> <? echo $staff['noic'] ?>
                    <a href="konfigurasi_tarikh_bekerja.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_individual_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row" style="margin-bottom: 16px">
            <div class="col-md-6">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th colspan="4" style="padding: 4px 8px">Staff details</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Name</th>
                        <td colspan="3"><? echo $staff['name'] ?></td>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <td><? echo $staff['noic'] ?></td>
                        <th>Staff Number</th>
                        <td><? echo $staff['no_staff'] ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td><? echo $staff['department_id'] ?></td>
                        <th>Department</th>
                        <td><? echo $staff['department_sub'] ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label for="year">Year:</label>
                        <form method="get" action="" name="filterForm" class="" style="margin-bottom: 16px">
                            <input type="hidden" name="staff_id" value="<? echo $staff_id ?>">
                            <select class="form-control" name="year" id="year" onchange="filterForm.submit()">
                                <? for ($option = $current_year+1; $option >= 2022; $option--){
                                    $selected = ($option == $year) ? "selected" : "";
                                    echo "<option ".$selected.">".$option."</option>";
                                } ?>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <label for="status">Status:</label>
                        <input type="text" class="form-control box-transparent" value="<? echo $individualCalendarExisted ? 'Generated' : 'Not generated'; ?>"
                               style="color: <? echo $individualCalendarExisted ? '#199F1B' : '#9f191f'; ?>" id="status" disabled>
                    </div>
                    <div class="col-md-5">
                        <label>Public Holiday: </label><br>
                        <a href="#publicHolidayList" data-toggle="modal" data-year="<? echo $year ?>"
                           class="btn btn-primary">
                            View Public Holiday for <? echo $year ?></a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <label>Label from Main Calendar: </label><br>
                        <label class="day-type" title="Workdays (Hari Bekerja)" style="border-color: #08ff00; background-color: #d3ffd3">
                            Workdays</label>
                        <label class="day-type" title="Off-Days (Hari Cuti)" style="border-color: #ffab00; background-color: #fff0d2">
                            Off-Days</label>
                        <label class="day-type" title="Public Holidays (Hari Cuti Umum)" style="border-color: #ff0000; background-color: #ffd0d0">
                            Public Holidays</label>
                    </div>
                    <div class="col-md-5">
                        <label>Label for Individual Calendar: </label><br>
                        <label class="day-type" title="Individual Workday" style="border-color: #204d74; background-color: #ffffff; padding: 0 4px 0 0">
                            <span class="btn btn-sm btn-primary border-radius-0"><i class="fa fa-check"></i></span>
                            Workday</label>
                        <label class="day-type" title="Individual Workday" style="border-color: #269abc; background-color: #ffffff; padding: 0 4px 0 0">
                            <span class="btn btn-sm btn-info border-radius-0"><i class="fa fa-times"></i></span>
                            Off-day</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="overflow: auto">
                <? if (!$mainCalendarExisted){ ?>
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <label>Failed to produce calendar configuration!</label>
                        </div>
                        <div class="panel-body text-center">
                            <p>Main calendar for <? echo $year ?> is still not generated. Please generate Main Calendar first.</p>
                            <a href="v02_aims_attendance_workday_calendar.php?year=<? echo $year ?>" target="_blank"
                               class="btn btn-success">Generate Main Calendar for <? echo $year ?></a>
                        </div>
                    </div>
                <? }else{ ?>
                    <form action="../controller/v02_aims_attendance_individual_calendar_exec.php" method="post">
                        <input type="hidden" name="staff_id" value="<? echo $staff_id ?>">
                        <input type="hidden" name="action" value="<? echo $individualCalendarExisted ? 'update' : 'insert'; ?>">
                        <? for($month = 1; $month <= 12; $month++){ //For each month
                            $start_of_month = $year.'-'.sprintf('%02d', $month).'-01';
                            $number_days_in_month = date('t', strtotime($start_of_month));
                            $day = 1; ?>
                            <table class="table table-bordered table-faded">
                                <thead>
                                <tr>
                                    <th colspan="8"><? echo date('F', strtotime($start_of_month)).' '.$year.' ('.$number_days_in_month.' days)'?></th>
                                </tr>
                                <tr>
                                    <th style="width: 9%">#</th>
                                    <th style="width: 13%">Sunday</th>
                                    <th style="width: 13%">Monday</th>
                                    <th style="width: 13%">Tuesday</th>
                                    <th style="width: 13%">Wednesday</th>
                                    <th style="width: 13%">Thursday</th>
                                    <th style="width: 13%">Friday</th>
                                    <th style="width: 13%">Saturday</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? for($row = 1; $row <= 6; $row++) { // For each week
                                    if ($day > $number_days_in_month && $row > 5){
                                        break;
                                    } ?>
                                    <tr>
                                        <th><? echo 'Week '.$row ?></th>
                                        <?
                                        $day_offset = ($row == 1) ? date('w', strtotime($start_of_month)) : 0;
                                        for ($column = 0; $column < 7; $column++){ //For each day (Sunday to Saturday)

                                            if($column >= $day_offset && $day <= $number_days_in_month){
                                                $date = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day);
                                                $main = $workday_calendar[$date];
                                                $individual = $individual_calendar[$date];

                                                $workday = $main['type'] == 'workday';

                                                if ($individualCalendarExisted){
                                                    $shift = [
                                                        'id' => $individual['shift_id'] ?: null,
                                                        'code' => $individual['shift_code'] ?: '-',
                                                        'description' => $individual['shift_code'] ?: '',
                                                    ];
                                                    $individual_workday = $individual['workday'] == '1';
                                                }else{
                                                    $shift = [
                                                        'id' => $workday ? $staff['preferred_shift'] : null,
                                                        'code' => $workday ? $staff['shift_code'] : '-',
                                                        'description' => $workday ? $staff['shift_description'] : ''
                                                    ];
                                                    $individual_workday = $workday;
                                                } ?>
                                                <td title="<? echo $date ?>" id="<? echo $date ?>" style="background-color: <? echo $box_color[$main['type']] ?>">
                                                    <div class="form-inline px-slight">
                                                        <!-- Calendar Day Number (1 - 31) -->
                                                        <span class="calendar-day"><? echo $day++; ?></span>
                                                        <!-- Workday/Off-day toggle -->
                                                        <div class="float-right">
                                                            <label for="<? echo $date.'_off-day'?>" data-date="<? echo $date ?>" data-value="off-day" id="<? echo $date.'_workday_label'?>"
                                                                   class="opt-label btn btn-sm btn-primary <? if(!$individual_workday) echo 'd-none' ?>"><i class="fa fa-check"></i></label>
                                                            <label for="<? echo $date.'_workday'?>" data-date="<? echo $date ?>" data-value="workday" id="<? echo $date.'_off-day_label'?>"
                                                                   class="opt-label btn btn-sm btn-info <? if($individual_workday) echo 'd-none' ?>"><i class="fa fa-times"></i></label>
                                                        </div>
                                                    </div>
                                                    <!-- Shift Option -->
                                                    <div class="form-inline text-center" style="margin-top: 12px;">
                                                        <input type="hidden" name="shift[<? echo $date?>]" id="shift_<? echo $date ?>"
                                                               value="<? echo $shift['id']; ?>">
                                                        <a href="#selectShift" id="shift_tag_<? echo $date ?>" title="<? echo $shift['code']; ?>"
                                                           data-date="<? echo $date ?>" data-value="<? echo $shift['id']; ?>" data-toggle="modal"
                                                           class="day-description <? echo ($shift['id'] != '') ? 'tag-blue' : 'text-muted' ?>"
                                                           style="padding-top: 4px;padding-bottom: 4px;font-size: 14px;">
                                                            <i class="fa fa-calendar mr-16"></i><? echo $shift['code']; ?></a>
                                                    </div>
                                                    <!-- Individual Day description -->
                                                    <div class="form-inline text-center">
                                                        <input type="hidden" name="description[<? echo $date?>]" id="description_<? echo $date ?>"
                                                               value="<? echo ($individual['description']) ?: null; ?>">
                                                        <a href="#addDescription" id="tag_<? echo $date ?>" title="<? echo ($individual['description']) ?: 'Add description'; ?>"
                                                           data-date="<? echo $date ?>" data-value="<? echo $individual['description'] ?>" data-toggle="modal"
                                                           class="day-description <? echo ($individual['description']) ? 'tag-blue' : 'text-muted' ?>">
                                                            <? echo ($individual['description']) ?: 'Add description'; ?>
                                                        </a>
                                                    </div>
                                                    <!-- Main Day description -->
                                                    <div class="form-inline text-center" style="margin-top: 6px; font-weight: bold">
                                                        <? echo $main['description']; ?>
                                                    </div>
                                                    <!-- Hide radio input -->
                                                    <div class="d-none">
                                                        <input id="<? echo $date.'_workday'?>" class="opt-value" type="radio"
                                                               name="type[<? echo $date?>]" value="workday" <? if($individual_workday) echo 'checked'?>>
                                                        <input id="<? echo $date.'_off-day'?>" class="opt-value" type="radio"
                                                               name="type[<? echo $date?>]" value="off-day" <? if(!$individual_workday) echo 'checked'?>>
                                                    </div>
                                                </td>
                                            <? }else{ ?>
                                                <td></td>
                                            <? } ?>
                                        <? }?>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        <? }?>
                        <div class="row" style="margin: 4px 0 16px">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="submit" class="btn btn-block btn-primary" style="font-weight: bold"
                                       value="<? echo $individualCalendarExisted ? 'Update' : 'Generate'; ?> Calendar">
                            </div>
                        </div>
                    </form>
                <? } ?>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="addDescription" tabindex="-1" role="dialog" aria-labelledby="viewDescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewDescriptionModalLabel">Add description</h4>
            </div>
            <div class="modal-body" id="descriptionModalBody">
                <script type="text/javascript">
                    $('#addDescription').on('show.bs.modal', function (e) {
                        let date = $(e.relatedTarget).data('date');
                        let value = $(e.relatedTarget).data('value');
                        $('#viewDescriptionModalLabel').text('Add description for '+date);
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_attendance_workday_add_description_modal.php',
                            data:{date:date, value:value},
                            success:function(html){
                                $('#descriptionModalBody').html(html);
                            }
                        });

                        setTimeout(function (){
                            $('#temporary_input').focus();
                        }, 500);
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectShift" tabindex="-1" role="dialog" aria-labelledby="selectShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="selectShiftModalLabel">Select shift</h4>
            </div>
            <div class="modal-body" id="selectShiftModalBody">
                <script type="text/javascript">
                    $('#selectShift').on('show.bs.modal', function (e) {
                        let date = $(e.relatedTarget).data('date');
                        let value = $(e.relatedTarget).data('value');
                        $('#selectShiftModalLabel').text('Select shift for '+date);
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_attendance_workday_select_shift_modal.php',
                            data:{date:date, value:value},
                            success:function(html){
                                $('#selectShiftModalBody').html(html);
                            }
                        });

                        setTimeout(function (){
                            $('#temporary_shift_input').focus();
                        }, 500);
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="publicHolidayList" tabindex="-1" role="dialog" aria-labelledby="publicHolidayListLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="publicHolidayListLabel">Public Holiday List</h4>
            </div>
            <div class="modal-body" id="publicHolidayListBody">
                <script type="text/javascript">
                    $('#publicHolidayList').on('show.bs.modal', function (e) {
                        let year = $(e.relatedTarget).data('year');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_attendance_public_holiday_list.php',
                            data:{year:year},
                            success:function(html){
                                $('#publicHolidayListBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.opt-label', function (){
        let date = $(this).data('date');
        let value = $(this).data('value');
        $(this).addClass('d-none');
        $('#'+date+'_'+value+'_label').removeClass('d-none');
    });
</script>
</body>
</html>