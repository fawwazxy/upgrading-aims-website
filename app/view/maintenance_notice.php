<?php
include ('../controller/auth.php');
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
<style type="text/css">
    .paper {
        height: 300px;
        width: 950px;
        background-color: #ADD8E6;
        position: relative;
        overflow: hidden;
    }
    .paper > h1 {
        margin: 60px 210px;
        font-family: cursive;
        text-align: center;
    }
    .paper > p {
        padding: 0px 30px;
        font-size: 20px;
        font-family: cursive;
        color: #555;
        text-align: center;
    }
</style>
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
        <div class="paper" style="float: right; margin: 100px 320px;">
            <h1>Notice: Under Development</h1>
            <p>We apologize for the inconvenience. This page is currently under development and will be available soon.</p>
            <p>Thank you for your patience.</p>
        </div>
    </div>
</body>
</html>
