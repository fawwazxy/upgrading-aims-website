<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["auth"]) && $_SESSION["auth"] === true){
    header("location: dashboard.php");
    exit();
}
session_destroy();
require "../model/functions.php";

// Define variables and initialize with empty values
$username = ($_POST['username']) ?: "";
$password = ($_POST['password']) ?: "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if (!empty($username) && !empty($password)) {

    // Check if username is empty
    if (empty(trim($username))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($password))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        $conn=db();
        $sql="SELECT id, username, name, no_staff, noic, department_id, department_sub, status, role_id, cawangan_kod FROM staff WHERE username = '$username' LIMIT 1";
        $staff_info = $conn->query($sql);

        if (mysqli_num_rows($staff_info) > 0){
            $staff = $staff_info->fetch_assoc();
            if (password_verify($password, '$2y$10$qmUYxOpegCp1nuf9BfaSrOqH.ZV/9X9c.L/La98mIWq6O22wGpZ8S')){

                session_start();
                $_SESSION["auth"] = true;
                $_SESSION['SESS_ID'] = $staff['id'];
                $_SESSION['SYS_ID'] = 1;
                $_SESSION['DUMMY'] = 1;
                $_SESSION['SESS_NAME'] = $staff['name'];
                $_SESSION['SESS_COM'] = 1;
                $_SESSION['SESS_STATUS'] = $staff['status'];
                $_SESSION['SESS_ROLE'] = $staff['role_id'];
                $_SESSION['SESS_NO_STAFF'] = $staff['no_staff'];
                $_SESSION['SESS_NOKP'] = $staff['noic'];
                $_SESSION['SESS_CAWANGAN'] = $staff['cawangan_kod'];
                $_SESSION['SESS_DEPARTMENT'] = $staff['department_id'];
                $_SESSION['SESS_DEPARTMENT_SUB'] = $staff['department_sub'];
                $_SESSION['SESS_NO_TELEFON'] = $staff['phone'];
                $_SESSION['SESS_EMAIL'] = $staff['email'];

                // Redirect user to welcome page
                echo "<script type='text/javascript'>
                        window.location.href = '../view/dashboard.php';
                        </script>";
            } else {
                // Password is not valid, display a generic error message
                $login_err = "Invalid username or password.";
                echo "<script type='text/javascript'> alert(\"$login_err\"); window.history.back();</script>";
            }
        }else {
            // Username doesn't exist, display a generic error message
            $login_err = "Invalid username or password.";
            echo "<script type='text/javascript'> alert(\"$login_err\"); window.history.back();</script>";
        }
    }else {
        echo "Oops! Something went wrong. Please try again later.";
    }
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
    <style>
        html{
            height: 100%;
        }
        body{
            background: url("../../resources/images/login-dummy-background.png") no-repeat fixed center;
            background-size: cover;
        }
        .app-logo{
            height: 180px;
            width: auto;
            border-radius: 8px;
            box-shadow: 10px 10px 8px #696969;
        }
        .tagline{
            margin: 4px 0 16px;
            font-style: normal;
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
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>
<h1 class="text-center" style="margin: 0; padding: 48px 0 24px">
    <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo">
    <?// echo '<img width="300" height="200" src="data:image/png;base64,'.base64_encode( $sys['logo'] ).'"/>'; ?>
</h1>
<h1 style="margin-bottom: 4px" class="text-center"><? echo $sys['sys_name'] ?></h1>
<p class="tagline text-center text-muted">Application Support Session</p>
<div class="container">
    <div class="row">
        <? include "../global/it_announcement.php"; ?>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" style="box-shadow: 0 0 12px 4px #696969;">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">
                        Log in to the Application Support Session
                        <br><small style="color: #a20000">Authorized person by IT Department only</small>
                    </h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="" method="POST">
                        <div class="form-inline row my-1">
                            <div class="col-md-4">
                                <label for="username" class="input-label">Username </label>
                            </div>
                            <div class="col-md-8">
                                <input class="col-md-8 form-control" placeholder="Username" name="username"
                                       id="username" type="text" maxlength="12" required autofocus>
                            </div>

                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-4">
                                <label for="password" class="input-label">Password</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" placeholder="Password" name="password" id="password" type="password" required>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-8 col-md-offset-4">
                                <input type="checkbox" name="show_password" value="" id="show_password" style="padding-top: 4px">
                                <label for="show_password" class="input-label">
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-lg btn-danger btn-block" value="Log In as Application Support"/>
                            </div>
                        </div>
                        <div class="form-inline row my-1">
                            <div class="col-md-12 text-center">
                                <a href="../view/login.php" ><i class="fa fa-arrow-left"></i> &nbsp; Back to main login page</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <? include ('../global/footer.php'); ?>
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