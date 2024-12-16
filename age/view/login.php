<?php
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
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Niconne&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&family=Niconne&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/app_logo.png" />
    <? require "../global/header.php"; ?>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background: url("../../resources/images/mvaishah.jpeg") no-repeat fixed center;
            background-size: cover;
        }
        .containerz {
            box-shadow: 3px 33px 43px black ;
            display: flex;
            border-radius: 10px;
            margin-left:60px;
            margin-right:60px;
            margin-top:8%;
            margin-bottom:8%;
        }
        .content {
            flex: 50%;
            background-color: white;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }
        .imagerz {
            flex: 50%;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)));
            background-size: cover;
            text-align:center;
            color: white;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            backdrop-filter: blur(5px);
        }
        .content h4 {
            padding: 30px;
            padding-top: 20px;
            font-family: 'Candara', cursive;
            font-size: 30px;
            color: #FF8C00;
            text-align:center;
        }
        #txt {
            margin: 10px;
            padding: 5px;
            border: none;
            background-color: #FFF0F5;
            border-radius: 10px;
            font-weight: bold;
            font-size: small;
            font-family: 'Montserrat', sans-serif;
            color: black;
        }
        .button1 {
            padding: 10px 40px;
            margin-top: 20px;
            border: none;
            background: linear-gradient(to right, 	#FFA500, #FF4500);
            border-radius: 20px;
            transition: 0.3s;
            color: white;
        }
        .button1:hover {
            transform: scale(1.2);
        }
        .bg-image {
            /* The image used */
            /* Add the blur effect */
            filter: blur(8px);
            -webkit-filter: blur(8px);
        }
        footer {
            background-color: #FF8C00;
            width: 100%;
        }
        .app-logo{
            height: 180px;
            width: auto;
            border-radius: 8px;
            box-shadow: 10px 10px 8px #696969;
        }
    </style>
</head>
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>
<div class="container">
    <div class="containerz">
        <div class="imagerz">
            <br><br><br>
            <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo" style="width: 300px; height: 300px">
        </div>
        <div class="content">
            <h4>Aims Global Engineering Ship Management System &nbsp;(Version:AIMS001-01)</h4>
            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    <div class="panel-body">
                        <form role="form" action="../controller/login_exec.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    <input class="form-control" placeholder="Name" id="username" name="username" type="text" required/>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" placeholder="Password" id="password" name="password" type="password" required/>
                                </div>
                                <input type="submit" class="button1" style="float: right" value="Login"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<footer>
    <h5><? include ('../global/footer.php'); ?></h5>
</footer>
</body>
</html>