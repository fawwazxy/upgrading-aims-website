<?php
    include ('../controller/auth.php');
    require "../model/v02_aims_others_claim_function.php";
    require "../model/lookup.php";
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

<style>
    .paper{
        margin: 100px auto;
        height: 300px;
        width: 600px;
        background-color: #ADD8E6;
        position: relative;
        overflow: hidden;
    }
    .paper::after{
        content: '';
        display: block;
        border-width: 0px 75px 75px 0px;
        border-style: solid;
        border-color: #d7d7d7 transparent;
        position: absolute;
        top: 0;
        right: 0;
    }
    .paper::after{
        content: '';
        display: block;
        border-width: 0px 75px 75px 0px;
        border-style: solid;
        border-color: #d7d7d7 #FFF;
        box-shadow: -5px 6px 10px rgb(129, 127, 127);
        position: absolute;
        top: 0;
        right: 0;
    }

    .paper > h1{
        margin: 30px 210px;
        font-family: cursive;
        text-align: center;
    }

    .paper > p{
        padding: 0px 30px;
        font-size: 20px;
        font-family: cursive;
        color: #555;
        text-align: center;
    }
</style>
<body>

<style>
    p{
        font-size: 120%;
    }
</style>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="paper">
            <h1>Peringatan</h1>
            <p>Bahagian ini hanya untuk kegunaan Finance & Account Department sahaja</p>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.row -->
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<!-- /#wrapper -->
</body>

</html>
