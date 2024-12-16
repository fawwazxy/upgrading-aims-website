<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";
//date_default_timezone_set("Asia/Kuala_Lumpur");
//$current_year = date(Y);
$id_pengusaha = $_GET['id_pengusaha'];
$data_pengusaha = getPengusahaById($id_pengusaha)->fetch_assoc();
$data_ppk = getPPKByKod($data_pengusaha['kod_ppk'])->fetch_assoc();
$data_mukim = getMukimByKod($data_pengusaha['kod_mukim'])->fetch_assoc();
$data_negeri = getNegeriByKod($data_pengusaha['kod_negeri'])->fetch_assoc();
//$kod_ppk = $_GET['kod_ppk'];

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
                <h1 class="page-header">Pengusaha</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="pengusaha_senarai.php"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Maklumat Pengusaha</label>
                    </div>

                    <div class="panel-body">

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Nama Pertubuhan Peladang Kawasan (PPK)</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo '<b>'.$data_ppk['kod_ppk'].'</b>'.' - '.$data_ppk['nama_ppk'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Nama Mukim</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_mukim['mukim'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Nama</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_pengusaha['nama'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>No. Kad Pengenalan</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_pengusaha['nokp'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Umur</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_pengusaha['umur'];?>&nbsp;Tahun
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>No. Telefon</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo '+6'.$data_pengusaha['notel'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Jantina</label><br>
                            </div>
                            <div class="col-xs-8">
                                <?if($data_pengusaha['jantina']=='L'){echo 'Lelaki';}else{echo 'Perempuan';}?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>No. Pengusaha</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_pengusaha['no_pengusaha'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>No. Ahli</label>
                            </div>
                            <div class="col-xs-8">
                                <?echo $data_pengusaha['no_ahli'];?>
                            </div>
                        </div>

                        <div class="form-group row" align="left">
                            <div class="col-xs-4">
                                <label>Alamat</label>
                            </div>
                            <div class="col-xs-8">
                                <?if($data_pengusaha['alamat']!=''){
                                    echo $data_pengusaha['alamat'];
                                }if($data_pengusaha['alamat2']!=''){
                                    echo '<br>'.$data_pengusaha['alamat2'];
                                }if($data_pengusaha['alamat3']!=''){
                                    echo '<br>'.$data_pengusaha['alamat3'];
                                }
                                echo '<br>'.$data_pengusaha['poskod'].'&nbsp;'.$data_pengusaha['bandar'].'<br>'.$data_negeri['name'];?>
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