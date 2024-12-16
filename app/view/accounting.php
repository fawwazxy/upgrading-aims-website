<?php
include ('../controller/auth.php');
require "../model/functions.php";
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
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Perakaunan & Kewangan</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Perakaunan & Kewangan
                    </div>
                    <div class="panel-body">
                        <div style="text-align: center"><h2><b>Nantikan Modul Ini Dalam Versi Penuh Tidak Lama Lagi!</b></h2></div>
                        <div style="text-align: center">
                            <br><br>
                            <button class="btn btn-warning btn-lg" style="min-width: 200px; min-height: 100px"> Cash Flow</button><br><br>
                            <button class="btn btn-info btn-lg" style="min-width: 200px; min-height: 100px"> Profit & Loss</button><br><br>
                            <button class="btn btn-success btn-lg" style="min-width: 200px; min-height: 100px"> Balance Sheet</button><br><br>
                            <button class="btn btn-danger btn-lg" style="min-width: 200px; min-height: 100px"> Trial Balance</button><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</body>
</html>