<?php

require('../../lib/gantti.php');
//require('data.php'); 
include ('../controller/auth.php');

require "../model/project_management_function.php";

date_default_timezone_set('Asia/Kuala_Lumpur');
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$time_hour = date(H);
$time_min = date(i);
$time_sec = date(s);




$data = array();
$id = $_GET['id'];

$row_data=getGanttChart($id);
while ($row = $row_data->fetch_assoc()){

    $data[] = array(
        'label' => $row['fasa'],
        'start' => $row['mula'],
        'end'   => $row['akhir'],

        //'class' =>'urgent'


    );

}




$gantti = new Gantti($data, array(
    'title'      => 'Fasa',
    'cellwidth'  => 25,
    'cellheight' => 50,
    'today'      => true
));

?>



<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="utf-8" />
    <?  $sys = getSys(1)->fetch_assoc();?>


    <title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>
    <? //require "../global/header.php"; ?>


    <link rel="stylesheet" href="../../resources/css/gantt_chart_screen.css" />
    <link rel="stylesheet" href="../../resources/css/gantt_chart.css" />

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>


<h1 align="center" style="color:black">Jadual Pengurusan Projek</h1>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">

                <table  >
                    </tbody>

                    <?
                    $log = getProjekDetailsById($id) -> fetch_assoc();
                    ?>
                    <tr>
                        <td><p><b>Nama Projek</b></td>
                        <td><p>:</td>
                        <td><p><?php echo $log['tajuk_sebut_harga'] ?> </td>
                    </tr>
                    <tr>
                        <td><p><b>Pegawai Pelaksana</b></td>
                        <td><p>:&nbsp;</td>
                        <td><p><?php echo $log['nama_ketua_projek'] ?></u></td>
                    </tr>
                    <tr>
                        <td><p><b>Pelanggan</b></td>
                        <td><p>:</td>
                        <td><p><?php echo $log['agensi_rujukan'] ?> </td>
                    </tr>
                    <tr>
                        <td><p><b>Pegawai Rujukan Agensi</b></td>
                        <td><p>:</td>
                        <td><p><?php echo $log['nama_rujukan'] ?></td>
                    </tr>

                    <tr>
                        <td><p><b>Jangka Masa Kerja</b></td>
                        <td><p>:</td>
                        <td><p><?php echo $log['tarikh_mula'] ?> hingga <?php echo $log['tarikh_akhir'] ?>&nbsp;&nbsp;(<?php echo $log['jumlah_hari'] ?> hari)</td>
                    </tr>


                    </tbody>
                </table>

                <?php echo $gantti ?>





                <br><br>
            </div>
        </div>
    </div>
    <? include ('../global/footer.php'); ?>
</div>




</body>

</html>
