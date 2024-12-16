<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";

$id_sesi=$_GET['id_sesi'];
$acara=getSesiAcaraById($id_sesi)->fetch_assoc();
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
                <h1 class="page-header">Senarai Galeri</h1>
                <h1><? echo $acara['nama'];?></h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <a href="acara_senarai_acara.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Galeri
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tajuk Folder</th>
                                <th>Kod Folder</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/acara_galeri_exec.php">
                                    <input type="hidden" name="action" value="add_galeri" />
                                    <input type="hidden" name="id_sesi" value="<?echo $id_sesi?>" />
                                    <td>&nbsp;</td>
                                    <td>
                                        <input class="form-control" id="tajuk_folder" name="tajuk_folder" type="text" placeholder="Masukkan Tajuk Folder" required />
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </td>
                                </form>
                            </tr>
                            <? $i= 1;
                            $data_galeri = getGaleriAcara($id_sesi);
                            while($list_galeri = $data_galeri->fetch_assoc()) {?>
                                <tr class="odd gradeX">
                                    <td><? echo $i; ?></td>
                                    <td><? echo $list_galeri['tajuk_folder']; ?><br>
                                        <a type="button" class="btn btn-success btn-small" onClick="popitup('acara_galeri_gambar.php?id_sesi=<? echo $id_sesi;?>&id_galeri=<? echo $list_galeri['id']?>')">Galeri Gambar</a>
                                    </td>
                                    <td><? echo $list_galeri['folder_code']; ?></td>
                                    <td>
                                        <a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $list_galeri['id'];?>">Kemaskini</a><br><br>
                                        <form method="post" action="../controller/acara_galeri_exec.php" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="upload_gambar" />
                                            <input type="hidden" name="id_sesi" value="<?echo $id_sesi?>" />
                                            <input type="hidden" name="id_galeri" value="<?echo $list_galeri['id'];?>" />
                                            <div class="form-group">
                                                <label class="control-label">Muat Naik Gambar</label>
                                                <input accept="image/*" type="file" class="btn btn-link" name="photo[]" multiple required />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <? $i++; } ?>
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
                <h4 class="modal-title" id="myModalLabel">Kemaskini Galeri</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'acara_kemaskini_galeri.php',
                            data:{id_galeri:rowid,id_sesi:<? echo $id_sesi;?>},
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
