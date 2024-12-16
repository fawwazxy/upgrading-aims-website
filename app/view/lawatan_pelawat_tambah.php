<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
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
                <h1 class="page-header">Pelawat</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="lawatan_pelawat_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <form method="post" action="../controller/lawatan_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="pelawatAdd" />
                        <input id="nokp_pelawat" name="nokp_pelawat" type="hidden" value="<? echo $nokp;?>"/>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Pelawat</label>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Kad<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_kad" name="kod_kad" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("pelawat_kad","kod_kad","CONCAT(kod_kad,' - ',nama_kad)",$kod_kad);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Staf<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="nokp_staff" name="nokp_staff" value="">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownStaff($nokp_staff);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="nama" id="nama" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="nokp" id="nokp" required >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Telefon<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="notel" id="notel" required >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Syarikat<!-- <font color="red">&nbsp;**</font> --></label>
                                    <input class="form-control" placeholder=" " name="nama_company" id="nama_company" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Jenis Kenderaan<!-- <font color="red">&nbsp;**</font> --></label>
                                    <input class="form-control" placeholder=" " name="jenis_kenderaan" id="jenis_kenderaan" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                                <div class="col-xs-3">
                                    <label>No. Kenderaan<!-- <font color="red">&nbsp;**</font> --></label>
                                    <input class="form-control" placeholder=" " name="no_kenderaan" id="no_kenderaan" value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <!-- <div class="form-group row" align="left">
                            <div class="col-xs-8">
                            <label>Kategori Kad<font color="red">&nbsp;**</font></label><br>
                            <input type="radio" value="1" name="kategori_kad" id="kategori_kad" checked=""/>
                            <label>Kad</label>&nbsp; &nbsp; &nbsp;
                            <input type="radio" value="0" name="kategori_kad" id="kategori_kad" />
                            <label>Slip</label>
                            </div>
                            </div> -->

                            <div class="form-group" align="right">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {

    });

    function reloadPPK(obj){
        //console.log(obj);
        location.href = "pengusaha_tambah.php?kod_ppk="+obj.value;
    }
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

</script>
</body>

</html>