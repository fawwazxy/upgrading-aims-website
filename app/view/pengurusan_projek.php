<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";

?>

<?

$id_pesanan_belian = $_GET['id_pesanan_belian'];

$no_staff = $_GET['no_staff'];

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

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>


    <style>
        .blink_text {

            animation:1s blinker linear infinite;
            -webkit-animation:1s blinker linear infinite;
            -moz-animation:1s blinker linear infinite;

            color: red;
        }

        @-moz-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @-webkit-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }


    </style>

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
                $flagScreen="tab_1";
                include ('../global/menu_pengurusan_projek.php');

                ?>
                <h1 class="page-header">Senarai Tugasan Dalam Penerimaan</h1>

            </div>

            <div class="panel-heading" align="right">
                <a target="_blank" href="../report/analisa_pengurusan_projek_mengikut_ketua.php?no_staff=<? echo $no_staff ?>"><button type="submit" class="btn btn-warning">Lihat Analisa</button></a>
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
                                <th>Rujukan Dalaman</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_details = getPesananBelianDetails($no_staff);
                            while($log = $log_details->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $log['tajuk_sebut_harga']; ?><br>

                                        <a href="../controller/downloadFileProject.php?id_pesanan_belian=<?echo $log['id_pesanan_belian'];?>&action=projek"><button class="btn "><i class="fa fa-download"></i> Muat Turun Dokumen Projek</button></a>

                                    </td>
                                    <td><?php echo $log['agensi_rujukan'];?><br><br>Pegawai Rujukan Agensi:<?php echo $log['nama_rujukan']; ?></td>

                                    <td>
                                        <a href="" onclick="return popitup('staff_details.php?no_staff=<? echo $log['pegawai_dalaman'];?>')">
                                            <u><?php echo $log['nama_pegawai_dalaman'];?></a></u></td>
                                    <td><?php
                                        if($log['status_penerimaan_tugas']=='DP'){

                                            ?>

                                            <!-- <font color=blue><strong><?php //echo $list['status_tuntut'];?></strong></font></td>
													<font color=red><strong><span class="blink_text">BELUM TERIMA</span></strong></font> -->
                                            <font color=red><strong><span class="blink_text"><? echo $log['penerangan']; ?></span></strong></font>

                                            <?
                                        } else {

                                            ?>
                                            <!-- echo "<font color=blue><strong>TUGASAN DITERIMA</strong></font>"; -->
                                            <font color=blue><strong><? echo $log['penerangan']; ?></strong></font>

                                            <?
                                        }
                                        ?>

                                    </td>
                                    <td width="15%">

                                        <?php

                                        if($log['status_penerimaan_tugas']=='DP'){

                                            ?>
                                            <a href="../controller/pengesahan_tugas_exec.php?id=<? echo $log['id_pesanan_belian']?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF'];?>"<button type="submit" class="btn btn-success" >TERIMA</button></a>

                                            <a href="../controller/pengesahan_tolak_tugas_exec.php?id=<? echo $log['id_pesanan_belian']?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF'];?>"<button type="submit" class="btn btn-danger" >TOLAK</button></a>

                                            <?
                                        } else {

                                        }
                                        ?>

                                        <?php
                                        if($log['status_penerimaan_tugas']=='T' ){

                                            ?>
                                            <a href="projek_add.php?id_pesanan_belian=<? echo $log['id_pesanan_belian'];?>"><button class="btn btn-primary" type="button" >Tambah Maklumat </button></a>
                                            <?

                                        }
                                        ?>
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
    });
</script>

</body>

</html>