<?php
include "../controller/auth.php";
require "../model/dashboard_functions.php";
$program = getProgramRegistered($_SESSION['SESS_ID'])->fetch_assoc();
$exist = ($program['id']) ? true : false;
$text['text'] = ($exist) ? 'Registered' : 'Not Registered';
$text['color'] = ($exist) ? 'green' : 'red';
$text['timestamp'] = ($exist) ? '<label>Registered on: </label> '.date('d/m/Y h:i:sa', strtotime($program['created_at'])) : '';
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
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    AIMS-PORTAL MOBILE BETA
                    <a href="dashboard.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to Dashboard
                    </a></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Register for <b>AIMS-PORTAL MOBILE BETA</b> version
                    </div>
                    <div class="panel-body">
                        <form action="../controller/program_register_form_exec.php" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="hidden" name="staff_id" id="staff_id" value="<? echo $_SESSION['SESS_ID']?>">
                                    <input type="hidden" name="id" id="id" value="<? echo $program['id'] ?>">

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Status:</label>
                                            <span style="margin-right: 64px;font-weight: bold;color: <? echo $text['color']; ?>"><? echo $text['text']; ?></span>
                                            <? echo $text['timestamp'] ?><br>
                                            <b style="color: red">Registration has been closed at 11/12/2022 11.00 AM.
                                                This form only opened to update smartphone model for those who has registered.</b>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" value="<? echo $_SESSION['SESS_NAME'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Staff Number</label>
                                                <input type="text" class="form-control" id="name" value="<? echo $_SESSION['SESS_NO_STAFF'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="control-label" for="company">Company</label>
                                                <input type="text" class="form-control" id="company" value="<? echo getCompanyName($_SESSION['SESS_DEPARTMENT']) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label" for="department">Department</label>
                                                <input type="text" class="form-control" id="department" value="<? echo $_SESSION['SESS_DEPARTMENT_SUB'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label" for="phone_no">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_no" value="<? echo $_SESSION['SESS_NO_TELEFON'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label" for="branch">Branch</label>
                                                <input type="text" class="form-control" id="branch" value="<? echo $_SESSION['SESS_CAWANGAN'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label" for="description">Smartphone Model</label>
                                                <input type="text" class="form-control" id="description" name="description" required
                                                       value="<? echo $program['description'] ?>" placeholder="Samsung Galaxy S22 Ultra">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-block btn-lg btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="">
                                    <h3 style="margin-top: 0">Join WhatsApp Group:</h3>
                                    <a href="https://chat.whatsapp.com/GBCzaPWyGr3ByRAZ9qzhyP" class="btn btn-block btn-success"
                                       style="font-weight: bold" target="_blank">
                                        JOIN WHATSAPP GROUP</a>
                                    <img src="../../photos/qr-whatsapp-aims-portal.jpg" alt="qr-whatsapp"
                                         style="border-radius: 10px; width: 100%; margin-top: 8px">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</body>
</html>
