<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_4';
$status=$_GET['status'];

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
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


    <style>
        .modal-dialog{
            overflow-y: initial;
        }
        .modal-body{
            height: 500px;
            overflow-y: auto;
        }
    </style>

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
                <h1 class="page-header">Rekod Peminjam Bermasalah</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_peminjam_rekod.php">Pinjaman</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_pemulangan_rekod.php">Pemulangan</a></li>
                        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="library_tempahan_rekod.php">Tempahan</a></li>
                        <li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="library_peminjam_bermasalah.php">Peminjam Bermasalah</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>
        <!--<div class="form-group" align="right">
            <a href="library_peminjam_senarai.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>-->
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Peminjam Bermasalah</label>

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%">Bil.</th>
                                <th width="90%">Maklumat Peminjam</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $peminjam = getPeminjamBermasalahList();
                            $i=1;
                            while($list_peminjam = $peminjam->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><label class="control-label">Nama :</label><br><a href="#myModal2" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_peminjam['nokp'];?>"><?echo $list_peminjam['nama'] ;?></a>
                                        <br><label class="control-label" for="date">No. Kad Pengenalan :</label><br><?echo $list_peminjam['nokp'] ;?>
                                        <br><label class="control-label" for="date">No. Telefon :</label><br>+6<?echo $list_peminjam['notel'] ;?>
                                    </td>
                                </tr>
                            <?}?>
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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Senarai Transaksi Pinjaman</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_transaksi_pinjaman.php',
                            data:{nokp:rowid},
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

    $(document).ready(function() {
        $('table').DataTable({
            responsive: true
        });


    });
</script>

</body>

</html>