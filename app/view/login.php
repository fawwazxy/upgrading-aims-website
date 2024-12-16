<?php session_start();
if(isset($_SESSION['SESS_ID']) && (trim($_SESSION['SESS_ID']) != '')) {
    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit();
}
require "../model/functions.php";

$start_close = strtotime('2022-09-29 20:00:00');
$end_close =  strtotime('2022-09-29 23:00:00');

if (time() > $start_close && time() < $end_close){
    echo "<h1 style='margin: 0 35% ; text-align: center'>
    System currently under maintenance from 8.00pm until 11.00pm
    </h1>";
    exit();
}
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
            height: 180px;
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
                    <h3 class="panel-title">Log Masuk Sistem</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="../controller/login_exec.php" method="POST">
                        <div class="form-inline row my-1">
                            <div class="col-md-4">
                                <label for="username" class="input-label">Nama&nbsp;Pengguna </label>
                            </div>
                            <div class="col-md-8">
                                <input class="col-md-8 form-control" placeholder="Nama Pengguna" name="username"
                                       id="username" type="text" maxlength="12" required autofocus>
                            </div>

                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-4">
                                <label for="password" class="input-label">Kata&nbsp;laluan</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" placeholder="Kata laluan" name="password" id="password" type="password" required>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-8 col-md-offset-4">
                                <input type="checkbox" name="show_password" value="" id="show_password" style="padding-top: 4px">
                                <label for="show_password" class="input-label">
                                    Tunjukkan kata laluan
                                </label>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Log Masuk"/>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-12 text-center">
                                <a href="../view/dummy_login.php" class="text-primary">Sesi Aplikasi Sokongan</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <? include "../global/footer.php"; ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#show_password').on('change', function(){
            $('#password').attr('type',$('#show_password').prop('checked')===true?"text":"password");
        });
    });
</script>
</body>
</html>