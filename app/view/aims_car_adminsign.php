<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$app_status = $_GET['app_status'];
if (!isset($app_status) && $app_status == '') {
    $app_status = 'PENDING';
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

</head>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>

    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");
    .main-wrapper {
        background-color: #fff;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
    }
    .signboard-wrapper {
        width: 95vmin;
        height: 55vmin;
        margin: 20px;
        position: relative;
        flex-shrink: 0;
        transform-origin: center 2.5vmin;
        animation: 1000ms init forwards, 1000ms init-sign-move ease-out 1000ms, 3000ms sign-move 2000ms infinite;
    }
    .signboard-wrapper .signboard {
        color: #fff;
        font-family: "Open Sans", sans-serif;
        font-weight: bold;
        font-size: 50px;
        background-color: #ff5625;
        width: 100%;
        height: 35vmin;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        bottom: 0;
        border-radius: 4vmin;
        text-shadow: 0 -0.015em #be2b00;
        box-shadow: 0 2vmin 4vmin 1vmin rgba(107, 107, 107, 0.8);
    }
    .signboard-wrapper .string {
        width: 30vmin;
        height: 30vmin;
        border: solid 0.9vmin #893d00;
        border-bottom: none;
        border-right: none;
        position: absolute;
        left: 50%;
        transform-origin: top left;
        transform: rotate(45deg);
    }
    .signboard-wrapper .pin {
        width: 5vmin;
        height: 5vmin;
        position: absolute;
        border-radius: 50%;
    }
    .signboard-wrapper .pin.pin1 {
        background-color: #9f9f9f;
        top: 0;
        left: calc(50% - 2.5vmin);
    }
    .signboard-wrapper .pin.pin2, .signboard-wrapper .pin.pin3 {
        background-color: #d83000;
        top: 21.5vmin;
    }
    .signboard-wrapper .pin.pin2 {
        left: 13vmin;
    }
    .signboard-wrapper .pin.pin3 {
        right: 13vmin;
    }
    @keyframes init {
        0% {
            transform: scale(0);
        }
        40% {
            transform: scale(1.1);
        }
        60% {
            transform: scale(0.9);
        }
        80% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    @keyframes init-sign-move {
        100% {
            transform: rotate(3deg);
        }
    }
    @keyframes sign-move {
        0% {
            transform: rotate(3deg);
        }
        50% {
            transform: rotate(-3deg);
        }
        100% {
            transform: rotate(3deg);
        }
    }
</style>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="main-wrapper">
            <div class="signboard-wrapper">
                <div class="signboard">ADMIN_ONLY</div>
                <div class="string"></div>
                <div class="pin pin1"></div>
                <div class="pin pin2"></div>
                <div class="pin pin3"></div>
            </div>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>
</div>
<!-- /#wrapper -->



</body>

</html>