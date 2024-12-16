<?php
include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$name = $_SESSION['SESS_NAME'];
$sys = getSys(1)-> fetch_assoc();
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
<script src='https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500&display=swap'></script>
<script language="javascript" type="text/javascript">
    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>
<style>

    * {
        box-sizing: border-box;
        font-family: 'Quicksand', sans-serif;
    }

    html,
    body {
        margin: 0;
    }

    .full-screen-container {
        background-image: url('https://www.timescar-rental.com/images/top/top_ph002.png');
        height: 100vh;
        width: 98.9vw;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        background: url('https://www.mprc.gov.my/sites/default/files/styles/medium/public/directories-logo/aims_logo.png?itok=VRmQNKpL');
        background-repeat: no-repeat;
        background-position: top right;
        padding: 80px 20px;
        min-width: 400px;
        width: 50%;
        max-width: 600px;
        margin-left: 50px;
    }

    .login-title {
        color: #fff;
        text-align: center;
        margin: 0;
        margin-bottom: 40px;
        font-size: 2.5em;
        font-weight: normal;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .input-group label {
        color: #fff;
        font-weight: lighter;
        font-size: 1.5em;
        margin-bottom: 7px;
    }

    .input-group input {
        font-size: 1.5em;
        padding: 0.1em 0.25em;
        background-color: hsla(201, 100%, 91%, 0.3);
        border: 1px solid hsl(201, 100%, 6%);
        outline: none;
        border-radius: 5px;
        color: #fff;
        font-weight: lighter;
    }

    .input-group input:focus {
        border: 1px solid hsl(201, 100%, 50%);
    }

    .login-button {
        padding: 10px 30px;
        width: 100%;
        border-radius: 8px;
        background: hsla(201, 100%, 50%, 0.1);
        border: 1px solid hsl(201, 100%, 50%);
        outline: none;
        font-size: 1.5em;
        color: #fff;
        font-weight: lighter;
        margin-top: 20px;
        cursor: pointer;
    }

    .login-button:hover {
        background-color: hsla(201, 100%, 60%, 0.3);
    }

    .login-button:focus {
        background-color: hsla(201, 100%, 60%, 0.5);
    }

    .login-container h1 {
        font-size: 30px;
        padding: 10px;
        text-align: left;
        font-family: "Lucida Console", "Courier New", monospace;
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



    <div class="full-screen-container">
        <div class="login-container">
            <h1> Login Car Inspection</h1><br><br>
            <form role="form" action="../controller/aims_login_car_exec.php?name=<?php echo $name?>" method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username"/>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" />
                </div>
                <button type="submit" class="login-button" >Sign In</button>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>


</div>


<!-- Modal -->

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>

</body>

</html>