<?php

include ('../controller/auth.php');

require "../model/lawatan_functions.php";
require "../model/lookup.php";

$id_lawatan = $_GET['id_lawatan'];
$data_pelawat = getPelawatInfoById($id_lawatan)->fetch_assoc();
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
                <label>Nama Pelawat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pelawat['nama']?><br>
                <label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;<?echo $data_pelawat['nokp']?><br>
                <label>Nama Syarikat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pelawat['nama_company']?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="lawatan_pelawat_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <form method="post" action="../controller/lawatan_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="pelawatEdit" />
                        <input type="hidden" name="id_lawatan" id="id_lawatan" value="<?echo $id_lawatan?>" />
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Maklumat Pelawat</label>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Kad<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="kod_kad" name="kod_kad" value="<?echo $data_pelawat['kod_kad']?>">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDown("pelawat_kad","kod_kad","CONCAT(kod_kad,' - ', nama_kad)",$data_pelawat['kod_kad']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Nama Staf<font color="red">&nbsp;**</font></label>
                                    <select required class="form-control" id="nokp_staff" name="nokp_staff" value="<?echo $data_pelawat['nokp_staff']?>">
                                        <option value="">-- Pilih --</option>
                                        <?echo getDropDownStaff($data_pelawat['nokp_staff']);?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>No. Telefon<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" placeholder=" " name="notel" id="notel" required value="<?echo $data_pelawat['notel']?>" >
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-5">
                                    <label>Jenis Kenderaan</label>
                                    <input class="form-control" placeholder=" " name="jenis_kenderaan" id="jenis_kenderaan" value="<?echo $data_pelawat['jenis_kenderaan']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" >
                                </div>
                                <div class="col-xs-3">
                                    <label>No. Kenderaan</label>
                                    <input class="form-control" placeholder=" " name="no_kenderaan" id="no_kenderaan" value="<?echo $data_pelawat['no_kenderaan']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" >
                                </div>
                            </div>

                            <!-- <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                <label>Kategori kad<font color="red">&nbsp;**</font></label><br>
                                <input type="radio" value="1" name="kategori_kad" id="kategori_kad"<?echo $data_pelawat['kategori_kad'] == '1'?'checked':''?> />
                                <label>Kad</label>&nbsp; &nbsp; &nbsp;
                                <input type="radio" value="0" name="kategori_kad" id="kategori_kad" <?echo $data_pelawat['kategori_kad'] == '0'?'checked':''?> />
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