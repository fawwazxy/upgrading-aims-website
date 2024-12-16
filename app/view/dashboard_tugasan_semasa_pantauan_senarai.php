<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
//require "../model/lookup.php";
// $nokp=$_GET['nokp'];
$code = $_GET['code'];

if (!isset($code) && $code == '') {
    $code = 'INPROGRESS';
}
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_day."-".$date_month."-".$date_year;
$current_datetime = date("Y-m-d H:i:s");
//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));
$staff_details = getStaffDetailsByNokp($nokp)->fetch_assoc();
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
                <h1 class="page-header">Tugasan Semasa</h1>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="panel panel-red"> -->
                <!-- /.panel-heading -->
                <!-- <div class="panel-heading">
                            <center><b>Analisa Tugasan Semasa</b></center>
                          </div>
                          <table width="100%" class="table  table-bordered">

                            <thead>  
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Dalam Pelaksanaan</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Untuk Pelaksanaan</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Selesai</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Tugasan Tertungak</th>
                            </thead>
                           
                            <tbody>
                              <td onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=INPROGRESS';" align="center"><strong><font size="6" color="orange"><? echo getTaskCountInProgressByCurDate();?></font></strong></td>
                              <td onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=TODO';" align="center"><strong><font size="6" color="blue"><? echo getTaskCountToDoByCurDate();?></font></strong></td>
                              <td onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=DONE';" align="center"><strong><font size="6" color="green"><? echo getTaskCountDoneByCurDate();?></font></strong></td>
                               <td align="center"><strong><font size="6" color="red"><? echo getTaskCountOverdateByCurDate();?></font></strong></td>
                             
                            </tbody>
                          </table>
                        </div> -->

                <div class="panel panel-red">
                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>Analisa Tugasan Semasa</b></center>
                    </div>
                    <!-- /.panel-heading -->
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=INPROGRESS';" bgcolor="#D6DBDF" width="20%"><center>Dalam Pelaksanaan</center></th>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=TODO';" bgcolor="#D6DBDF" width="20%"><center>Untuk Pelaksanaan</center></th>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=tahunan';" bgcolor="#D6DBDF" width="30%" colspan="4"><center>Sudah Selesai</center></th>
                            <th bgcolor="#D6DBDF" width="20%"><center>Tugasan Tertunggak</center></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=INPROGRESS';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><? echo getTaskCountInProgressByCurDate();?></font></strong></td>
                            <td onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=TODO';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="blue"><? echo getTaskCountToDoByCurDate();?></font></strong></td>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=harian';" width="10%" bgcolor="#E8E8E8"><center>Hari Ini</center></th>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=mingguan';" width="10%" bgcolor="#E8E8E8"><center>Minggu Ini</center></th>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=bulanan';" width="10%" bgcolor="#E8E8E8"><center>Bulan Ini</center></th>
                            <th onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=tahunan';" width="10%" bgcolor="#E8E8E8"><center>Tahun Ini</center></th>
                            <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><? echo getTaskCountOverdateByCurDate();?></font></strong></td>
                        </tr>
                        <tr>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=harian';" align="center">
                                <strong><font size="6" color="green"><? echo getTaskCountDoneByCurDate();?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=mingguan';" align="center">
                                <strong><font size="6" color="green"><? echo getTaskCountDoneByCurWeek();?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=bulanan';" align="center">
                                <strong><font size="6" color="green"><? echo getTaskCountDoneByCurMonth();?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='dashboard_tugasan_semasa_pantauan_senarai.php?code=tahunan';" align="center">
                                <strong><font size="6" color="green"><? echo getTaskCountDoneByCurYear();?></font></strong>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Tugasan Semasa</label>&nbsp;&nbsp;&nbsp;
                        <a href="dashboard_tugasan_semasa_pantauan_senarai.php?code=INPROGRESS">Dalam Pelaksanaan</a> &nbsp;|&nbsp;
                        <a href="dashboard_tugasan_semasa_pantauan_senarai.php?code=TODO">Untuk Pelaksanaan</a> &nbsp;|&nbsp;
                        <a href="dashboard_tugasan_semasa_pantauan_senarai.php?code=DONE">Sudah Selesai</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="25%">Maklumat Staf</th>
                                <th width="25%">Maklumat Tugasan</th>
                                <th width="20%">Tempoh Tugasan</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?  if($code == 'harian') {
                                $tugasan_semasa_pantauan = getTaskListDoneByCurDate();
                            }
                            else if($code == 'mingguan') {
                                $tugasan_semasa_pantauan = getTaskListDoneByCurWeek();
                            }
                            else if($code == 'bulanan') {
                                $tugasan_semasa_pantauan = getTaskListDoneByCurMonth();
                            }
                            else if($code == 'tahunan') {
                                $tugasan_semasa_pantauan = getTaskListDoneByCurYear();
                            }
                            else if($code == 'INPROGRESS') {
                                $tugasan_semasa_pantauan = getTaskListInProgressByCurDate();
                            }
                            else if($code == 'TODO') {
                                $tugasan_semasa_pantauan = getTaskListToDoByCurDate();
                            }
                            else {
                                $tugasan_semasa_pantauan = getTaskListDoneByCurYear();
                            }
                            $i=1;
                            while($list_tugasan_semasa_pantauan = $tugasan_semasa_pantauan->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><label class="control-label">Nama :</label>
                                        <br><?echo $list_tugasan_semasa_pantauan['name'];?>
                                        <br><label class="control-label">No. Kad Pengenalan :</label>
                                        <br><?echo $list_tugasan_semasa_pantauan['noic'];?>
                                        <br><label class="control-label">No. Staf :</label>
                                        <br><?echo $list_tugasan_semasa_pantauan['no_staff'];?>
                                        <br><label class="control-label">Jawatan :</label>
                                        <br><?echo $list_tugasan_semasa_pantauan['role'];?>
                                    </td>
                                    <td>
                                        <label class="control-label">Nama Projek :</label>
                                        <br><b><?echo $list_tugasan_semasa_pantauan['kod_projek'].'</b>'.' - '.$list_tugasan_semasa_pantauan['nama_projek'];?>
                                            <br><label class="control-label">Tajuk Tugasan :</label>
                                            <br><?echo $list_tugasan_semasa_pantauan['tajuk']?>
                                            <br><label class="control-label">Status Tugasan :</label>
                                            <br><?if($list_tugasan_semasa_pantauan['code'] == 'TODO') {echo '<b><font color="#003399">'.$list_tugasan_semasa_pantauan['nama_kategori'].'</font></b>';}
                                            else if($list_tugasan_semasa_pantauan['code'] == 'INPROGRESS') {echo '<b><font color="#cc6600">'.$list_tugasan_semasa_pantauan['nama_kategori'].'</font></b>';}
                                            else {echo '<b><font color="#009900">'.$list_tugasan_semasa_pantauan['nama_kategori'].'</font></b>';} ?>
                                            <br><label class="control-label">Kumpulan : </label>
                                            <br><?echo $list_tugasan_semasa_pantauan['nama_kumpulan']?>
                                    </td>
                                    <td>
                                        <label class="control-label">Tarikh Mula :</label>
                                        <br><b><?echo '<font color="blue">'.date('d/m/Y h:i:s a ', strtotime($list_tugasan_semasa_pantauan['tarikh_mula'])).'</font>'?></b>
                                        <br><label class="control-label">Tarikh Tamat :</label>
                                        <br>
                                        <?if($list_tugasan_semasa_pantauan['code'] == 'TODO' || $list_tugasan_semasa_pantauan['code'] == 'INPROGRESS') {
                                            if($list_tugasan_semasa_pantauan['tarikh_tamat'] <= $current_datetime) {
                                                echo '<b><font color="red">'.date('d/m/Y h:i:s a ', strtotime($list_tugasan_semasa_pantauan['tarikh_tamat'])).'</font></b>';}
                                            else {
                                                echo '<b><font color="green">'.date('d/m/Y h:i:s a ', strtotime($list_tugasan_semasa_pantauan['tarikh_tamat'])).'</font></b>';}
                                        }
                                        else{
                                            echo '<b><font color="green">'.date('d/m/Y h:i:s a ', strtotime($list_tugasan_semasa_pantauan['tarikh_tamat'])).'</font></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="dashboard_tugasan_semasa_papar.php?id=<?echo $list_tugasan_semasa_pantauan['id_task'];?>&code=<?echo $list_tugasan_semasa_pantauan['code'];?>&page=papar"><button type="button" class="btn btn-success">Maklumat Terperinci</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_tugasan_semasa_pantauan['id_task'];?>"></td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>