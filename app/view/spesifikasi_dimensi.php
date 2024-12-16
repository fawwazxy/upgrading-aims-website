<?php

include ('../controller/auth.php');

require "../model/spesifikasi_function.php";

?>

<?

$id_specs_details = $_GET['id'];

?>

<style>
    div.ex1 {
        height: 500px;
        overflow: scroll;
    }
</style>

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

<body data-spy="scroll" data-target=".scroll">

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

        $flagScreen="tab_3";
        include ('../global/menu_spesifikasi.php');

        ?>

        <div class="row">
        </div>




        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Dimensi : <b>
                            <?
                            $i=1;
                            $datas = getTajukGambar($id_specs_details);
                            while($row_datas = $datas->fetch_assoc()){
                                echo $row_datas['nama_spec'];
                            }
                            $i++;
                            ?>
                        </b>
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Dimensi</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_dimensi_add&id=<?echo $id_specs_details;?>">
                                    <td>&nbsp;</td>

                                    <td><input class="form-control" name="details" id="details"> </td>
                                    <td>

                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $dimensi_data = getDimensi($id_specs_details);
                            while($dimensi = $dimensi_data->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $dimensi['details']; ?>x</td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?echo $dimensi['id'];?>">Kemaskini</button>
                                        <a href="../controller/spesifikasi_exec.php?act=spesifikasi_dimensi_delete&id=<? echo $dimensi['id'];?>&id_specs_details=<?echo $id_specs_details;?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>


                                    </td>

                                    <div class="modal fade" id="myModal<?echo $dimensi['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Dimensi</h4>
                                                </div>


                                                <div class="modal-body">
                                                    <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_dimensi_edit&id_dimensi=<? echo $dimensi['id']; ?>" >

                                                        <input type="hidden" class="form-control" name="id_specs_details" id="id_specs_details" value="<?echo $id_specs_details;?>">


                                                        <div class="form-group" align="left">
                                                            <label>Dimensi</label>
                                                            <input type="text" class="form-control" name="details" id="details" value="<?echo $dimensi['details'];?>">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                        </div>
                                                    </form>
                                                </div><!--modal-body-->

                                            </div>
                                            <!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <? include ('../global/footer.php'); ?>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->





<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>

</html>

