<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";

if($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR' && !in_array($_SESSION['SESS_ROLE'], ['HOD', 'HOC', 'SUPERADMIN']) && !in_array($_SESSION['SESS_ID'],['58','61','89','654','192'])){
    echo "<script type='text/javascript'>
            alert('You are not authorized access this page');
            window.history.back();
            </script>";
    exit();
}

$company = $_GET['company'] ?: 'all';
$start_date = $_GET['start_date'] ?: date('Y-m-d');
$end_date = $_GET['end_date'] ?: date('Y-m-d');
$current_date = date('Y-m-d');

$disabled = array_keys(array_flip([$company, $start_date, $end_date])) == ['all'] ? "disabled" : "";
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
        .status {
            color:white;
            border-radius: 5px;
            padding:5px;
            font-weight:bold;
            text-align: center;
            pointer-events: none;
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
                    VISITOR <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> ATTENDANCE
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_visitor_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <label style="font-size: 18px">Attendance List</label>
                            </div>
                            <div class="col-md-3 text-right">
                                <a class="btn btn-primary" href="#addAttendance" data-toggle="modal">New Attendance</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <div class="form-group row">
                            <form method="get" action="" name="attendanceFilter" id="attendanceFilter">
                                <div class="col-md-4">
                                    <label for="company">Company</label>
                                    <select class="form-control" name="company" id="company">
                                        <option value="all">All Company</option>
                                        <? $distinct_company = getDistinctCompany();
                                        while ($filter_company = $distinct_company->fetch_assoc()) { ?>
                                            <option value="<? echo $filter_company['company'] ?>" <? if ($filter_company['company'] == $company) echo 'selected'; ?>><? echo $filter_company['company'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control" id="start_date" name="start_date" type="date" value="<? echo $start_date; ?>" max="<? echo $current_date; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" id="end_date" name="end_date" type="date" value="<? echo $end_date; ?>" min="<? echo $current_date; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <button type="submit" class="btn btn-info" id="filterBtn">Filter</button>
                                    <a href="v02_aims_visitor_attendance_list.php" class="btn btn-default <? echo $disabled ?>" style="background-color: rgb(188,188,188)">Reset Filter</a>
                                </div>
                            </form>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-hover" id="attendance_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 3%">#</th>
                                        <th style="width: 16%">Visitor Details</th>
                                        <th>Purpose</th>
                                        <th style="width: 20%">Clock In</th>
                                        <th style="width: 20%">Clock Out</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i=1;
                                    $attendance_list = getAttendanceList($company, $start_date, $end_date);
                                    while ($list = $attendance_list->fetch_assoc()){
                                        if ($list['clock_in_time'] != '' && $list['clock_out_time'] != ''){
                                            $status = 'CLOCKED OUT';
                                            $status_color = 'red';
                                        } else {
                                            $status = 'CLOCKED IN';
                                            $status_color = 'green';
                                        }
                                        ?>
                                        <tr>
                                            <td><? echo $i++?></td>
                                            <td>
                                                <b>Name: </b><? echo $list['name'] ?><br>
                                                <b>IC Number: </b><? echo $list['ic_number'] ?><br>
                                                <b>Company: </b><? echo $list['company'] ?><br>
                                                <b>Role: </b><? echo getVisitorType($list['role']); ?><br>
                                            </td>
                                            <td><? echo nl2br($list['reason']);?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_in_time'].'<br> <b>Location: </b>'.$list['clock_in_location'].'<br> <b>QR Location: </b>'.$list['clock_in_qr']; ?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_out_time'].'<br> <b>Location: </b>'.$list['clock_out_location'].'<br> <b>QR Location: </b>'.$list['clock_out_qr']; ?></td>
                                            <td><p class="status" style="background-color: <? echo $status_color; ?>"><? echo $status; ?></p></td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="true">
                                                        <i class="fa fa-caret-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                        <li><a style="display: block" href="#updateAttendance" data-toggle="modal" data-id="<? echo $list['id'] ?>" data-company="<? echo $company; ?>" data-start="<? echo $start_date; ?>" data-end="<? echo $end_date; ?>">
                                                                <i class="fa fa-pencil opt-icon"></i>Update</a></li>
                                                        <? if (empty($list['clock_out_time'])) { ?>
                                                            <li><a style="display: block;color: red" href="#clockOutAttendance" data-toggle="modal" data-id="<? echo $list['id'] ?>" data-company="<? echo $company; ?>" data-start="<? echo $start_date; ?>" data-end="<? echo $end_date; ?>">
                                                                    <i class="fa fa-clock-o opt-icon"></i> Clock Out</a></li>
                                                        <? } ?>
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
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="addAttendance" tabindex="-1" role="dialog" aria-labelledby="addAttendance-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="addAttendance-title" style="font-size: 120%">Attendance Form</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="addAttendance-body">
                <script type="text/javascript">
                    $('#addAttendance').on('show.bs.modal', function (e) {
                        $.ajax({
                            url:'v02_aims_visitor_attendance_form.php',
                            success:function(html){
                                $('#addAttendance-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Update Attendance</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="updateAttendance-body">
                <script type="text/javascript">
                    $('#updateAttendance').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let selected_company = $(e.relatedTarget).data('company');
                        let start = $(e.relatedTarget).data('start');
                        let end = $(e.relatedTarget).data('end');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_visitor_attendance_update.php',
                            data:{id:rowId,company:selected_company,start_date:start,end_date:end},
                            success:function(html){
                                $('#updateAttendance-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="clockOutAttendance" tabindex="-1" role="dialog" aria-labelledby="clockOutAttendance-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="clockOutAttendance-title" style="font-size: 120%">Clock Out</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="clockOutAttendance-body">
                <script type="text/javascript">
                    $('#clockOutAttendance').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let selected_company = $(e.relatedTarget).data('company');
                        let start = $(e.relatedTarget).data('start');
                        let end = $(e.relatedTarget).data('end');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_visitor_attendance_clock_out_modal.php',
                            data:{id:rowId,company:selected_company,start_date:start,end_date:end},
                            success:function(html){
                                $('#clockOutAttendance-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#attendance_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [0, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>