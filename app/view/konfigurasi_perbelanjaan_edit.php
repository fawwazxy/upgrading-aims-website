<?php

include ('../controller/auth.php');

require "../model/perbelanjaan_functions.php";

?>
<?
//$id=$_GET['id'];
$id=$_GET['id'];


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
        <?
        $flagScreen="tab_4";
        include ('../global/menu_perbelanjaan.php');

        ?>

        <?
        $flagScreen="tab_1";
        include ('../global/menu_konfigurasi_rekod_perbelanjaan.php');

        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Perbelanjaan</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">

                                <form method="post" action="../controller/konfigurasi_perbelanjaan_edit_exec.php?id=<? echo $id; ?>" enctype="multipart/form-data" >


                                    <?

                                    $konfigurasi_perbelanjaan = getNamaPerbelanjaanInfo($id)->fetch_assoc();

                                    ?>
                                    </br>
                                    <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />



                                    <div class="form-group" align="left">
                                        <label>Nama Perbelanjaan</label>
                                        <input class="form-control" placeholder=" " id="description" name="description" required autocomplete="" type="text" value="<? echo $konfigurasi_perbelanjaan['description']; ?>">
                                    </div>


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" onclick="return alert('Data telah dikemaskini');">Simpan</button></a>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                    </div>
                            </div>

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
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div></div>
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
