<?php

include ('../controller/auth.php');



require "../model/language_functions.php";


$kod=$_GET['kod'];


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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah anda pasti untuk padam maklumat ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }


        // -->
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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Terjemahan</h1>
            </div>
            <div class="panel-heading" align="right">
                <a href="bahasa_senarai_terjemahan.php" class="btn btn-success">Kemballi</a>
            </div>

            <!-- /.modal -->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form method="post" action="../controller/language_exec.php">
                            <input class="form-control" type="hidden" name="action" value="edit_terjemahan">
                            <div class="form-group" align="left">
                                <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>


                                <div class="form-group" align="left">
                                    <label>Kod Perkataan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="kod" value="<? echo $kod;?>" placeholder="btn_log_masuk" readonly required>
                                </div>
                                <?
                                $data = getJenisBahasa();
                                while($jenis = $data->fetch_assoc()) {
                                    ?>
                                    <div class="form-group" align="left">
                                        <label>Terjemahan <? echo $jenis['locale_name']?></label>
                                        <input class="form-control" type="text" name="<? echo $jenis['local_kod'];?>" value="<? echo getTranslation($kod,$jenis['local_kod'])?>">
                                    </div>
                                <?}?>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
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
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

</script>

</body>

</html>
