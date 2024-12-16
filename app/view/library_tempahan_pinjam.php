<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_3';
$status=$_GET['status'];
//$id_library = $_GET['id'];
//$data_library = getLibraryById($id_library)->fetch_assoc();
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">TEMPAHAN</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_pinjaman_senarai.php">Pinjaman</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_pemulangan_senarai.php?status=1">Pemulangan</a></li>
                        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="library_tempahan_pinjam.php?status=0">Tempahan</a></li>
                    </ul>
                </div>
                <br><div class="form-group" align="right">
                    <a class="btn btn-warning" onClick="popitup('library_senarai_bahan.php')" target="blank">Carian Bahan Bacaan</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Tempahan</label>&nbsp;

                        <a href="library_tempahan_pinjam.php?status=0">Dalam Tempahan</a> &nbsp;|&nbsp;
                        <!--<a href="library_tempahan_pinjam.php?status=1">Tempahan Lulus</a> &nbsp;|&nbsp;-->
                        <a href="library_tempahan_pinjam.php?status=2">Tempahan Batal</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
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
                            $tempahan = getBookingList($status);
                            $i=1;
                            while($list_tempahan = $tempahan->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Nama :</label><br><?echo $list_tempahan['nama_peminjam'] ;?><br>
                                        <label class="control-label">No. Kad Pengenalan :</label><br><?echo $list_tempahan['nokp'] ;?><br>
                                        <label class="control-label" for="date">No. Telefon :</label><br><strong><font color="brown" size="4">+6<?echo $list_tempahan['notel'] ;?></font> </strong>
                                    </td>
                                    <td>
                                        <label class="control-label">Tajuk :</label><br><?echo $list_tempahan['nama_library'] ;?><br>
                                        <label class="control-label">Kategori :</label><br><?echo $list_tempahan['jenis'] ;?><br><br>
                                        <!--<a href="#myModal1" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_tempahan['id_tempahan'];?>">Pinjaman</a>-->
                                        <a onclick="batalTempahan(<?echo $list_tempahan['id_tempahan'] ;?>)" ><button type="button" class="btn btn-danger">Batal Tempahan</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_tempahan['id'];?>">
                                    </td>
                                    <td><label class="control-label">Anggaran Tarikh Pinjaman :</label><br><?echo date("d F Y",strtotime($list_tempahan['anggaran_tarikh_tempah']));?><br></td>
                                    <td>  <?if($list_tempahan['status_urgent']==1){?>
                                            <label class="control-label">Status Tempahan :</label><br><strong><font color="red">Segera</font></strong>
                                        <?}else{?>
                                            <label class="control-label">Status Tempahan :</label><br><strong><font color="blue">Tidak Segera</font></strong>
                                        <?}?>

                                        <?if($list_tempahan['status']==0){?>
                                            <label class="control-label">Status Semasa :</label><br><strong><font color="green">Dalam Tempahan</font></strong>
                                        <?}else{?>
                                            <label class="control-label">Status Semasa :</label><br><strong><font color="red">Tempahan Batal</font></strong>
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Pinjaman</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_peminjam_tempahan.php',
                            data:{id_tempahan:rowid},
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


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function batalTempahan(id,status){
        $.ajax({
            url: "../model/library_functions.php",
            type: "POST",
            data: {action:"batalTempahan",id:id},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='library_tempahan_pinjam.php?status=2';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>

</body>

</html>