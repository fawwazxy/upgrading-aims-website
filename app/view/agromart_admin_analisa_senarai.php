<?php
include ('../controller/auth.php');
require "../model/agromart_functions.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$current_month=date("m");
$current_date=date("d");
$date_today = $current_year."-".$current_month."-".$current_date;
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
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../../app/global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Pilihan Analisa</h1>
            </div>
            <div class="panel-heading" align="center">
                <a class="view" href="agromart_admin_analisa_stok_semasa.php" target="blank"><button type="button" class="btn btn-success">Analisa Stok Semasa</button></a>
                <a class="view" href="agromart_admin_analisa_stok.php" target="blank"><button type="button" class="btn btn-success">Analisa Stok Terjual Bulanan / Mingguan / Harian</button></a>
                <a class="view" href="agromart_admin_analisa_jualan_semasa.php" target="blank"><button type="button" class="btn btn-primary">Analisa Jualan Semasa</button></a>
                <a class="view" href="agromart_admin_analisa_jualan.php" target="blank"><button type="button" class="btn btn-primary">Analisa Jualan Bulanan / Mingguan / Harian</button></a>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>