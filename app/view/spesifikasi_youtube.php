<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";

$id = $_GET['id'];

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
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
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
        $flagScreen="tab_7";
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
                        Maklumat Youtube : <b>
                            <?
                            $i=1;
                            $datas = getTajukGambar($id);
                            while($row_datas = $datas->fetch_assoc()){
                                echo $row_datas['nama_spec'];
                            }
                            $i++;
                            ?>
                        </b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Video</th>
                                <th>Nama Video</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/spesifikasi_exec.php?id=<? echo $id; ?>&act=spesifikasi_youtube_add" >

                                    <input type="hidden" class="form-control" name="project_code" id="project_code" value="<?echo $data['project_code']?>">
                                    <td>&nbsp;</td>
                                    <td>  <input type="text" class="form-control" name="youtube_link" id="youtube_link" placeholder="youtube link">  </td>
                                    <td> <input type="text" class="form-control" name="youtube_name" id="youtube_name"  placeholder="youtube name">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $log = getVideoDetail($id);
                            while($list = $log->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td class="align-center"><? echo $i;?></td>
                                    <td>
                                        <iframe width="300" height="150" src="https://www.youtube.com/embed/<? echo $list['youtube_link'];?>" frameborder="0" gesture="media" allow="encrypted-media"></iframe>
                                    </td>
                                    <td><? echo $list['youtube_name'];?></td>
                                    <td class="align-center">
                                        <input class="btn btn-warning" type="submit" value="Tonton Tutorial" onclick="return popitup('https://www.youtube.com/watch?v=<? echo $list['youtube_link'];?>')" />
                                        <br>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal<? echo $list['id']?>">Kemaskini</button>
                                        <br>
                                        <a href="../controller/spesifikasi_exec.php?act=spesifikasi_youtube_delete&id_youtube=<? echo $list['id']; ?>&id=<? echo $id?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button></a>
                                    </td>


                                    <div class="modal fade" id="myModal<? echo $list['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Video</h4>
                                                </div>


                                                <div class="modal-body">
                                                    <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_youtube_update&id_youtube=<? echo $list['id']; ?>&id=<?echo $id?>" >


                                                        <div class="form-group" align="left">
                                                            <label>Link Video</label>
                                                            <input type="text" class="form-control" name="youtube_link" id="youtube_link" placeholder="youtube link" value="<?echo $list['youtube_link'];?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Nama Video</label>
                                                            <input type="text" class="form-control" name="youtube_name" id="youtube_name" placeholder="youtube name" value="<?echo $list['youtube_name'];?>">
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

<!-- Modal -->



<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>

