<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_3';
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
                <h1 class="page-header">Senarai Transaksi Pinjaman</h1>
                <div id='cssmenu'>
                    <ul>
                        <!--<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_kategori_senarai.php">Kategori</a></li>
                            <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_kandungan_senarai.php">Kandungan Digital</a></li>-->
                        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="library_transaksi_pinjaman_senarai.php?status=0">Pinjaman</a></li>
                        <li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="library_transaksi_tempahan_senarai.php?status=0">Tempahan</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>
        <!--<div class="form-group" align="right">
            <a href="library_peminjam_bermasalah.php" ><button type="button" class="btn btn-danger">Senarai Peminjam Bermasalah</button></a>
        </div>-->

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">

                        <a href="library_transaksi_pinjaman_senarai.php">Senarai Transaksi Pinjaman</a> &nbsp;|&nbsp;
                        <a href="library_transaksi_pinjaman_senarai.php?status=0">Belum Dihantar</a> &nbsp;|&nbsp;
                        <a href="library_transaksi_pinjaman_senarai.php?status=1">Telah Dihantar</a>


                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="30%">Maklumat Peminjam</th>
                                <th width="30%">Bahan Pinjaman</th>
                                <th width="20%">Tarikh Transaksi</th>
                                <!--<? if($status==1 || $status=='0'){?>
                                        <th>Tindakan</th>
                                        <?}?>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($status=='') {
                                $pinjaman = getTransaksiPinjaman();
                            }
                            else{
                                $pinjaman = getTransaksiPinjamanList($status);
                            }
                            $i=1;
                            while($list_pinjaman = $pinjaman->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Nama :</label><br><a href="#myModal2" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_pinjaman['nokp'];?>"><?echo $list_pinjaman['nama'] ;?></a>
                                        <br><label class="control-label" for="date">No. Kad Pengenalan :</label><br><?echo $list_pinjaman['nokp'] ;?>
                                        <br><label class="control-label" for="date">No. Telefon :</label><br><strong><font color="brown" size="4">+6<?echo $list_pinjaman['notel'] ;?></font></strong>
                                    </td>
                                    <td>
                                        <label class="control-label" for="date">Tajuk :</label><br><a href="#myModal3" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_pinjaman['id_kandungan'];?>"><?echo $list_pinjaman['nama_kandungan_digital'] ;?></a>
                                        <br><label class="control-label" for="date">Kategori :</label><br><?echo $list_pinjaman['jenis'] ;?>
                                    </td>

                                    <td><label class="control-label" for="date">Tarikh Pinjam :</label><br><?echo date("d F Y",strtotime($list_pinjaman['tarikh_pinjam'])); ?>
                                        <? if($status==1 || $status==''){
                                            if($list_pinjaman['tarikh_hantar']==''){
                                                echo '<br><br><strong>Tarikh Akhir Hantar :<br><font color="red">'.date("d F Y",strtotime($list_pinjaman['tarikh_akhir'])).'</font></strong>';
                                            }
                                            else{
                                                echo '<br><br><strong>Tarikh Hantar :<br><font color="green">'.date("d F Y",strtotime($list_pinjaman['tarikh_hantar'])); }?>
                                        <?}?>
                                    </td>
                                    <!--<? if($status==1 || $status=='0'){?>
                                        <td>
                                            <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<? echo $list_pinjaman['id'];?>">Kemaskini</a>
                                            <?if($status=='0' && $current_date >= $list_pinjaman['tarikh_akhir'] ){?>
                                                <a button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=6<?php echo $list_pinjaman['notel']; ?>&text=<? echo "*".$sys['sys_name']."::Notis Pemulangan Pinjaman*"?>%0aNama Peminjam : *<?echo $list_pinjaman['nama']?>*%0aNo. Kad Pengenalan : *<?echo $list_pinjaman['nokp']?>*%0aNama Buku : *<?echo $list_pinjaman['nama_kandungan_digital']?>*%0aTarikh Pinjam : *<?echo date("d-m-Y",strtotime($list_pinjaman['tarikh_pinjam']))?>*%0aTarikh Akhir Penghantaran : *<?echo date("d-m-Y",strtotime($list_pinjaman['tarikh_akhir']))?>*%0aSila buat penghantaran dengan kadar yang segera bagi mengelakkan sebarang kesulitan.')">WhatsApp</button></a>
                                            <?}?>
                                            <a href="library_kemaskini_kandungan.php?id=<?echo $list_kandungan['id'] ;?>" ><button type="button" class="btn btn-info">Kemaskini</button></a>
                                        </td>
                                        <?}?>-->
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