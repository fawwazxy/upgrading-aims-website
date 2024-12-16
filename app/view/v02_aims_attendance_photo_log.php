<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";
$id = $_SESSION['SESS_ID'];
$act = $_GET['act'];
$staff_ic = $_GET['staff_ic'];
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
<script src="../../js/jquery/v3.3.1/jquery.min.js"></script>
<script src="../../js/webcamjs/webcam.min.js"></script>
<style type="text/css">
    #results {
        padding:20px;
        border:1px solid;
        background:#ccc;
    }
</style>
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
                    <a href="panel_imbasan_masuk.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
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
                        <label style="font-size: 18px;padding-top: 4px;">Step 2: Photo Terminal</label>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <form method="POST" action="../controller/v02_aims_attendance_matric_exec.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="my_camera"></div>
                                    <br/>
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                    <input type="hidden" name="act" id="act" value="<? echo $act ?>">
                                    <input type="hidden" name="staff_ic" id="staff_ic" value="<? echo $staff_ic ?>">
                                </div>
                                <div class="col-md-6">
                                    <div id="results">Your captured image will appear here...</div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <br/>
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<!-- Configure a few settings and attach camera -->
<script type="text/javascript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
</body>
</html>