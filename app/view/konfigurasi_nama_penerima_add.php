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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tambah Nama Penerima</h1>
            </div>


            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <div class="col-lg-6">

                            <form method="post" action="../controller/konfigurasi_nama_penerima_add_exec.php?id=<? echo $id;?>" enctype="multipart/form-data" >
                                <div class="form-group" align="left">

                                    <div class="form-group" align="left">
                                        <label>Nama Penerima</label>
                                        <input class="form-control" placeholder=" "id="nama_penerima" name="nama_penerima" maxlength="50" required autocomplete="" >
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">No.Telefon</label>
                                        <input class="form-control" placeholder=" " id="notel_penerima" name="notel_penerima">
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="return alert('Adakah anda mahu menyimpan data ini?');">Simpan</button>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </div>
                            </form
                        </div></div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->


</body>

</html>
