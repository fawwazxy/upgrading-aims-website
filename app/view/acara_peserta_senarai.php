<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";
$flagScreen = 'tab_2';
$id_sesi = $_GET['id_sesi'];
$kumpulan = $_GET['kumpulan'];
$data_sesi = getSesiAcara()->fetch_assoc();
$datas = getPesertaList($id_sesi)->fetch_assoc();
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Peserta</h1>
                <?if($datas['nama_sesi']!=''){?>
                    <b><h4><span style="color: red; "><?echo $datas['nama_sesi']?></span></h4></b><?}?>
                <?if($datas['lokasi']!=''){?>
                    <b><h4><?echo $datas['lokasi']?></h4></b><?}?>
                <?if($datas['tarikh_mula']!=''){?>
                    <b><h4><?echo date("d F Y",strtotime($datas['tarikh_mula']));?> - <?echo date("d F Y",strtotime($datas['tarikh_tamat']));?></h4></b><?}?>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>">Kumpulan</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="acara_peserta_senarai.php?id_sesi=<?echo $id_sesi?>">Peserta</a></li>
                    </ul>
                </div>
                <br>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Muat Naik Fail</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="../controller/upload_peserta_excel_exec.php" enctype="multipart/form-data">
                                    <input id="action" name="action" type="hidden" value="upload"/>
                                    <input id="id_sesi" name="id_sesi" type="hidden" value="<? echo $id_sesi;?>"/>
                                    <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_NAME'];?>"/>
                                    <div class="form-group">
                                        <label class="control-label">Fail<span style="color: red; "> **</span>&nbsp;(Fail Excel Sahaja) <span
                                                    style="color: red; ">Format Susunan Data: NoKP,Nama,NoTelefon</span></label>
                                        <input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" align="right">
                    <!--<button class="btn btn-warning" data-toggle="modal" data-target="#myModal">Muat Naik Excel</button>-->
                    <a class="view" target="blank" href="acara_tag_peserta_semua.php?id_sesi=<?echo $id_sesi ;?>"><button class="btn btn-info hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Tag Peserta</button></a>
                    <a class="view" target="blank" href="acara_sijil_peserta_semua.php?id_sesi=<?echo $id_sesi ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Sijil Penyertaan</button></a>
                    <a href="acara_senarai_acara.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Peserta Berdaftar</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 5%">Bil.</th>
                                <th style="width: 23%">Nama Peserta</th>
                                <th style="width: 16%">No. Kad Pengenalan</th>
                                <th style="width: 13%">No. Telefon</th>
                                <th style="width: 15%">Jawatan</th>
                                <th style="width: 12%">Kumpulan</th>
                                <th style="width: 10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/acara_peserta_exec.php" enctype="multipart/form-data">
                                    <div>
                                        <input type="hidden" name="action" value="pesertaAddEdit" />
                                        <input type="hidden" id="id" name="id" value="0" />
                                        <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>"/>
                                        <input type="hidden" id="created_by" name="created_by" value="<?echo $_SESSION['SESS_ID']?>">
                                    </div>
                                    <td></td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%" name="nama" id="nama"></td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="50%" name="nokp" id="nokp"></td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="50%" name="notel" id="notel"></td>
                                    <td><input type="text" required class="form-control" size="50%" name="jawatan" id="jawatan"></td>
                                    <td><select required class="form-control" id="kumpulan" name="kumpulan" value=""><option value="">-- Pilih --</option><?echo getKumpulan("lkp_kumpulan_peserta","id","nama_kumpulan",$kumpulan,$id_sesi);?></select><!--
                                                <select required class="form-control" id="kumpulan" name="kumpulan"><option value="">-- Pilih--</option><?echo getDropDown("lkp_kumpulan_peserta","id","nama_kumpulan",$kumpulan);?>
                                            </select>--></td>
                                    <td><button type="submit" class="btn btn-primary">Tambah Baharu</button></td>
                                </form>
                            </tr>
                            <?
                            $i=1;
                            $datas = getPesertaList($id_sesi);
                            while($list = $datas->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list['nama'];?></td>
                                    <td><? echo $list['nokp'];?></td>
                                    <td>+6<? echo $list['notel'];?></td>
                                    <td><? echo $list['jawatan'];?></td>
                                    <td><? echo $list['nama_kumpulan'];?></td>
                                    <td>
                                        <a class="view" target="blank" href="acara_tag_peserta.php?id_sesi=<?echo $list['id_sesi'] ;?>&nokp=<?echo $list['nokp'] ;?>"><button class="btn btn-info hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Tag Peserta</button></a>
                                        <a class="view" target="blank" href="acara_sijil_peserta.php?id_sesi=<?echo $list['id_sesi'] ;?>&nokp=<?echo $list['nokp'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Sijil Penyertaan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-<?php echo $list['id'];?>">Kemaskini</button></a><br>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                        <div class="modal" id="modal-<?php echo $list['id'];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Kemaskini Info Peserta</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="../controller/acara_peserta_exec.php" enctype="multipart/form-data">
                                                            <div>
                                                                <input type="hidden" name="action" value="pesertaAddEdit" />
                                                                <input type="hidden" id="id" name="id" value="<? echo $list['id']?>" />
                                                                <input type="hidden" id="id_sesi" name="id_sesi" value="<? echo $id_sesi?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama">Nama Peserta<span style="color: red; "> *</span>&nbsp;</label>
                                                                <input class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"
                                                                       name="nama" id="nama" required value="<? echo $list['nama']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nokp">No. Kad Pengenalan<span style="color: red; "> *</span>&nbsp;</label>
                                                                <input class="form-control" placeholder=" " name="nokp" id="nokp" required value="<? echo $list['nokp']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="notel">No. Telefon<span style="color: red; "> *</span>&nbsp;</label>
                                                                <input class="form-control" placeholder=" " name="notel" id="notel" required value="<? echo $list['notel']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jawatan">Jawatan<span style="color: red; "> *</span>&nbsp;</label>
                                                                <input class="form-control" name="jawatan" id="jawatan" required value="<?echo $list['jawatan']?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kumpulan">Kumpulan&nbsp;</label>
                                                                <select required class="form-control" id="kumpulan" name="kumpulan" value="">
                                                                    <option value="">-- Pilih --</option>
                                                                    <? echo getKumpulan("lkp_kumpulan_peserta","id","nama_kumpulan",$list['kumpulan'],$id_sesi);?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="file">Gambar Peserta<span style="color: red; "> *</span>&nbsp;</label>
                                                                <br>
                                                                <? if($list['photo_filename']!=''){?>
                                                                    <? echo '<img width="100" height="120" src="../../acara/foto_peserta/'.$list['photo_filename'].'"/><br>';?><?echo $list['nama_photo']?>
                                                                <?}?>
                                                                <input accept="image/*" type="file" class="btn btn-link" id="file" name="photo" />
                                                            </div>
                                                            <div class="form-group" align="right">
                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });
            $.ajax({
                url: "../model/acara_functions.php",
                type: "POST",
                data: {action:"deletePeserta", row_id:row_id.val() },
                success: function (response) {
                    $(this).parents("tr").remove();
                    $(".add-new").removeAttr("disabled");
                    $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
                                location.href = "acara_peserta_senarai.php?id_sesi=<?echo $id_sesi?>";
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    location.href = "acara_peserta_senarai.php?id_sesi=<?echo $id_sesi?>";
                }
            });
        });
    });
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>