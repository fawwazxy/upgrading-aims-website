<?php

include ('../controller/auth.php');

require "../model/projek_analisa_functions.php";
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
<script type="text/javascript">
    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=800,width=1280');
        if (window.focus) {newwindow.focus()}
        return false;
    }
</script>

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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Analisa Tugasan</h1>
            </div>

            <div class="panel-heading" align="center">
                <br><br><a class="btn btn-primary" onClick="popitup('projek_analisa_keseluruhan.php')" target="blank">Analisa Semasa Projek</a>
                <br><br><a class="btn btn-success" onClick="popitup('projek_analisa.php')" target="blank">Analisa Semasa Tugasan Mengikut Projek</a>
                <br><br><a class="btn btn-warning" onClick="popitup('projek_analisa_staff.php')" target="blank">Analisa Semasa Tugasan Staf</a>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>