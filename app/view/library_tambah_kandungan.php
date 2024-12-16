<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

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
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Bahan Bacaan</h1>
            </div>
        </div>

        <div class="form-group" align="right">
            <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal" id="btn_pelanggan" onclick="window.location.href='library_kandungan_senarai.php'">Kembali</button>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/library_kandungan_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="libraryAddEdit" />
                        <input type="hidden" id="id" name="id" value="0" />
                        <input type="hidden" id="created_by" name="created_by" value="<?echo $_SESSION['SESS_ID']?>" />
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Bahan Bacaan</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Kategori<font color="red"> **</font>&nbsp;</label>
                                    <select required class="form-control" id="id_jenis" name="id_jenis" value="" >
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_elibrary_jenis","id","jenis",$id_jenis);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Tajuk<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="nama" id="nama" required >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Gambar Muka Depan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" accept="image/*" type="file" class="btn btn-link" name="frontpage_cover_file" required />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Topik</label>
                                    <input class="form-control" placeholder=" " name="topik" id="topik" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Sub Topik</label>
                                    <input class="form-control" placeholder=" " name="subtopic" id="subtopic" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Jilid</label>
                                    <input class="form-control" placeholder=" " name="bilangan" id="bilangan" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Keterangan<font color="red"> **</font>&nbsp;</label>
                                    <textarea class="form-control" rows="5" name="keterangan" id="keterangan" required ></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Penerbit</label>
                                    <input class="form-control" placeholder=" " name="penerbit" id="penerbit" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Tahun Terbitan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="tahun_terbitan" id="tahun_terbitan" required >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Pengarang<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="pengarang" id="pengarang" required >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>ISBN</label>
                                    <input class="form-control" placeholder=" " name="isbn" id="isbn" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Salinan Naskah<font color="red"> **</font>&nbsp;</label><br>
                                    <input type="radio" value="0" name="status_naskah" id="documen" checked=""/>
                                    <label>Dokumen pdf sahaja</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="2" name="status_naskah" id="naskah" />
                                    <label>Salinan Naskah sahaja</label>&nbsp; &nbsp; &nbsp;
                                    <input type="radio" value="1" name="status_naskah" id="both" />
                                    <label>Dokumen pdf dan Salinan Naskah</label>
                                </div>
                            </div>

                            <div id = "ada_naskah">
                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Bilangan<font color="red"> **</font>&nbsp;</label>
                                        <input class="form-control" placeholder=" " name="bil_naskah_hardcopy" id="bil_naskah_hardcopy">
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Lokasi<font color="red"> **</font>&nbsp;</label>
                                        <input class="form-control" placeholder=" " name="lokasi_fizikal_hardcopy" id="lokasi_fizikal_hardcopy">
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Status Pinjaman<font color="red"> **</font>&nbsp;</label><br>
                                        <input type="radio" value="1" name="status_pinjam" id="boleh_pinjam" checked=""/>
                                        <label>Boleh</label>&nbsp; &nbsp; &nbsp;
                                        <input type="radio" value="0" name="status_pinjam" id="takboleh_pinjam" />
                                        <label>Tidak Boleh</label>
                                    </div>
                                </div>
                            </div>

                            <div id = "ada_document">
                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <div id="document_text"></div>
                                        <input accept=".pdf" type="file" name="document_file" id="document_file" class="btn btn-link">
                                    </div>
                                </div>
                            </div>



                            <div class="form-group" align="right">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>

                        </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script>
    $(function(){

        $('#ada_naskah').hide();
        $('#ada_document').show();
        $("#document_file").prop('required', true);
        $("#document_text").html("<label>Fail Dokumen<font color='red'>&nbsp;**</font></label>");

        $('#documen').click(function(){
            $('#ada_naskah').hide();
            $('#ada_document').show();
            $("#document_file").prop('required', true);
            $("#document_text").html("<label>Fail Dokumen<font color='red'>&nbsp;**</font></label>");
        });

        $('#naskah').click(function(){
            $('#ada_naskah').show();
            $("#bil_naskah_hardcopy").prop('required', true);
            $("#lokasi_fizikal_hardcopy").prop('required', true);
            $('#ada_document').hide();
            $("#document_file").prop('required', false);
        });

        $('#both').click(function(){
            $('#ada_naskah').show();
            $("#bil_naskah_hardcopy").prop('required', true);
            $("#lokasi_fizikal_hardcopy").prop('required', true);
            $('#ada_document').show();
            $("#document_file").prop('required', true);
            $("#document_text").html("<label>Fail Dokumen<font color='red'>&nbsp;**</font></label>");
        });

    });

</script>
</body>

</html>