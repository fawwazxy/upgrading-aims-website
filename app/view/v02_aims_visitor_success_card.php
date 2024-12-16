<?php
require "../model/v02_aims_visitor_function.php";
$current_year = date('Y');
$sys = getSys(1) -> fetch_assoc();
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
        html{
            height: 100%;
        }
        body{
            background: url("../../resources/images/login-background.jpg") no-repeat fixed center;
            background-size: cover;
            height: 100%;
            width: 100%;
        }
        .app-logo{
            height: 150px;
            width: auto;
            border-radius: 8px;
            box-shadow: 10px 10px 8px #696969;
        }
        .tagline{
            margin: 4px 0 16px;
            font-style: italic;
        }
        .input-label{
            margin-right: 16px;
            padding-top: 4px;
            align-items: end;
        }
        .my-1{
            margin-top: 8px;
            margin-bottom: 8px;
        }
        .cancel-link{
            color: #a50001;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
        .form-row{
            margin-bottom: 0;
        }
        .form-group.row > div{
            padding: 0 4px
        }
    </style>
</head>
<body>
<h1 class="text-center" style="margin: 0; padding: 48px 0 24px">
    <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo">
</h1>
<h1 style="margin-bottom: 4px" class="text-center"><? echo $sys['sys_name'] ?></h1>
<p class="tagline text-center text-muted"><? echo $sys['sys_tagline'] ?></p>
<div class="container">
    <div class="row">
        <? include "../global/it_announcement.php"; ?>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" style="box-shadow: 0 0 12px 4px #696969;">
                <div class="panel-heading">
                    <h3 class="text-center" style="margin: 2px 0"><b>Contractor and Visitor Registration</h3>
                </div>
                <div class="panel-body text-center">
                    Registration successful
                </div>
            </div>
        </div>
    </div>
    <? include ('../global/footer.php'); ?>
</div>
</body>
</html>
