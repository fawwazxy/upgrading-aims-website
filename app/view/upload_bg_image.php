<?php
include ('../controller/auth.php');
require "../model/gambar_functions.php";
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
                <h1 class="page-header">Kad Pekerja</h1>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Upload gambar
                    </div>
                    <!-- /.panel-heading -->


                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <tr>
                                <form method="post" action="../controller/background_upload_exec.php?act=background_hadapan" enctype="multipart/form-data">
                                    <th>Gambar Latar Belakang <br> (Hadapan)

                                    </th>

                                    <td><center>
                                            <?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['kad_depan_img'] ).'" width="204.01889764px" height="323.52755906px"/>';?>
                                            <br><font size="3"> 53.98mm x 85.60mm</font></center>
                                    </td>
                                    <td><input type="file" name="image" placeholder="" value="10000"> <br> Max size 2MB</td>
                                    <td>
                                        <button type="submit" name="uploadImage" class="btn btn-primary">Muat Naik</button></a>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form method="post" action="../controller/background_upload_exec.php?act=background_belakang" enctype="multipart/form-data">
                                    <th>Gambar Latar Belakang <br> (Belakang)

                                    </th>

                                    <td><center><?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['kad_belakang_img'] ).'" width="204.01889764px" height="323.52755906px"/>';?>

                                            <br><font size="3"> 53.98mm x 85.60mm</font></center>
                                    </td>
                                    <td><input type="file" name="image" placeholder="" value="10000"> <br> Max size 2MB</td>
                                    <td>
                                        <button type="submit" name="uploadImage" class="btn btn-primary">Muat Naik</button></a>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </td>
                                </form>
                            </tr>

                        </table>


                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <? include ('../global/footer.php'); ?>
        <!-- /.row -->
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
