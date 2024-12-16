<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$company = $_GET['company'] ?: 'AGHSB';
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
        .float-right{
            float: right;
        }
        .status-pill{
            padding: 4px 12px;
            color: #303030;
            border-radius: 12px;
            font-weight: bold;
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
                    <a href="konfigurasi_tarikh_bekerja.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                        <div class="row">
                            <div class="col-md-8">
                                <label for="company" style="font-size: 18px;padding-top: 4px">Work Shift list</label>
                            </div>
                            <div class="col-md-4 text-right">
                                <form method="get" action="" name="filterForm">
                                    <select class="form-control" name="company" id="company" onchange="filterForm.submit()">
                                        <? foreach (getCompany() as $option){?>
                                            <option value="<? echo $option['code_department'] ?>"
                                                <? if ($option['code_department'] == $company) echo 'selected' ?>>
                                                <? echo $option['description'] ?></option>
                                        <? } ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover" id="staff_list">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>IC Number</th>
                                <th>Department</th>
                                <th>Company</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            foreach (getStaffList($company) as $item){ ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $item['name'] ?></td>
                                    <td><? echo $item['noic'] ?></td>
                                    <td><? echo $item['department_sub'] ?></td>
                                    <td><? echo $item['department_id'] ?></td>
                                    <td class="text-center">
                                        <a href="../view/v02_aims_attendance_individual_calendar.php?staff_id=<? echo $item['id'] ?>"
                                           class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#staff_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            order: [1, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>