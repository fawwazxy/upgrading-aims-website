<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$current_year = date('Y');
$year = ($_GET['year']) ?: $current_year;

$workday_calendar = getWorkdayCalendar($year, true);
$calendarExisted = count($workday_calendar) > 0;
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
        .d-none{
            display: none;
        }
        .px-slight{
            padding-left: 5%;
            padding-right: 5%;
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
            background-color: rgba(192, 255, 242, 0.25);
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> MAIN CALENDAR
                    <a href="penentuan_tarikh_bekerja.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
            <div class="col-md-2">
                <form method="get" action="" name="filterForm" class="" style="margin-bottom: 16px">
                    <label for="year">Calendar for year:</label>
                    <select class="form-control" name="year" id="year" onchange="filterForm.submit()">
                        <? for ($option = $current_year+1; $option >= 2022; $option--){
                            $selected = ($option == $year) ? "selected" : "";
                            echo "<option ".$selected.">".$option."</option>";
                        } ?>
                    </select>
                </form>
            </div>
            <div class="col-md-2">
                <label for="status">Status:</label>
                <input type="text" class="form-control box-transparent" value="<? echo $calendarExisted ? 'Generated' : 'Not generated'; ?>"
                       style="color: <? echo $calendarExisted ? '#199F1B' : '#9f191f'; ?>" id="status" disabled>
            </div>
            <div class="col-md-4">
                <label for="status">Badge:</label><br>

                <label class="btn btn-sm btn-success">W</label>
                <label title="Workdays (Hari Bekerja)"> Workdays <!--<span class="badge-notes">(Hari Bekerja)</span>--></label>

                <label class="btn btn-sm btn-warning">O</label>
                <label title="Off-Days (Hari Cuti)"> Off-Days <!--<span class="badge-notes">(Hari Cuti)</span>--></label>

                <label class="btn btn-sm btn-danger">P</label>
                <label title="Public Holidays (Hari Cuti Umum)"> Public Holidays <!--<span class="badge-notes">(Hari Cuti Umum)</span>--></label>
            </div>
            <div class="col-md-4 text-right">
                <label></label><br>
                <a href="#publicHolidayList" data-toggle="modal" data-year="<? echo $year ?>" class="btn btn-primary <? echo $calendarExisted ? '' : 'disabled'; ?>">
                    View Public Holiday for <? echo $year ?></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="overflow: auto">
                <form action="../controller/v02_aims_attendance_workday_calendar_exec.php" method="post">
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
                                            $workday_type = $workday_calendar[$date]['type'];
                                            $workday_description = $workday_calendar[$date]['description'];

                                            if ($calendarExisted) {
                                                $workday = $workday_type == 'workday';
                                                $off_day = $workday_type == 'off-day';
                                                $public = $workday_type == 'public';
                                            } else { // if no data
                                                $workday = $column < 5;
                                                $off_day = $column >= 5;
                                                $public = false;
                                                if ($column == 6 && !in_array($row, [1, 3])) { // if saturday for week other than 1 & 3
                                                    $workday = true;
                                                    $off_day = false;
                                                }
                                            }

                                            ?>
                                            <td title="<? echo $date ?>" id="<? echo $date ?>">
                                                <div class="form-inline px-slight">
                                                    <span class="calendar-day"><? echo $day++; ?></span>
                                                    <div class="float-right">
                                                        <label for="<? echo $date.'_off-day'?>" data-date="<? echo $date ?>" data-value="off-day" id="<? echo $date.'_workday_label'?>"
                                                               class="opt-label btn btn-sm btn-success <? if(!$workday) echo 'd-none' ?>">W</label>
                                                        <label for="<? echo $date.'_public'?>" data-date="<? echo $date ?>" data-value="public" id="<? echo $date.'_off-day_label'?>"
                                                               class="opt-label btn btn-sm btn-warning <? if(!$off_day) echo 'd-none' ?>">O</label>
                                                        <label for="<? echo $date.'_workday'?>" data-date="<? echo $date ?>" data-value="workday" id="<? echo $date.'_public_label'?>"
                                                               class="opt-label btn btn-sm btn-danger <? if(!$public) echo 'd-none' ?>">P</label>
                                                    </div>
                                                </div>
                                                <div class="form-inline text-center" style="margin-top: 6px;">
                                                    <input type="hidden" name="description[<? echo $date?>]" id="description_<? echo $date ?>"
                                                           value="<? echo ($workday_description) ?: null; ?>">
                                                    <a href="#addDescription" id="tag_<? echo $date ?>" title="<? echo ($workday_description) ?: 'Add description'; ?>"
                                                       data-date="<? echo $date ?>" data-value="<? echo $workday_description ?>" data-toggle="modal"
                                                       class="day-description <? echo ($workday_description) ? 'tag-blue' : 'text-muted' ?>">
                                                        <? echo ($workday_description) ?: 'Add description'; ?>
                                                    </a>
                                                </div>
                                                <div class="d-none">
                                                    <input id="<? echo $date.'_workday'?>" class="opt-value" type="radio"
                                                           name="type[<? echo $date?>]" value="workday" <? if($workday) echo 'checked'?>>
                                                    <input id="<? echo $date.'_off-day'?>" class="opt-value" type="radio"
                                                           name="type[<? echo $date?>]" value="off-day" <? if($off_day) echo 'checked'?>>
                                                    <input id="<? echo $date.'_public'?>" class="opt-value" type="radio"
                                                           name="type[<? echo $date?>]" value="public" <? if($public) echo 'checked'; ?>>
                                                </div>
                                            </td>
                                        <? }else{ ?>
                                            <td style="background-color: rgb(222,222,222)"></td>
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
                                   value="<? echo $calendarExisted ? 'Update' : 'Generate'; ?> Calendar">
                            <input type="hidden" name="action" value="<? echo $calendarExisted ? 'update' : 'insert'; ?>">
                        </div>
                    </div>
                </form>
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