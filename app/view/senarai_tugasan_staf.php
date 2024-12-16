<?php

include ('../controller/auth.php');

require "../model/projek_internal_task_functions.php";
//require "../model/lookup.php";
$nokp=$_GET['nokp'];
$code = $_GET['code'];
$tab = $_GET['page'];
if (!isset($code) && $code == '') {
    $code = 'INPROGRESS';
}
if(isset($tab)){
    $page="projek_internal_senarai_task.php";

}else{
    $page="admin_projek_senarai.php";
}
date_default_timezone_set("Asia/Kuala_Lumpur");
// $date_month = date(m);
// $date_year = date(Y);
// $date_day = date(d);
// $current_date = $date_year."-".$date_month."-".$date_day;
$current_datetime = date("Y-m-d H:i:s");
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
                <h1 class="page-header">Senarai Tugasan</h1>
                <label>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['name'];?><br>
                <label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['noic'];?><br>
                <label>No. Staff &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['no_staff'];?><br>
                <label>Jawatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['role'];?><br>
                <label>Jabatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo '<b>'.$staff_details['code_department'].'</b>'.'&nbsp;-&nbsp'.$staff_details['description'];?><br>
                <label>Cawangan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo '<b>'.$staff_details['cawangan_kod'].'</b>'.'&nbsp;-&nbsp'.$staff_details['nama'];?>
            </div>
        </div>

        <div class="form-group" align="right">
            <a href="<? echo $page;?>"><button type="button" class="btn btn-primary">Kembali</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="panel panel-red"> -->
                <!-- /.panel-heading -->
                <!-- <div class="panel-heading">
                            <center><b>Analisa Tugasan Peribadi</b></center>
                          </div>
                          <table width="100%" class="table  table-bordered">

                            <thead>  
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Dalam Pelaksanaan</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Untuk Pelaksanaan</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Selesai</th>
                              <th bgcolor="#D6DBDF" width="25%" style="text-align: center;">Tugasan Tertungak</th>
                            </thead>
                           
                            <tbody>
                              <td onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=INPROGRESS';" align="center"><strong><font size="6" color="orange"><? echo getBilTaskByCategory("INPROGRESS",$nokp);?></font></strong></td>
                              <td onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=TODO';" align="center"><strong><font size="6" color="blue"><? echo getBilTaskByCategory("TODO",$nokp);?></font></strong></td>
                              <td onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=DONE';" align="center"><strong><font size="6" color="green"><? echo getBilTaskByCategory("DONE",$nokp);?></font></strong></td>
                               <td align="center"><strong><font size="6" color="red"><? echo getBilTaskOverdue($nokp);?></font></strong></td>
                             
                            </tbody>
                          </table>
                        </div> -->

                <div class="panel panel-red">
                    <!-- /.panel-heading -->
                    <div class="panel-heading">
                        <center><b>Analisa Tugasan Peribadi</b></center>
                    </div>
                    <!-- /.panel-heading -->
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=INPROGRESS&page=kanban';" bgcolor="#D6DBDF" width="20%"><center>Dalam Pelaksanaan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=TODO&page=kanban';" bgcolor="#D6DBDF" width="20%"><center>Untuk Pelaksanaan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=tahunan&page=kanban';" bgcolor="#D6DBDF" width="30%" colspan="4"><center>Sudah Selesai</center></th>
                            <th bgcolor="#D6DBDF" width="20%"><center>Tugasan Tertunggak</center></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>

                            <td onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=INPROGRESS&page=kanban';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><? echo getBilTaskByCategory("INPROGRESS",$nokp);?></font></strong></td>
                            <td onClick="location.href='senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=TODO&page=kanban';" align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="blue"><? echo getBilTaskByCategory("TODO",$nokp);?></font></strong></td>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=harian&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Harian</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=mingguan&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Mingguan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=bulanan&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Bulanan</center></th>
                            <th onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=tahunan&page=kanban';" width="10%" bgcolor="#E8E8E8"><center>Tahunan</center></th>
                            <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><? echo getBilTaskOverdue($nokp);?></font></strong></td>
                        </tr>
                        <tr>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=harian&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurDate($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=mingguan&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurWeek($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=bulanan&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurMonth($nokp);?></font></strong>
                            </td>
                            <td rowspan="2" bgcolor="#FDFEFE" onClick="location.href='senarai_tugasan_staf.php?nokp=<? echo $nokp;?>&code=tahunan&page=kanban';" align="center">
                                <strong><font size="6" color="green"><? echo getBilTaskDoneByCurYear($nokp);?></font></strong>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Tugasan</label>&nbsp;&nbsp;&nbsp;
                        <a href="senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=INPROGRESS">Dalam Pelaksanaan</a> &nbsp;|&nbsp;
                        <a href="senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=TODO">Untuk Pelaksanaan</a> &nbsp;|&nbsp;
                        <a href="senarai_tugasan_staf.php?nokp=<?echo $nokp;?>&code=DONE">Sudah Selesai</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">Bil.</th>
                                <th width="25%">Maklumat Tugasan</th>
                                <th width="20%">Tempoh Tugasan</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($code == 'harian') {
                                $tugasan = getTaskListDoneByNokpDate($nokp);
                            }
                            else if ($code == 'mingguan') {
                                $tugasan = getTaskListDoneByNokpWeek($nokp);
                            }
                            else if ($code  == 'bulanan') {
                                $tugasan = getTaskListDoneByNokpMonth($nokp);
                            }
                            else if ($code == 'tahunan') {
                                $tugasan = getTaskListDoneByNokpYear($nokp);
                            }
                            else {
                                $tugasan = getTaskList($nokp,$code);
                            }

                            $i=1;
                            while($list_tugasan = $tugasan->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <label class="control-label">Nama Projek :</label>
                                        <br><b><?echo $list_tugasan['kod_projek'].'</b>'.' - '.$list_tugasan['nama_projek'];?>
                                            <br><label class="control-label">Tajuk Tugasan :</label>
                                            <br><?echo $list_tugasan['tajuk']?>
                                            <br><label class="control-label">Status Tugasan :</label>
                                            <br><?if($list_tugasan['code'] == 'TODO') {echo '<b><font color="#003399">'.$list_tugasan['nama_kategori'].'</font></b>';}
                                            else if($list_tugasan['code'] == 'INPROGRESS') {echo '<b><font color="#cc6600">'.$list_tugasan['nama_kategori'].'</font></b>';}
                                            else {echo '<b><font color="#009900">'.$list_tugasan['nama_kategori'].'</font></b>';} ?>
                                            <br><label class="control-label">Kumpulan : </label>
                                            <br><?echo $list_tugasan['nama_kumpulan']?>
                                    </td>
                                    <td>
                                        <label class="control-label">Tarikh Mula :</label>
                                        <br><b><?echo date('d/m/Y h:i:s a ', strtotime($list_tugasan['tarikh_mula']))?></b>
                                        <br><label class="control-label">Tarikh Tamat :</label>
                                        <br>
                                        <?if($list_tugasan['code'] == 'TODO' || $list_tugasan['code'] == 'INPROGRESS') {
                                            if($list_tugasan['tarikh_tamat'] <= $current_datetime) {
                                                echo '<b><font color="red">'.date('d/m/Y h:i:s a ', strtotime($list_tugasan['tarikh_tamat'])).'</font></b>';}
                                            else {
                                                echo '<b>'.date('d/m/Y h:i:s a ', strtotime($list_tugasan['tarikh_tamat'])).'</b>';}
                                        }
                                        else{
                                            echo '<b>'.date('d/m/Y h:i:s a ', strtotime($list_tugasan['tarikh_tamat'])).'</b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="projek_task_view.php?id=<?echo $list_tugasan['id_task'];?>&page=admin"><button type="button" class="btn btn-success">Maklumat Terperinci</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_tugasan['id_task'];?>"></td>
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