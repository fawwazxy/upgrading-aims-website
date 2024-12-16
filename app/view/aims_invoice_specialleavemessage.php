<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";

$staff_holiday_id = $_GET['staff_holiday_id'];
$no_staff = $_GET['no_staff'];
$leave_approval = $_SESSION['SESS_NO_STAFF'];
$code = $_GET['code'];
$approvement = $_GET['approvement'];
if (!isset($approvement) && $approvement == '') {
    $approvement = 'IN PROGRESS';
}
$support = $_GET['support'];
if (!isset($support) && $support == '') {
    $support = 'TIADA';
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

        <div class="paper">
            <h1>REMINDER</h1>
            <p>This section can only be access by person in charge for Invoice</p>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

<!-- /#wrapper -->




<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Adakah anda pasti untuk padam Peranan ini?');
    }


</script>

</body>

</html>
