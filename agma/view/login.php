<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        html{
            height: 100%;
        }
        body{
            background: url("../../resources/images/login-background.jpg") no-repeat fixed center;
            background-size: cover;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }
        .app-logo{
            height: 180px;
            width: auto;
            border-radius: 8px;
            box-shadow: 10px 10px 8px #696969;
        }
        .input-label{
            margin-right: 16px;
            padding-top: 4px;
            align-items: end;
        }
        h3 {
            font-size: 19px;
            color: #FF8C00;
            text-align:center;
        }
        .btn-login {
            padding: 10px 40px;
            border: none;
            background: linear-gradient(to right, #FFA500, #FF4500);
            border-radius: 20px;
            transition: 0.3s;
            color: white;
        }
        .btn-login:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default" style="box-shadow: 0 0 12px 4px #696969; margin-top: 20%; padding: 10px">
                <div class="panel-heading">
                    <h1 class="panel-title text-center"><b>WAREHOUSE MANAGEMENT SYSTEM</b></h1>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <h1 class="text-center" style="margin: 0; padding: 18px 0 24px">
                            <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo">
                        </h1>
                        <h3>AIMS-GLOBAL MARITIME SDN BHD</h3>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="#">
                            <div class="col-md-12">
                                <label for="username">Name</label>
                                <input class="form-control" placeholder="Name" id="username" name="username" type="text" required/>
                            </div>
                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input class="form-control" placeholder="Password" id="password" name="password" type="password" required/>
                            </div>
                            <div class="col-md-12" style="margin-top: 8px;margin-bottom: 8px;">
                                <input type="checkbox" name="show_password" value="" id="show_password" style="padding-top: 4px">
                                <label for="show_password" class="input-label">
                                    Show Password
                                </label>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btn-login" style="float: right" value="Login"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<footer>
    <? include "../global/footer.php"; ?>
</footer>
<script type="text/javascript">
    $(document).ready(function(){
        $('#show_password').on('change', function(){
            $('#password').attr('type',$('#show_password').prop('checked')===true?"text":"password");
        });
    });
</script>
</body>
</html>