<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";
$id = $_SESSION['SESS_ID'];
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> TERMINAL MANUAL
                    <a href="log_kehadiran.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px;">ATTENDANCE LOG</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <a href="#clockIn" data-toggle="modal" class="btn btn-primary" style="margin-right: 20px;">Clock In</a>
                        <a href="#clockOut" data-toggle="modal" class="btn btn-primary">Clock Out</a>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>
<!--Clock In Modal-->
<div class="modal fade" id="clockIn" tabindex="-1" role="dialog" aria-labelledby="clockInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="clockInModalLabel">Clock In</h4>
            </div>
            <div class="modal-body" id="clockInModalBody">
                <form action="../controller/v02_aims_attendance_clock_in_exec.php" method="post">
                    <input type="hidden" id="created_by" name="created_by" value="<? echo $id ?>">
                    <input type="hidden" id="act" name="act" value="in">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label" for="staff_ic">I/C <span style="color: #ff0000; ">*</span></label>
                            <input class="form-control" id="staff_ic" name="staff_ic" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="branch_code">Branch <span style="color: red; ">*</span></label>
                            <select class="form-control" name="branch_code" id="branch_code" required>
                                <option selected disabled value="">-- Choose Branch --</option>
                                <? echo getLkpBranch('');?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label" for="location_code">Location <span style="color: red; ">*</span></label>
                            <select class="form-control" name="location_code" id="location_code" required>
                                <option selected disabled value="">-- Choose Location --</option>
                                <? echo getLkpLocation('');?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Clock Out Modal-->
<div class="modal fade" id="clockOut" tabindex="-1" role="dialog" aria-labelledby="clockOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="clockOutModalLabel">Clock Out</h4>
            </div>
            <div class="modal-body" id="clockOutModalBody">
                <form action="../controller/v02_aims_attendance_clock_in_exec.php" method="post">
                    <input type="hidden" id="created_by" name="created_by" value="<? echo $id ?>">
                    <input type="hidden" id="act" name="act" value="out">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label" for="staff_ic">I/C <span style="color: #ff0000; ">*</span></label>
                            <input class="form-control" id="staff_ic" name="staff_ic" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="branch_code">Branch <span style="color: red; ">*</span></label>
                            <select class="form-control" name="branch_code" id="branch_code" required>
                                <option selected disabled value="">-- Choose Branch --</option>
                                <? echo getLkpBranch('');?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label" for="location_code">Location <span style="color: red; ">*</span></label>
                            <select class="form-control" name="location_code" id="location_code" required>
                                <option selected disabled value="">-- Choose Location --</option>
                                <? echo getLkpLocation('');?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>