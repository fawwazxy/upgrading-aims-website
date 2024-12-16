<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";

?>

<?

// $pemohon_id = $_GET['pemohon_id'];

$no_staff = $_GET['no_staff'];
$id = $_GET['id'];
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

        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
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
        <div class="row">
            <div class="col-lg-12">
                <?
                $flagScreen="tab_3";
                include ('../global/menu_pengurusan_projek.php');

                ?>
                <h1 class="page-header">Senarai TugasanTelah Selesai</h1>
            </div>

            <div class="panel-heading" align="right">
                <!--a href="permohonan_baru.php">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Permohonan Baru</button></a-->

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Projek
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Projek</th>
                                <th>Pelanggan</th>
                                <th>Jangka Masa Kerja</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_details = getProjekSelesai($no_staff);
                            while($log = $log_details->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $log['tajuk_sebut_harga']; ?></td>
                                    <td><?php echo $log['agensi_rujukan'];?><br><br>Untuk Perhatian:<?php echo $log['nama_rujukan']; ?></td>
                                    <td><?php echo$log['tarikh_mula'];?><br>Hingga<br><?php echo $log['tarikh_akhir']; ?><br>
                                        (<? echo $log['jumlah_hari']?> hari)
                                    </td>
                                    <td>
                                        <? if($log['status_penerimaan_tugas']=='SL'){

                                            ?>
                                            <font color=blue><strong><? echo $log['penerangan']; ?></strong></font><br>
                                            <?
                                        } else {

                                            ?>
                                            <font color=red><strong><? echo $log['penerangan']; ?></strong></font><br>
                                            <a href="../controller/pengesahan_selesai_tugas_exec.php?id=<? echo $log['id_pesanan_belian']?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF'];?>"<button type="submit" class="btn btn-warning" >SELESAI</button></a>

                                        <? } ?>


                                    </td>


                                    <td>

                                        <a href="../template/senarai_pasukan_projek.php?id=<? echo $log['id_pesanan_belian']; ?>" target="_blank"><button class="btn btn-warning" type="button" >Papar Pasukan Projek</button></a>

                                        <a href="../view/gantt_chart.php?id=<? echo $log['id_pesanan_belian']; ?>" target="_blank">
                                            <button type="button" class="btn btn-warning">Carta Gantt </button></a>
                                        <a href="../view/report_keseluruhan_pengurusan_projek.php?id=<? echo $log['id_pesanan_belian']; ?>" target="_blank">
                                            <button type="button" class="btn btn-info">Laporan Keseluruhan</button></a>

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
        <? include ('../global/footer.php'); ?>


        <!-- /.row -->
        <!-- /.container-fluid -->
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
    });
</script>

</body>

</html>