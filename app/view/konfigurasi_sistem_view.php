<?php

include ('../controller/auth.php');

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
                <h1 class="page-header">Maklumat Konfigurasi Sistem</h1>
            </div>
        </div>
        <div class="panel-heading" align="right">
            <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Konfigurasi Sistem
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form>
                            <div class="form-group" align="left">
                                <div class="form-group" align="left">
                                    <label>Nama Sistem</label><br>
                                    <?echo $sys['sys_name']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tagline</label><br>
                                    <?echo $sys['sys_tagline']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Nama Kedai</label><br>
                                    <?echo $sys['sys_owner']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Domain</label><br>
                                    <?echo $sys['sys_domain']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Email</label><br>
                                    <?echo $sys['sys_email']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Hotline</label><br>
                                    <?echo $sys['sys_hotline']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Alamat</label><br>
                                    <?echo $sys['sys_address']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Facebook</label><br>
                                    <?echo $sys['sys_fb']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Version</label><br>
                                    <?echo $sys['version']?>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Logo</label><br>
                                    <?echo '<img border="1" width="300" height="300" src="data:image/jpeg;base64,'.base64_encode( $sys['logo'] ).'"/>';?>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Nama Logo</label><br>
                                    <?echo $sys['logo_filename']?>
                                </div>
                                <!--div class="form-group" align="left">
                                      <label>No. SSM</label><br>
                                    <?//echo $sys['sys_ssm']?>
                                </div>
                                <div class="form-group" align="left">
                                      <label>Whatsapp</label><br>
                                    <?//echo $sys['sys_whatsapp']?>
                                </div-->

                                <div class="modal-footer">
                                    <div align="left">
                                        <a href="konfigurasi_sistem_edit.php"><button class="btn btn-primary" onclick="" type="button" >Kemaskini</button></a><br><br>
                                    </div>
                                </div><br>
                        </form>
                    </div>
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
