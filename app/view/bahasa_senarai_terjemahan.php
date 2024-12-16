<?php

include ('../controller/auth.php');



require "../model/language_functions.php";


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
                <h1 class="page-header">Konfigurasi Bahasa</h1>
            </div>
            <div class="panel-heading" align="right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah</button></a>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" align="left" id="myModalLabel">Tambah Terjemahan</h4>
                        </div>

                        <div class="modal-body">

                            <form method="post" action="../controller/language_exec.php">
                                <input class="form-control" type="hidden" name="action" value="add_terjemahan">
                                <div class="form-group" align="left">
                                    <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>
                                    <label>Kod Bahasa<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="locale" value="" placeholder="ms" required>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Bahasa<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="locale_name" value="" placeholder="Melayu" required>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Kod Perkataan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="kod" value="" placeholder="btn_log_masuk" required>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Terjemahan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="translation" value="" placeholder="log masuk" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>
                            </form>
                        </div><!--modal-body-->

                    </div>
                    <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Terjemahan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th >kod</th>
                                <?
                                $data = getJenisBahasa();
                                while($jenis = $data->fetch_assoc()) {
                                    ?>
                                    <th><? echo $jenis['locale_name']." (".$jenis['local_kod'].")";?></th>
                                <?}?>
                                <th >Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i=1;
                            $data_bahasa = getTerjemahan();
                            while($bahasa = $data_bahasa->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td><? echo $bahasa['kod'];?></td>
                                    <?
                                    $data_jenis = getJenisBahasa();
                                    while($jenis_bahasa = $data_jenis->fetch_assoc()) {
                                        $locale_kod=$jenis_bahasa['local_kod'];
                                        ?>
                                        <td><? echo $bahasa[$locale_kod];?></td>
                                    <?}?>
                                    <td><a href="kemaskini_terjemahan_bahasa.php?kod=<? echo  $bahasa['kod']?>" class="btn btn-info">Kemaskini</a></td>
                                </tr>


                                <?$i++;}?>
                            </tbody>

                        </table>

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
