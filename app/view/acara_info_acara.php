<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_1';
$tahun=$_GET['tahun'];
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
    <style type="text/css">
        th{
            text-align: center;
        }
    </style>
    <?
    $date = new DateTime();

    $tahuncurr = date_format($date,"Y");

    $date->modify('first day of this year');
    date_sub($date,date_interval_create_from_date_string("1 years"));
    $tahun1 = date_format($date,"Y");

    $date->modify('first day of this year');
    date_sub($date,date_interval_create_from_date_string("1 years"));
    $tahun2 = date_format($date,"Y");

    $date->modify('first day of this year');
    date_sub($date,date_interval_create_from_date_string("1 years"));
    $tahun3 = date_format($date,"Y");

    $date->modify('first day of this year');
    date_sub($date,date_interval_create_from_date_string("1 years"));
    $tahun4 = date_format($date,"Y");
    ?>
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
                <h1 class="page-header">Info Acara & Peserta</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="acara_info_acara.php?tahun=<? echo $tahun;?>">Program & Acara</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="acara_info_peserta.php?tahun=<? echo $tahun;?>">Peserta</a></li>
                    </ul>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Senarai Acara</label>
                            <a href="acara_info_acara.php?tahun=<? echo $tahuncurr?>"><? echo $tahuncurr?></a> |
                            <a href="acara_info_acara.php?tahun=<? echo $tahun1?>"><? echo $tahun1?></a> |
                            <a href="acara_info_acara.php?tahun=<? echo $tahun2?>"><? echo $tahun2?></a> |
                            <a href="acara_info_acara.php?tahun=<? echo $tahun3?>"><? echo $tahun3?></a> |
                            <a href="acara_info_acara.php?tahun=<? echo $tahun4?>"><? echo $tahun4?></a>
                        </div>
                        <div class="panel-body">
                            <table style="width: 100%" class="table a table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%">Bil.</th>
                                    <th style="width: 25%">Nama Acara</th>
                                    <th style="width: 15%">Tahun & Tarikh</th>
                                    <th style="width: 55%">Penyertaan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i=1;
                                $datas = getSesiAcaraByTahun($tahun);
                                while($list = $datas->fetch_assoc()) {
                                    $id_sesi = $list['id'];
                                    $tarikh_mula=date("d F Y", strtotime($list['tarikh_mula']));
                                    $tarikh_tamat=date("d F Y", strtotime($list['tarikh_tamat']));
                                    ?>
                                    <tr>
                                        <td><? echo $i++; ?></td>
                                        <td><? echo $list['nama']; ?></td>
                                        <td>
                                            <? echo $list['tahun']; ?><br>
                                            <? echo $tarikh_mula." - ".$tarikh_tamat; ?>
                                        </td>
                                        <td>
                                            <table style="width: 100%" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 20%">Sasaran</th>
                                                    <th style="width: 20%">Hadir</th>
                                                    <th style="width: 20%">Tidak Hadir</th>
                                                    <th style="width: 20%">% Kehadiran</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <?
                                                    $bil_keseluruhan=getBilKeselurahanPesertaBasedOnSesi($id_sesi);
                                                    $bil_hadir_keseluruhan=getBilPesertaHadirBasedOnSesi($id_sesi);
                                                    $bil_tidak_hadir_keseluruhan=$bil_keseluruhan-$bil_hadir_keseluruhan;
                                                    $peratusan_kehadiran_keseluruhan=$bil_hadir_keseluruhan/$bil_keseluruhan*100;
                                                    ?>
                                                    <td><b>KESELURUHAN</b></td>
                                                    <td align="center"><? echo $bil_keseluruhan;?></td>
                                                    <td align="center"><? echo $bil_hadir_keseluruhan;?></td>
                                                    <td align="center"><? echo $bil_tidak_hadir_keseluruhan;?></td>
                                                    <td align="center"><?php echo number_format($peratusan_kehadiran_keseluruhan, 2);?>%</td>
                                                </tr>
                                                <? $data_kumpulan = getKumpulanBasedOnSesi($id_sesi);
                                                while($list_kumpulan = $data_kumpulan->fetch_assoc()) {
                                                    $id_kumpulan=$list_kumpulan['id'];
                                                    if(getBilKeselurahanPesertaBasedOnSesiKumpulan($id_sesi,$id_kumpulan) !=0){
                                                        $bil_peserta=getBilKeselurahanPesertaBasedOnSesiKumpulan($id_sesi,$id_kumpulan);
                                                        $bil_hadir_peserta= getBilPesertaHadirBasedOnSesiKumpulan($id_sesi,$id_kumpulan);
                                                        $bil_tidak_hadir_peserta=$bil_peserta-$bil_hadir_peserta;
                                                        $peratusan_kehadiran_peserta=$bil_hadir_peserta/$bil_peserta*100;
                                                    }else{
                                                        $bil_peserta=0;
                                                        $bil_hadir_peserta=0;
                                                        $bil_tidak_hadir_peserta=0;
                                                        $peratusan_kehadiran_peserta=0;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><b><? echo $list_kumpulan['nama_kumpulan'];?></b></td>
                                                        <td style="text-align: center"><? echo $bil_peserta;?></td>
                                                        <td style="text-align: center"><? echo $bil_hadir_peserta;?></td>
                                                        <td style="text-align: center"><? echo $bil_tidak_hadir_peserta;?></td>
                                                        <td style="text-align: center"><? echo number_format($peratusan_kehadiran_peserta, 2);?>%</td>
                                                    </tr>
                                                <?}?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('table.a').DataTable();
        } );
    </script>
</body>
</html>