<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
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
    <script type="text/javascript">
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Acara</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Acara Baharu</button>
                <a href="acara_senarai_acara.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Acara
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Daftar Acara</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="../controller/acara_sesi_exec.php" >
                                        <div>
                                            <label><span style="color: red; ">* Maklumat Wajib Diisi.</span></label>
                                        </div>
                                        <input id="action" name="action" type="hidden" value="add_sesi"/>
                                        <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_NAME'];?>"/>
                                        <div class="form-group">
                                            <label for="nama" class="control-label">Nama Sesi<span style="color: red; ">*</span></label>
                                            <input class="form-control" id="nama" name="nama" type="text"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="lokasi" class="control-label">Lokasi<span style="color: red; ">*</span></label>
                                            <input class="form-control" id="lokasi" name="lokasi" type="text"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="tarikh_mula" class="control-label">Tarikh Mula<span style="color: red; ">*</span></label>
                                            <input class="form-control" id="tarikh_mula" name="tarikh_mula" type="date"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="tarikh_tamat" class="control-label">Tarikh Tamat<span style="color: red; ">*</span></label>
                                            <input class="form-control" id="tarikh_tamat" name="tarikh_tamat" type="date"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahun" class="control-label">Tahun<span style="color: red; ">**</span></label>
                                            <input class="form-control" id="tahun" name="tahun" type="number"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama & Lokasi</th>
                                <th>Tarikh Mula & Tamat</th>
                                <th>Rekabentuk Pas Masuk</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data_sesi = getSesiAcara();
                            while($list_sesi = $data_sesi->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list_sesi['nama']; ?><br><?php echo $list_sesi['lokasi']; ?></td>
                                    <td><?php echo date("d M Y",strtotime($list_sesi['tarikh_mula'])); ?> hingga <?php echo date("d M Y",strtotime($list_sesi['tarikh_tamat']));?></td>
                                    <td>
                                        <? if($list_sesi['pasmasuk_filename']!=""){?>
                                            <img src="../../acara/design_pasmasuk/<? echo $list_sesi['pasmasuk_filename'];?>" style="width:120px;height:150px;">
                                        <?}?>
                                        <form method="post" action="../controller/acara_sesi_exec.php" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="upload_gambar" />
                                            <input type="hidden" name="id_sesi" value="<?echo  $list_sesi['id'];?>" />
                                            <div class="form-group">
                                                <label class="control-label">Muat Naik Gambar</label>
                                                <input accept="image/*" type="file" class="btn btn-link" name="photo" required />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <?
                                        if (checkStatusAcara($list_sesi['id'])>0){?>
                                            <h3><strong><span style="color: red; ">AKTIF</span></strong></h3>
                                            <a type="button" class="btn btn-success btn-small" target="blank" href="acara_senarai_aturcara_acara.php?id_sesi=<? echo $list_sesi['id']; ?>&tarikh=<?echo date('Y-m-d')?>">Panel Kehadiran Acara</a><br>
                                            <a type="button" class="btn btn-primary btn-small" target="blank" href="acara_daftar_online.php?id_sesi=<? echo $list_sesi['id']; ?>">Daftar Online</a><br>
                                        <?}else{?>
                                            <h3><strong><span style="color: grey; ">TIDAK AKTIF</span></strong></h3>
                                        <?} ?>
                                    </td>
                                    <td>
                                        <a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $list_sesi['id'];?>">Kemaskini</a>
                                        <a type="button" class="btn btn-warning btn-small" onClick="popitup('../template/acara_qrcode_label.php?id_sesi=<? echo $list_sesi['id']?>')">Cetak Label QR-CODE</a><br>
                                        <a type="button" class="btn btn-primary btn-small" href="acara_kumpulan_senarai.php?id_sesi=<? echo $list_sesi['id']; ?>">Peserta</a><br>
                                        <a type="button" class="btn btn-success btn-small" href="acara_senarai_aturcara.php?id_sesi=<? echo $list_sesi['id']; ?>">Aturcara</a><br>
                                        <a type="button" class="btn btn-danger btn-small" href="acara_sumber_info.php?id_sesi=<? echo $list_sesi['id'];?>">Sumber</a><br>
                                        <a type="button" class="btn btn-default btn-small" href="acara_senarai_galeri.php?id_sesi=<? echo $list_sesi['id']; ?>">Galeri</a>
                                        <a type="button" class="btn btn-warning btn-small" onClick="popitup('laporan_keseluruhan_acara.php?id_sesi=<? echo $list_sesi['id']?>')">Laporan Acara</a>

                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Acara</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'acara_kemaskini_acara.php',
                            data:{id_sesi:rowid},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>
