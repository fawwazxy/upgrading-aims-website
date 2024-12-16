<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_2';

if(isset($_GET['status'])) {
    $status = $_GET['status'];
}else {
    $status = 1;
}

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
                <h1 class="page-header">PEMULANGAN</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_pinjaman_senarai.php">Pinjaman</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_pemulangan_senarai.php?status=1">Pemulangan</a></li>
                        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="library_tempahan_pinjam.php?status=0">Tempahan</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>
        <div class="form-group" align="right">
            <a class="view" href="library_imbas_pemulangan.php" target="blank"><button type="button" class="btn btn-success">Terminal Imbasan Pemulangan</button></a>
            <a class="btn btn-warning" onClick="popitup('library_senarai_bahan.php')" target="blank">Carian Bahan Bacaan</a>

            <!--<a href="library_peminjam_bermasalah.php" ><button type="button" class="btn btn-danger">Senarai Peminjam Bermasalah</button></a>-->
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Pemulangan</label>&nbsp;

                        <a href="library_pemulangan_senarai.php?status=1">Telah Dihantar</a> &nbsp;|&nbsp;
                        <a href="library_pemulangan_senarai.php?status=0">Belum Dihantar</a>
                        <!--<a href="library_pemulangan_senarai.php?status=">Senarai Transaksi Pemulangan</a>-->

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="30%">Maklumat Peminjam</th>
                                <th width="25%">Bahan Pinjaman</th>
                                <th width="25%">Tarikh Transaksi</th>
                                <th width="15%">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($status=='') {
                                $peminjam = getJumlahPeminjam();
                            }
                            else{
                                $peminjam = getPeminjamList($status);
                            }
                            $i=1;
                            while($list_peminjam = $peminjam->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Nama :</label><br><a href="#myModal2" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_peminjam['nokp'];?>"><?echo $list_peminjam['nama'] ;?></a>
                                        <br><label class="control-label" for="date">No. Kad Pengenalan :</label><br><?echo $list_peminjam['nokp'] ;?>
                                        <br><label class="control-label" for="date">No. Telefon :</label><br><strong><font color="brown" size="4">+6<?echo $list_peminjam['notel'] ;?></font></strong> </td>
                                    <td><label class="control-label" for="date">Tajuk :</label><br><a href="#myModal3" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_peminjam['id_kandungan'];?>"><?echo $list_peminjam['nama_kandungan_digital'] ;?></a><br><label class="control-label" for="date">Kategori :</label><br><? echo $list_peminjam['jenis'];?>
                                        <br><label class="control-label" for="date">No. Rujukan Naskah :</label><br><?echo 'elib-'.$list_peminjam['id_kandungan'].'-'.$list_peminjam['id_naskah'] ;?>
                                    </td>

                                    <td><label class="control-label" for="date">Tarikh Pinjam :</label><br><strong><font color="blue"><?echo date("d F Y",strtotime($list_peminjam['tarikh_pinjam'])); ?></font></strong>
                                        <? if($status==1){
                                            echo '<br><br><strong>Tarikh Hantar :<br><font color="green">'.date("d F Y",strtotime($list_peminjam['tarikh_hantar']));
                                            echo '<td><strong><font color="green" size="3">'.'Telah Dihantar'.'</font></strong>';
                                            if($list_peminjam['tarikh_hantar'] > $list_peminjam['tarikh_akhir']){
                                                echo '<br><strong><font color="red">**&nbsp;Melebihi Tempoh Pinjaman&nbsp;**</font></strong>';
                                            }
                                        }else{
                                            if($list_peminjam['tarikh_hantar']==''){
                                                echo '<br><br><strong>Tarikh Akhir Hantar :<br><font color="red">'.date("d F Y",strtotime($list_peminjam['tarikh_akhir'])).'</font></strong>';
                                                ?>

                                                <form method="post" action="../controller/library_peminjam_exec.php" >
                                                <input type="hidden" name="action" value="updateTarikhHantar"/>
                                                <input type="hidden" name="created_by" value="<?echo $_SESSION['SESS_ID'];?>" />
                                                <input type="hidden" name="id_pinjaman" value="<?echo $list_peminjam['id'];?>" />
                                                <br><div class="form-group">
                                                <label class="control-label">Tarikh Pemulangan</label>
                                                <br><input type="date" class="form-control" name="tarikh_hantar" id="tarikh_hantar">
                                                <br><br><button type="submit" class="btn btn-primary">Sahkan Pemulangan</button>
                                                <?
                                                echo '<td><strong><font color="red" size="3">'.'Belum Dihantar'.'</font></strong>';
                                                if($current_date > $list_peminjam['tarikh_akhir']){
                                                    echo '<br><strong><font color="red">**&nbsp;Melebihi Tempoh Pinjaman&nbsp;**</font></strong>';
                                                }
                                            }?>

                                            </div>
                                            </form>
                                        <?}?>


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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Peminjam</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_kemaskini_peminjam.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo').html(html);
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
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">Maklumat Terperinci Bahan Digital</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_digital_details.php',
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