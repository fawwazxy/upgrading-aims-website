<?php

include ('../controller/auth.php');

require "../model/jejakasnaf_functions.php";
require "../model/lookup.php";

$id = $_GET['id'];
$info_pentadbir = getPentadbirInfoById($id)->fetch_assoc();

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
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
    }
</style>
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

                    <? include ('../../app/global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Info Pentadbir</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/jejakasnaf_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="pentadbirEdit" />
                        <input type="hidden" name="id" id="id" value="<?echo $id?>" />
                    </div>

                    <br><div class="form-group" align="right">
                        <a href="ja_pentadbir_senarai.php" ><button type="button" class="btn btn-primary">Kembali</button></a>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Info Pentadbir</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <label><font color="red">** Maklumat Wajib Diisi **</font></label>
                            <div class="form-group row" align="left">
                                <div class="col-xs-10">
                                    <label>Nama<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nama" id="nama" required value="<?echo $info_pentadbir['nama'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>No. Telefon<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" placeholder="+60123456789" name="notel" id="notel" required value="<?echo $info_pentadbir['notel'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label>Email</label>
                                    <input class="form-control" placeholder="example@gmail.com" name="emel" id="emel" value="<?echo $info_pentadbir['emel'];?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Jawatan<font color="red">&nbsp;*</font></label>
                                    <input class="form-control" placeholder="" name="jawatan" id="jawatan" required value="<?echo $info_pentadbir['jawatan'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label>Peranan<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="acc_type" name="acc_type" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_acc_type","kod_acc","jenis_acc",$info_pentadbir['acc_type']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>ID Pengguna<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="id_pengguna" id="id_pengguna" required value="<?echo $info_pentadbir['id_pengguna'];?>">
                                </div>
                                <div class="col-xs-5">
                                    <label>Katalaluan<font color="red"> **</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="katalaluan" id="katalaluan" required value="<?echo $info_pentadbir['katalaluan'];?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Negeri<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="negeri" name="negeri" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_negeri","code","name",$info_pentadbir['negeri']);?>
                                    </select>
                                </div>
                                <div class="col-xs-5">
                                    <label>Daerah<font color="red"> **</font>&nbsp;</label>
                                    <select required class="form-control" id="daerah" name="daerah" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("lkp_daerah","kod_daerah","daerah",$info_pentadbir['daerah']);?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
            </div>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>
<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    $("#negeri").change(function(){
        var negeri = $(this).val();
        //alert(negeri);

        $.ajax({
            url: '../model/jejakasnaf_functions.php',
            type: 'post',
            data: {kod_negeri:negeri,action:"checkDaerah"},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                //alert(len);

                $("#daerah").empty();
                for( var i = 0; i<len; i++){
                    var kod_daerah = response[i]['kod_daerah'];
                    var daerah = response[i]['daerah'];
                    console.log(kod_daerah);

                    $("#daerah").append("<option value='"+kod_daerah+"'>"+daerah+"</option>");

                }
            }
        });
    });

</script>

</body>

</html>