<?php

include ('../controller/auth.php');

require "../model/perbelanjaan_functions.php";

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


    <script language="javascript" type="text/javascript">


    </script>

</head>

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

        <?
        $flagScreen="tab_2";
        include ('../global/menu_perbelanjaan.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Analisa Perbelanjaan</h1>
            </div>
        </div>
        <!-- <div class="row">
        <div class="col-lg-12">
            <div class="panel-heading" align="right">
                <a href="analisa_add.php">
                <button class="btn btn-primary">Tambah Baru</button>
                </a>
            </div> -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Senarai Analisa
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Analisa</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr class="odd gradeX">
                        <td>Analisa Mengikut Kaedah Bayaran</td>
                        <td>
                            <a href="../report/analisa_mengikut_kaedah_bayaran.php">
                                <button type="button" class="btn btn-info">Analisa</button>
                            </a>
                        </td>
                    </tr>

                    <tr class="odd gradeX">
                        <td>Analisa Mengikut Jenis Perbelanjaan</td>
                        <td>
                            <a href="../report/analisa_mengikut_jenis_perbelanjaan.php">
                                <button type="button" class="btn btn-info">Analisa</button>
                            </a>
                        </td>
                    </tr>

                    <tr class="odd gradeX">
                        <td>Analisa Mengikut Nama Penerima</td>
                        <td>
                            <a href="../report/analisa_mengikut_nama_penerima.php">
                                <button type="button" class="btn btn-info">Analisa</button>
                            </a>
                        </td>
                    </tr>

                    <tr class="odd gradeX">
                        <td>Analisa Nama Penerima Mengikut Bulan</td>
                        <td>
                            <a href="../report/analisa_nama_penerima_mengikut_bulan.php">
                                <button type="button" class="btn btn-info">Analisa</button>
                            </a>
                        </td>
                    </tr>

                    <tr class="odd gradeX">
                        <td>Analisa Keseluruhan Rekod Perbelanjaan</td>
                        <td>
                            <a href="../report/analisa_keseluruhan_rekod_perbelanjaan.php" target="_blank">
                                <button type="button" class="btn btn-info">Analisa</button>
                            </a>
                        </td>
                    </tr>

                    </tbody>

                </table>

            </div>

            <!-- /.panel-body -->
        </div>
        <? include ('../global/footer.php'); ?>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


<!-- /.row -->
<!-- /.container-fluid -->
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
