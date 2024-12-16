<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";
require "../model/lookup.php";


?>
<?

$bln=$_GET['mnt'];
$thn=$_GET['yr'];


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
        $flagScreen="tab_2";
        include ('../global/menu_kehadiran_caw_unit.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Keseluruhan Kehadiran</h1>
            </div>
        </div>
        <?
        $flag=$_GET['flg'];
        include ('../global/menu_bulan_caw_unit.php');
        ?>
        <div class="row">



            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Keseluruhan Kehadiran
                    </div>






                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Status Kehadiran</th>
                                <th>Jum. Jam Masa Bekerja</th>
                                <th>jum. Baki Beza Masa</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;

                            $data = getKeseluruhanKehadiranCawUnit($bln,$thn,$cawangan_kod,$jabatan_kod,$department_sub);
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?><b> (<? echo $row_data['nokp_staff']; ?>)</b></td>

                                    <td>

                                        <?
                                        $jumlah_awal = countHariAwal($row_data['nokp_staff'],$bln,$thn);
                                        $jumlah_tepat = countHariTepat($row_data['nokp_staff'],$bln,$thn);
                                        $jumlah_lewat = countHariLewat($row_data['nokp_staff'],$bln,$thn);
                                        ?>
                                        <label>Awal : </label>
                                        <?if($jumlah_awal == '') {echo '<b><font color="green" size="4">0</font></b>&nbsp;Hari';}
                                        else {echo '<b><font color="green" size="4">'.$jumlah_awal.'</font></b>&nbsp;Hari';}?>
                                        <br><label>Tepat : </label>
                                        <?if($jumlah_tepat == '') {echo '<b><font color="purple" size="4">0</font></b>&nbsp;Hari';}
                                        else {echo '<b><font color="purple" size="4">'.$jumlah_tepat.'</font></b>&nbsp;Hari';}?>
                                        <br><label>Lewat : </label>
                                        <?if($jumlah_lewat == '') {echo '<b><font color="red" size="4">0</font></b>&nbsp;Hari';}
                                        else {echo '<b><font color="red" size="4">'.$jumlah_lewat.'</font></b>&nbsp;Hari';}?>
                                    </td>

                                    <td><?php echo $row_data['total']; ?></td>
                                    <td><?php echo $row_data['beza']; ?></td>
                                    <td>


                                        <a href="../view/senarai_kehadiran_by_staff.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&name=<?php echo $row_data['name']; ?>&noic=<? echo $row_data['nokp_staff']; ?>"><button class="btn btn-info" type="button" >Keseluruhan</button></a>
                                        <a href="../view/report_kehadiran_bulan.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data['nokp_staff']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-info" type="button" >Laporan Keseluruhan</button></a>
                                        <a href="../view/electronic_time_card.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data['nokp_staff']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-success" type="button" >Electronic Time Card</button></a>

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

        window.location.href="senarai_keseluruhan_kehadiran_caw_unit.php?mnt=<? echo $bln;?>&yr=<? echo $thn;?>&flg=<? echo $flag;?>&cawangan_kod="+cawangan+"&jabatan_kod="+jabatan+"&department_sub="+sub;

    }
</script>

</body>

</html>
