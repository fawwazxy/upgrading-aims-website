<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$id=$_GET['id'];
$library=getLibraryInfo($id)->fetch_assoc();

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
                        <input type="hidden" id="id" name="id" value="<?echo $library['id']?>" />
                        <input type="hidden" id="status_naskah_sebelum" name="status_naskah_sebelum" value="<?echo $library['status_naskah']?>" />
                        <input type="hidden" id="created_by" name="created_by" value="<?echo $_SESSION['SESS_ID']?>" />
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Maklumat Bahan Bacaan</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Kategori<font color="red"> **</font>&nbsp;</label>
                                    <select required class="form-control" id="id_jenis" name="id_jenis" value="<?echo $library['id_jenis']?>" >
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_elibrary_jenis","id","jenis",$library['id_jenis']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Tajuk<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="nama" id="nama" required  value="<?echo $library['nama']?>">
                                </div>
                            </div>

                            <div class="form-group" align="left">
                                <label>Gambar Muka Depan</label>
                                <br>
                                <?if($library['frontpage_cover_file']!=''){?>
                                    <?echo '<img width="100" height="120" src="../../elibrary/frontpage/'.$library['frontpage_cover_file'].'"/><br>';?><?
                                }?>
                                <input accept="image/*" type="file" class="btn btn-link" name="frontpage_cover_file" />
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Topik&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="topik" id="topik" value="<?echo $library['topik']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Sub Topik&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="subtopic" id="subtopic" value="<?echo $library['subtopic']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Jilid&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="bilangan" id="bilangan" value="<?echo $library['bilangan']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Keterangan<font color="red"> **</font>&nbsp;</label>
                                    <textarea class="form-control" rows="5" name="keterangan" id="keterangan" required ><?echo $library['keterangan'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Penerbit&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="penerbit" id="penerbit" value="<?echo $library['penerbit']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Tahun Terbitan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="tahun_terbitan" id="tahun_terbitan" required  value="<?echo $library['tahun_terbitan']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Pengarang<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="pengarang" id="pengarang" required  value="<?echo $library['pengarang']?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>ISBN&nbsp;</label>
                                    <input class="form-control" placeholder=" " name="isbn" id="isbn" value="<?echo $library['isbn']?>">
                                </div>
                            </div>



                            <?if ($library['status_naskah'] == 0){?>
                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Salinan Naskah<font color="red"> **</font>&nbsp;</label><br>
                                        <input type="radio" value="0" name="status_naskah" id="dokumen" <?echo $library['status_naskah'] == '0'?'checked':''?>/>
                                        <label>Dokumen pdf sahaja</label>&nbsp; &nbsp; &nbsp;
                                        <input type="radio" value="1" name="status_naskah" id="both" <?echo $library['status_naskah'] == '1'?'checked':''?>/>
                                        <label>Documen pdf dan Salinan Naskah</label>
                                    </div>
                                </div>

                                <div id = "ada_salinan">
                                    <div class="form-group row" align="left">
                                        <div class="col-xs-8">
                                            <label>Bilangan<font color="red"> **</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " name="bil_naskah_hardcopy" id="bil_naskah_hardcopy" value="<?echo $library['bil_naskah_hardcopy']?>">
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-8">
                                            <label>Lokasi<font color="red"> **</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " name="lokasi_fizikal_hardcopy" id="lokasi_fizikal_hardcopy" value="<?echo $library['lokasi_fizikal_hardcopy']?>">
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-8">
                                            <label>Status Pinjaman<font color="red"> ** </font>&nbsp;(Sila klik untuk kemaskini)</label><br>
                                            <input type="radio" value="1" checked="" name="status_pinjam" id="boleh_pinjam" <?echo $library['status_pinjam'] == '1'?'checked':''?> />
                                            <label>Boleh</label>&nbsp; &nbsp; &nbsp;
                                            <input type="radio" value="0" name="status_pinjam" id="takboleh_pinjam" <?echo $library['status_pinjam'] == '0'?'checked':''?> />
                                            <label>Tidak Boleh</label>
                                        </div>
                                    </div>
                                </div>
                            <?}else if($library['status_naskah'] == 2){?>
                                <input type="hidden" id="bil_naskah_hardcopy" name="bil_naskah_hardcopy" value="<?echo $library['bil_naskah_hardcopy']?>" />
                                <input type="hidden" id="status_naskah" name="status_naskah" value="<?echo $library['status_naskah']?>" />
                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Salinan Naskah (Hardcopy)<font color="red"> **</font>&nbsp;</label><br>
                                        <input type="radio" value="2" name="status_naskah" id="naskah" <?echo $library['status_naskah'] == '2'?'checked':''?>/>
                                        <label>Salinan Naskah sahaja</label>&nbsp; &nbsp; &nbsp;
                                        <input type="radio" value="1" name="status_naskah" id="both" <?echo $library['status_naskah'] == '1'?'checked':''?> />
                                        <label>Dokumen pdf dan Salinan Naskah</label>
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Lokasi<font color="red"> **</font>&nbsp;</label>
                                        <input class="form-control" placeholder=" " name="lokasi_fizikal_hardcopy" id="lokasi_fizikal_hardcopy" value="<?echo $library['lokasi_fizikal_hardcopy']?>">
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Status Pinjaman<font color="red"> ** </font>&nbsp;(Sila klik untuk kemaskini)</label><br>
                                        <input type="radio" value="1" checked="" name="status_pinjam" id="boleh_pinjam" <?echo $library['status_pinjam'] == '1'?'checked':''?> />
                                        <label>Boleh</label>&nbsp; &nbsp; &nbsp;
                                        <input type="radio" value="0" name="status_pinjam" id="takboleh_pinjam" <?echo $library['status_pinjam'] == '0'?'checked':''?> />
                                        <label>Tidak Boleh</label>
                                    </div>
                                </div>
                            <?}else if($library['status_naskah']==1){?>
                                <input type="hidden" id="bil_naskah_hardcopy" name="bil_naskah_hardcopy" value="<?echo $library['bil_naskah_hardcopy']?>" />
                                <input type="hidden" id="status_naskah" name="status_naskah" value="<?echo $library['status_naskah']?>" />

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Lokasi<font color="red"> **</font>&nbsp;</label>
                                        <input class="form-control" placeholder=" " name="lokasi_fizikal_hardcopy" id="lokasi_fizikal_hardcopy" value="<?echo $library['lokasi_fizikal_hardcopy']?>">
                                    </div>
                                </div>

                                <div class="form-group row" align="left">
                                    <div class="col-xs-8">
                                        <label>Status Pinjaman<font color="red"> ** </font>&nbsp;(Sila klik untuk kemaskini)</label><br>
                                        <input type="radio" value="1" checked="" name="status_pinjam" id="boleh_pinjam" <?echo $library['status_pinjam'] == '1'?'checked':''?> />
                                        <label>Boleh</label>&nbsp; &nbsp; &nbsp;
                                        <input type="radio" value="0" name="status_pinjam" id="takboleh_pinjam" <?echo $library['status_pinjam'] == '0'?'checked':''?> />
                                        <label>Tidak Boleh</label>
                                    </div>
                                </div>
                            <?}?>
                            <div id = "ada_document">
                                <div class="form-group" align="left">
                                    <div id="document_text"></div>
                                    <?if($library['status_naskah']!=2){?>
                                        <a href="../controller/library_download_file_exec.php?id=<?echo $library['id']?>"><?echo $library['nama']?>.pdf</a>
                                    <?}?>
                                    <input accept=".pdf" type="file" name="document_file" id="document_file" class="btn btn-link">
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
        //from softcopy only
        <?if($library['status_naskah']==0){?>
        $('#ada_salinan').hide();
        $('#ada_document').show();

        //maintain
        $('#dokumen').click(function(){
            $('#ada_salinan').hide();
            $('#ada_document').show();
            $("#document_text").html("<label>Fail Dokumen</label>");
            //$("#document_file").prop('required', true);
        });

        //chane into both
        $('#both').click(function(){
            $('#ada_salinan').show();
            $("#bil_naskah_hardcopy").prop('required', true);
            $("#lokasi_fizikal_hardcopy").prop('required', true);
            $('#ada_document').show();
            $("#document_text").html("<label>Fail Dokumen</label>");
            //$("#document_file").prop('required', true);
        });

        //from hardcopy only
        <?}else if($library['status_naskah']==2){?>
        $('#ada_salinan').hide();
        $('#ada_document').hide();
        //maintain
        $('#naskah').click(function(){
            $('#ada_salinan').show();
            $("#bil_naskah_hardcopy").prop('required', true);
            $("#lokasi_fizikal_hardcopy").prop('required', true);
            $('#ada_document').hide();
        });
        //change into both
        $('#both').click(function(){
            $('#ada_salinan').show();
            $("#bil_naskah_hardcopy").prop('required', true);
            $("#lokasi_fizikal_hardcopy").prop('required', true);
            $('#ada_document').show();
            $("#document_file").prop('required', true);
            $("#document_text").html("<label>Fail Dokumen<font color='red'>&nbsp;**</font></label>");
        });
        <?}?>

    });

</script>
</body>

</html>