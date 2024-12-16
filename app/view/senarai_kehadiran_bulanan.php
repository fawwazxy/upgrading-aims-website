<?php
include ('../controller/auth.php');
require "../model/keluar_masuk_functions.php";

$flagScreen = 'tab_1';
$dateSelection=$_GET['dt'];
$jantina=$_GET['jantina'];
$tarikh_pilihan = $_GET['tarikh_pilihan'];
$month = $_GET['month'];
date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$current_month=date("m");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));
$month_selected = $current_month;
if(!empty($_GET['month'])) {
    $month_selected=$month;
}
$month_selected;
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

    <script language="javascript" type="text/javascript">
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','width=100%');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>

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
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Rekod Keluar Masuk</h1>
            </div>        </div>
        <?
        include ('../global/menu_carian.php');
        ?>
        <br>
        <div class="col-lg-6">
            <div class="form-group" align="left">
                <label class="control-label" for="date">Pilih Bulan<font color="red"> **</font>&nbsp;</label>
                <select required class="form-control" id="month" name="month" value="" onchange="getRekodKeluarByMonth(this)">

                    <option value="01" <?echo ("01"==$month_selected?'selected':'')?>>Januari</option>
                    <option value="02" <?echo ("02"==$month_selected?'selected':'')?>>Februari</option>
                    <option value="03" <?echo ("03"==$month_selected?'selected':'')?>>Mac</option>
                    <option value="04" <?echo ("04"==$month_selected?'selected':'')?>>April</option>
                    <option value="05" <?echo ("05"==$month_selected?'selected':'')?>>Mei</option>
                    <option value="06" <?echo ("06"==$month_selected?'selected':'')?>>Jun</option>
                    <option value="07" <?echo ("07"==$month_selected?'selected':'')?>>Julai</option>
                    <option value="08" <?echo ("08"==$month_selected?'selected':'')?>>Ogos</option>
                    <option value="09" <?echo ("09"==$month_selected?'selected':'')?>>September</option>
                    <option value="10" <?echo ("10"==$month_selected?'selected':'')?>>Oktober</option>
                    <option value="11" <?echo ("11"==$month_selected?'selected':'')?>>November</option>
                    <option value="12" <?echo ("12"==$month_selected?'selected':'')?>>Disember</option>
                </select>
            </div>
        </div>

        <div class="col-xs-2">
            <label><br></label>
            <br><a class="view" target="blank" href="senarai_kehadiran_bulanan_cetak.php?month=<?echo $month_selected?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetakan</button></a>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <br><div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Analisa Rekod Keluar Masuk</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="25%"><center>Jum. Keseluruhan Keluar Masuk</center></th>
                                    <th width="15%"><center>Jum. Luar Asrama</center></th>
                                    <th width="30%" colspan="3"><center>Lelaki</center></th>
                                    <th width="30%" colspan="3"><center>Perempuan</center></th>
                                </tr>
                                </thead>

                                <?
                                $jumlah_keluar_month = getJumlahKeluarByMonth($month_selected,$current_year);
                                $jumlah_luar_asrama_L = getJumlahKeluarByMonthJ($month_selected,$current_year,'Lelaki') - getJumlahMasukByMonthJ($month_selected,$current_year,'Lelaki');
                                $jumlah_luar_asrama_P = getJumlahKeluarByMonthJ($month_selected,$current_year,'Perempuan') - getJumlahMasukByMonthJ($month_selected,$current_year,'Perempuan');
                                $jumlah_luar_asrama_LP = $jumlah_luar_asrama_L + $jumlah_luar_asrama_P;
                                ?>

                                <tbody>
                                <tr>
                                    <td align="center" rowspan="3" style="padding-top: 10px;">
                                        <strong><font color="blue" size="7"><?echo $jumlah_keluar_month;?></font></strong>
                                    </td>
                                    <td align="center" rowspan="3" style="padding-top: 10px;">
                                        <strong><font color="brown" size="7"><?echo $jumlah_luar_asrama_LP;?></font></strong>
                                    </td>
                                    <th width="10%"><center>Keluar</center></th>
                                    <th width="10%"><center>Masuk</center></th>
                                    <th width="10%"><center>Luar Asrama</center></th>
                                    <th width="10%"><center>Keluar</center></th>
                                    <th width="10%"><center>Masuk</center></th>
                                    <th width="10%"><center>Luar Asrama</center></th>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                        <strong><font color="red" size="6"><center><?echo getJumlahKeluarByMonthJ($month_selected,$current_year,'Lelaki');?></center></font></strong>
                                    </td>
                                    <td rowspan="2">
                                        <strong><font color="green" size="6"><center><?echo getJumlahMasukByMonthJ($month_selected,$current_year,'Lelaki');?></center></font></strong>
                                    </td>
                                    <td rowspan="2">
                                        <strong><font color="purple" size="6"><center><?echo $jumlah_luar_asrama_L;?></center></font></strong>
                                    </td>
                                    <td rowspan="2">
                                        <strong><font color="red" size="6"><center><?echo getJumlahKeluarByMonthJ($month_selected,$current_year,'Perempuan');?></center></font></strong>
                                    </td>
                                    <td rowspan="2">
                                        <strong><font color="green" size="6"><center><?echo getJumlahMasukByMonthJ($month_selected,$current_year,'Perempuan');?></center></font></strong>
                                    </td>
                                    <td rowspan="2">
                                        <strong><font color="purple" size="6"><center><?echo $jumlah_luar_asrama_P;?></center></font></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--                     <div class="panel panel-default">
                    <div class="panel-heading">
                    <label class="control-label" for="date">Analisa Rekod Keluar Masuk</label>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="25%"><center>Jum. Keseluruhan Keluar Masuk</center></th>
                                    <th width="25%"><center>Jum. Keseluruhan Luar Asrama</center></th>
                                    <th width="25%" colspan="2"><center>Lelaki</center></th>
                                    <th width="25%" colspan="2"><center>Perempuan</center></th>
                                </tr>
                            </thead>

                            <?
                    $jumlah_keluar_month = getJumlahKeluarByMonth($month_selected,$current_year);
                    $jumlah_luar_asrama_L = getJumlahKeluarByMonthJ($month_selected,$current_year,'Lelaki') - getJumlahMasukByMonthJ($month_selected,$current_year,'Lelaki');
                    $jumlah_luar_asrama_P = getJumlahKeluarByMonthJ($month_selected,$current_year,'Perempuan') - getJumlahMasukByMonthJ($month_selected,$current_year,'Perempuan');
                    $jumlah_luar_asrama_LP = $jumlah_luar_asrama_L + $jumlah_luar_asrama_P;
                    ?>

                            <tbody>
                                <tr>
                                    <td align="center" rowspan="4" style="padding-top: 50px;">
                                        <strong><font color="blue" size="7"><?echo $jumlah_keluar_month;?></font></strong>
                                    </td>
                                    <td align="center" rowspan="4" style="padding-top: 50px;">
                                        <strong><font color="brown" size="7"><?echo $jumlah_luar_asrama_LP;?></font></strong>
                                    </td>
                                    <th><center>Jum. Keluar</center></th>
                                    <th><center>Jum. Masuk</center></th>
                                    <th width="13%"><center>Jum. Keluar</center></th>
                                    <th><center>Jum. Masuk</center></th>
                                </tr>
                                <tr>
                                    <td>
                                        <strong><font color="red" size="6"><center><?echo getJumlahKeluarByMonthJ($month_selected,$current_year,'Lelaki');?></center></font></strong>
                                    </td>
                                    <td>
                                        <strong><font color="green" size="6"><center><?echo getJumlahMasukByMonthJ($month_selected,$current_year,'Lelaki');?></center></font></strong>
                                    </td>
                                     <td>
                                        <strong><font color="red" size="6"><center><?echo getJumlahKeluarByMonthJ($month_selected,$current_year,'Perempuan');?></center></font></strong>
                                    </td>
                                    <td>
                                         <strong><font color="green" size="6"><center><?echo getJumlahMasukByMonthJ($month_selected,$current_year,'Perempuan');?></center></font></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2"><center>Jum. Luar Asrama</center></th>
                                    <th colspan="2"><center>Jum. Luar Asrama</center></th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong><font color="purple" size="6"><center><?echo $jumlah_luar_asrama_L;?></center></font></strong>
                                    </td>
                                    <td colspan="2">
                                        <strong><font color="purple" size="6"><center><?echo $jumlah_luar_asrama_P;?></center></font></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label">Rekod Keluar Masuk</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr class="odd gradeX">
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>No Matrik</td>
                                    <td>Kad Pengenalan</td>
                                    <td>Masa Keluar</td>
                                    <td>Masa Masuk</td>
                                    <td>Catatan Semasa</td>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                $data = getKeluarListByMonth($month_selected,$current_year);
                                while($row_data = $data->fetch_assoc()) {
                                    $fcolor = 'red';
                                    if($row_data['catatan_semasa'] == 'masuk'){
                                        $fcolor = 'green';
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><? echo $i; ?></td>
                                        <td><? echo $row_data['nama']; ?></td>
                                        <td><? echo $row_data['no_matrik']; ?></td>
                                        <td><? echo $row_data['nokp']; ?></td>
                                        <td><? echo $row_data['masa_keluar']; ?></td>
                                        <td><? if ($row_data['masa_masuk']< $row_data['masa_keluar'])
                                            {
                                                echo '';}
                                            else {
                                                echo $row_data['masa_masuk'];
                                            }
                                            ?></td>
                                        <td><font color="<?echo $fcolor?>"><? echo $row_data['catatan_semasa']; ?></font></td>
                                    </tr>
                                    <? $i++; } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function getRekodKeluarByMonth(obj){
            location.href = "senarai_kehadiran_bulanan.php?month="+obj.value;
        }

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

    </script>

</body>
</html>
