<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

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
    <style>
        .d-none{
            display: none;
        }
        .float-right{
            float: right;
        }
        .badge-notes{
            font-style: italic;
            margin-right: 16px;
        }
        .btn-proceed{
            float: right;
            padding-right: 16px;
            font-size: 20px;
        }
        .attendance-menu, .attendance-sub-menu{
            list-style: none;
            padding-left: 0;
        }
        .attendance-menu span{
            font-weight: bold;
            font-size: 12px;
            color: #818181;
        }
        .attendance-menu > li:not(:first-child){
            margin-top: 16px;
        }
        .attendance-sub-menu > li{
            padding-top: 10px;
            padding-bottom: 10px;
            border-top: 1px solid #818181;
            font-size: 16px;
            font-weight: bolder;
        }
        .attendance-sub-menu > li > a{
            display: block;
            text-decoration: none;
            color: inherit;
            padding-left: 8px;
        }
        .attendance-sub-menu > li:hover{
            background-color: #ececec;
            cursor: pointer;
            border-radius: 6px;
            border: 1px solid #818181;
            box-shadow: 0 0 8px #919191;
        }
        .attendance-sub-menu > li:hover + li{
            border-top: none
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
                    ATTENDANCE <sub class="version">Version 02</sub>
                    <a href="senarai_kehadiran.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6" style="overflow: auto">
                <ul class="attendance-menu">
                    <li>
                        <span>Terminal</span>
                        <ul class="attendance-sub-menu">
                            <li>
                                <a href="../view/v02_aims_attendance_matric_log.php?act=in">
                                    Clock-in using staff's personal QR Code <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                            <li>
                                <a href="../view/v02_aims_attendance_matric_log.php?act=out">
                                    Clock-out using staff's personal QR Code <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                            <li>
                                <a href="../view/v02_aims_attendance_manual_log.php">
                                    Manual Clock-in/Clock-out using IC Number <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <span>Staff Calendar</span>
                        <ul class="attendance-sub-menu">
                            <li>
                                <a href="../view/v02_aims_attendance_individual_homepage.php">
                                    Individual Workday & Shift <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <span>Report & Analysis</span>
                        <ul class="attendance-sub-menu">
                            <li>
                                <a href="../view/v02_aims_attendance_daily_list.php">
                                    Daily <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                            <li>
                                <a href="v02_aims_attendance_monthly_list.php">
                                    Monthly <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <span>Settings</span>
                        <ul class="attendance-sub-menu">
                            <li>
                                <a href="v02_aims_attendance_workday_calendar.php">
                                    Main Calendar <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                            <li>
                                <a href="v02_aims_attendance_shift_list.php">
                                    Work Shift List <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                            <li>
                                <a href="v02_aims_attendance_qr_location_list.php">
                                    QR Location Label <i class="fa fa-arrow-right btn-proceed"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>
</body>
</html>