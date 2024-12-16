<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";
//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
$id = $_GET['id'];
$data_tanah = getLotTanahById($id)->fetch_assoc();
$data_negeri = getNegeriByKod($data_tanah['kod_negeri'])->fetch_assoc();
$data_jajahan = getJajahanByKod($data_tanah['kod_jajahan'])->fetch_assoc();
$data_daerah = getDaerahByKod($data_tanah['kod_daerah'])->fetch_assoc();
$data_mukim = getMukimByKod($data_tanah['kod_mukim'])->fetch_assoc();
$data_ppk = getPPKByKod($data_mukim['kod_ppk'])->fetch_assoc();

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
                <h1 class="page-header">Lot Tanah</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="lot_tanah_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Maklumat Lot Tanah</label>
                    </div>

                    <div class="panel-body">

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Pertubuhan Peladang Kawasan (PPK)</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_ppk['kod_ppk'].' - '.$data_ppk['nama_ppk'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Alamat PPK</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_ppk['alamat'].'<br>'.$data_ppk['alamat2'].',<br>'.$data_ppk['alamat3'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Pusat Kemajuan Peladang (PKP)</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['pkp'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Mukim</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_mukim['mukim'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Daerah</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_daerah['daerah'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Jajahan</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_jajahan['jajahan'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Negeri</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_negeri['name'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Kawasan Kaji Selidik</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['areawunit'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Keluasan</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['keluasan'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Kawasan Pengusahaan</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['area'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Pengairan dan Saliran</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['pengairan'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Seksyen</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['seksyen'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Lot</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['lot'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Perimeter</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['perimeter'];?>
                            </div>
                        </div>

                        <!--
                            <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>IO<font color="red"> **</font>&nbsp;</label>
	                            </div>
	                            <div class="col-xs-8">
		                            <?echo $data_tanah['io'];?>
	                            </div>
                            </div>

                            <div class="form-group row" align="left">
	                            <div class="col-xs-4">
		                            <label>pa<font color="red"> **</font>&nbsp;</label>
	                            </div>
	                            <div class="col-xs-8">
		                            <?echo $data_tanah['pa'];?>
	                            </div>
                            </div>
                        -->

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Koordinat</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_tanah['koordinat'];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<script>

</script>
</body>

</html>