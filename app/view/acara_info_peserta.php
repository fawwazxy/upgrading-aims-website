<?php
include ('../controller/auth.php');
require "../model/acara_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_2';
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
                            <label class="control-label" for="date">Senarai Peserta</label>
                        </div>
                        <div class="panel-body">
                            <table style="width: 100%" class="table a table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%">Bil.</th>
                                    <th style="width: 15%">Nama</th>
                                    <th style="width: 10%">Nokp</th>
                                    <th style="width: 10%">No Tel</th>
                                    <th style="width: 50%">Penyertaan</th>
                                    <th style="width: 10%">Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i=1;
                                $datas = getPesertaKeseluruhan();
                                while($list = $datas->fetch_assoc()) {
                                    $nokp = $list['nokp'];
                                    ?>
                                    <tr>
                                        <td><? echo $i++;?></td>
                                        <td><? echo $list['nama'];?></td>
                                        <td><? echo $list['nokp'];?></td>
                                        <td><? echo $list['notel'];?></td>
                                        <td>
                                            <table style="width: 100%" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th style="width: 25%">Bil. Acara</th>
                                                    <th style="width: 25%">Hadir</th>
                                                    <th style="width: 25%">Tidak Hadir</th>
                                                    <th style="width: 25%">% Kehadiran</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <?
                                                    $bil_acara=getBilAcaraByNokp($nokp);
                                                    $bil_hadir=getBilHadirByNokp($nokp);
                                                    $bil_tidak_hadir=$bil_acara-$bil_hadir;
                                                    $peratusan_kehadiran=$bil_hadir/$bil_acara*100;
                                                    ?>
                                                    <td style="text-align: center"><? echo $bil_acara;?></td>
                                                    <td style="text-align: center"><? echo $bil_hadir;?></td>
                                                    <td style="text-align: center"><? echo $bil_tidak_hadir;?></td>
                                                    <td style="text-align: center"><? echo number_format($peratusan_kehadiran, 2);?>%</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <a href="tel:<? echo $list['notel']; ?>"><i class="fa fa-phone-square" style="font-size:48px;" aria-hidden="true"></i></a>
                                            <a onclick="return popitup('https://web.whatsapp.com/send?phone=+6<?php echo $list['notel']; ?>')" ><i class="fa fa-whatsapp fa-3x" style="font-size:48px;" aria-hidden="true"></i></a>
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