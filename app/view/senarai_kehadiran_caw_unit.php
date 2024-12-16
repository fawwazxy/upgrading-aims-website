<?php

include ('../controller/auth.php');
require "../model/kehadiran_functions.php";
require "../model/lookup.php";

?>
<?

$flag=$_GET['flg'];
$dateSelection=$_GET['dt'];
if(!isset($dateSelection)){
    $dateSelection=date('d-m-Y');

}
if(!isset($flag)){
    $flag='tb_1';

}

$cawangan_kod=$_GET['cawangan_kod'];
$jabatan_kod=$_GET['jabatan_kod'];
$department_sub=$_GET['department_sub'];

if(!isset($cawangan_kod)){
    $cawangan_kod = $_SESSION['SESS_CAWANGAN'];

}
if(!isset($jabatan_kod)){
    $jabatan_kod = $_SESSION['SESS_DEPARTMENT'];

}
if(!isset($department_sub)){
    $department_sub = $_SESSION['SESS_SUB_DEPARTMENT'];

}

//$data = getKehadiran($dateSelection)->fetch_assoc();


function dateDifference($date_1 , $date_2 , $differenceFormat)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}
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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
    </script>


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
        <?
        $flagScreen="tab_1";
        include ('../global/menu_kehadiran_caw_unit.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Kehadiran</h1>
            </div>
        </div>

        <?

        include ('../global/menu_hari_kehadiran_caw_unit.php');
        ?><br><br>

        <div class="row">



            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Senarai Kehadiran</label>
                    </div>
                    <div class="panel-heading" align="center">
                        <!--  <a href="<? echo $sys['sys_domain']; ?>/app/view/panel_imbasan_masuk.php" target="_blank"><button class="btn btn-primary" type="button" >Panel Imbas Masuk</button></a>
							   <a href="<? echo $sys['sys_domain']; ?>/app/view/panel_imbasan_keluar.php" target="_blank"><button class="btn btn-primary" type="button" >Panel Imbas Keluar</button></a>-->
                        <a href="panel_imbasan_masuk.php" target="_blank"><button class="btn btn-primary" type="button" >Panel Imbas Masuk</button></a>
                        <a href="panel_imbasan_keluar.php" target="_blank"><button class="btn btn-primary" type="button" >Panel Imbas Keluar</button></a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Nama</th>
                                <th>Tarikh & Masa</th>
                                <th>Platform</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getKehadiranByCawUnit($dateSelection,$cawangan_kod,$jabatan_kod,$department_sub);
                            while($row_data = $data->fetch_assoc()) {
                                $beza=$row_data['beza'];
                                $total=$row_data['total'];
                                $belum_kira=getTotalJamBekerjaStafSemasa($row_data['nokp_staff']);
                                $total_masa=getJumlahMasaBezaBekerja($row_data['nokp_staff'],$dateSelection,$belum_kira)->fetch_assoc();
                                if($total==""){
                                    $total=$belum_kira;
                                }else{
                                    $total=$total_masa['total_masa_bekerja'];
                                    $beza=$total_masa['total_beza'];
                                    $jam_bekerja_semasa=$total_masa['total_bekerja_semasa'];
                                }

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?>
                                        <br><b>(<?php echo $row_data['nokp_staff']; ?>)</b></td>
                                    <td>
                                        <label class="control-label">Masuk :</label>&nbsp;<?php echo $row_data['masa_masuk']; ?>
                                        <br><label class="control-label">Keluar :</label>&nbsp;<?php echo $row_data['masa_keluar']; ?>
                                        <br><label class="control-label">Baki Beza Masa : </label><?
                                        if($beza>'00:00:00'){?>
                                            <b><font style="color:blue;"><?php echo $beza; ?></font></b>
                                        <?}
                                        else {?>
                                            <b><font style="color:red;"><?php echo $beza; ?></font></b>
                                        <?}?>
                                        <br><label class="control-label">Jum. Jam Bekerja : </label>
                                        <?if($total>'08:00:00'){?>
                                            <b><font style="color:blue;"><?php echo $total;?></font></b>
                                        <?}else{?>
                                            <b><font style="color:red;"><?php echo $total;?></font></b>


                                        <?}if($dateSelection==date('d-m-Y')){

                                            if($row_data['total']!=""){
                                                if($belum_kira!="0"){?>
                                                    <br><label class="control-label">Jum. Jam Terkini : </label>
                                                    <?if($jam_bekerja_semasa>'08:00:00'){?>
                                                        <b><font style="color:blue;"><?php echo $jam_bekerja_semasa;?></font></b>
                                                    <?}else{?>
                                                        <b><font style="color:red;"><?php echo $jam_bekerja_semasa;?></font></b>
                                                    <?}?>
                                                    <br><label class="control-label">Jum. Jam Belum Kira : </label><?php echo $belum_kira;?>

                                                <?}}}
                                        ?>





                                    </td>
                                    <td>
                                        <label class="control-label">Masuk :</label>&nbsp;<?php echo $row_data['device_masuk']; ?>
                                        <br><label class="control-label">Keluar :</label>&nbsp;<?php echo $row_data['device_keluar']; ?>
                                    </td>
                                    <td>
                                        <label class="control-label">Masuk :</label>
                                        <? if( $row_data['remark_masuk']=="LUAR KAWASAN"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['remark_masuk']; ?></font></strong>
                                        <? } else {?>
                                            <strong><font color="blue">
                                                    <?php echo $row_data['remark_masuk']; ?></font></strong>
                                        <?}?>
                                        <br><label class="control-label">Keluar :</label>
                                        <? if( $row_data['remark_keluar']=="LUAR KAWASAN"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['remark_keluar']; ?></font></strong>
                                        <? } else {?>
                                            <strong><font color="blue">
                                                    <?php echo $row_data['remark_keluar']; ?></font></strong>
                                        <?}?>
                                    </td>
                                    <td>
                                        <?
                                        if( $row_data['status_kehadiran']=="LEWAT"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>
                                        <?  }else if($row_data['status_kehadiran']=="AWAL"){?>
                                            <strong><font color="green">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>
                                        <? }else {?>
                                            <strong><font color="purple">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>
                                        <?}?></td>
                                    <td>
                                        <a href="../view/report_kehadiran_hari.php?dateSelection=<? echo $dateSelection; ?>&noic=<? echo $row_data['nokp_staff']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-info" type="button" >Laporan Kehadiran</button></a>
                                        <a><button class="btn btn-info" onclick="return popitup('../view/pinned_map.php?lokasi=<? echo $row_data['lokasi_masuk'];?>&id=<? echo $row_data['id']?>')">Papar Peta</button></a>
                                    </td>




                                </tr>
                                <?php $i++; } ?>


                            </tbody>

                        </table>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
            <!-- /.col-lg-12 -->
        </div>


        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#cawangan_kod,#jabatan_kod,#department_sub").change(function(){
            var selected_cawangan=$("#cawangan_kod").val();
            var selected_jabatan=$("#jabatan_kod").val();
            var selected_sub=$("#department_sub").val();
            sendType(selected_cawangan,selected_jabatan,selected_sub);
        });

    });
    function sendType(cawangan,jabatan,sub)
    {

        window.location.href="senarai_kehadiran_caw_unit.php?dt=<? echo $dateSelection;?>&flg=<? echo $flag;?>&cawangan_kod="+cawangan+"&jabatan_kod="+jabatan+"&department_sub="+sub;

    }
</script>

</body>

</html>
