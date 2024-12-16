<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";
// $page = $_SERVER['PHP_SELF'];
// $sec = "10";
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    <?php
    echo "Watch the page reload itself in 10 second!";
    ?>
    </body> -->

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
        <!--<?include '../global/menu_lkp_pengusaha.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Kad Pelawat</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>
        <div class="form-group" align="right">
            <a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="0">Tambah Baharu</a>
            <a class="view" target="blank" href="lawatan_kad_cetak_semua.php"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Semua Kad</button></a>
            <a class="view" target="blank" href="lawatan_kad_cetak_pilihan.php"><button class="btn btn-warning hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Kad Pilihan</button></a>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Kad Pelawat</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">Bil</th>
                                <th width="15%">Kod</th>
                                <th width="25%">Jenis Kad</th>
                                <th width="25%">Nama Kad</th>
                                <th width="15%">Jum. Cetakan</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $kad_pelawat = getKadPelawatList();
                            $i=1;
                            while($list_kad_pelawat = $kad_pelawat->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><?echo $i++;?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><b><?echo $list_kad_pelawat['kod_kad'].'</b>';?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><?echo $list_kad_pelawat['jenis_kad'];?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><?echo $list_kad_pelawat['nama_kad'];?></td>
                                    <td href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><center><strong><font size="5" color="blue"><?echo $list_kad_pelawat['status_cetak'];?></font></strong></center></td>
                                    <td>
                                        <a href="#myModal3" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>"><button type="button" class="btn btn-info">Papar Maklumat</button></a>
                                        <a class="view" target="blank" href="lawatan_kad_cetak.php?id_kad=<?echo $list_kad_pelawat['id_kad'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Kad</button></a>
                                        <a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_kad_pelawat['id_kad'];?>">Kemaskini</a>
                                        <input id="rowid" name="rowid" type="hidden" value="<?echo $list_kad_pelawat['id_kad'];?>"/>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Kad Pelawat</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'lawatan_kad_tambah.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Kad Pelawat</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'lawatan_kad_kemaskini.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Kad Pelawat</h4>
                </div>
                <div class="modal-body" id="demo3">
                    <script type="text/javascript">
                        $('#myModal3').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'lawatan_kad_info.php',
                                data:{id_kad:rowid},
                                success:function(html){
                                    $('#demo3').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

    </script>

</body>

</html>