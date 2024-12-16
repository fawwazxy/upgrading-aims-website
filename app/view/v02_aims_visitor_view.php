<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";

$visitor_id = $_GET['id'];
$visitor_list = getVisitorListById($visitor_id)->fetch_assoc();
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
        .detail-header {
            background-color: #FFA500; color: black
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
                    VISITOR <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> VIEW
                    <a href="v02_aims_visitor_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_visitor_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">VISITOR DETAIL</h3>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10%" class="detail-header">Name</th>
                                        <td colspan="3"><? echo $visitor_list['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="detail-header">IC Number</th>
                                        <td><? echo $visitor_list['ic_number']; ?></td>
                                        <th style="width: 10%" class="detail-header">Phone Number</th>
                                        <td><? echo $visitor_list['phone_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="detail-header">Email</th>
                                        <td><? echo $visitor_list['email']; ?></td>
                                        <th class="detail-header">Type</th>
                                        <td><? echo getVisitorType($visitor_list['type']); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="detail-header">Company</th>
                                        <td colspan="3"><? echo $visitor_list['company']; ?></td>
                                    <tr>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-hover" id="attendance_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 15%">Role</th>
                                        <th style="width: 20%">Purpose</th>
                                        <th style="width: 15%">Clock In</th>
                                        <th style="width: 15%">Clock Out</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? $i=1;
                                    $attendance_list = getAttendanceListByVisitorId($visitor_id);
                                    while ($list = $attendance_list->fetch_assoc()){ ?>
                                        <tr>
                                            <td><? echo $i++?></td>
                                            <td><? echo getVisitorType($list['role']); ?></td>
                                            <td><? echo nl2br($list['reason']); ?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_in_time'].'<br> <b>Location: </b>'.$list['clock_in_location'].'<br> <b>QR Location: </b>'.$list['clock_in_qr']; ?></td>
                                            <td><? echo '<b>Time: </b>'.$list['clock_out_time'].'<br> <b>Location: </b>'.$list['clock_out_location'].'<br> <b>QR Location: </b>'.$list['clock_out_qr']; ?></td>
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