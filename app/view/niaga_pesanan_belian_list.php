<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?
$id_sebut_harga=$_GET['id_sebut_harga'];
$id_pesanan_belian=$_GET['id_pesanan_belian'];
//$lead = $_GET['lead'];
//echo "XX".$shortcode = $_GET['shortcode'];

?>
<?
$sys = getSys(1)->fetch_assoc();
$sys_domain=$sys['sys_domain'];
$shortcode=$sys['short_name'];
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
        include ('../global/menu_niaga.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Pesanan Jualan (S.O)</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <a target="_blank" href="../report/analisa_pengurusan_projek.php"><button type="submit" class="btn btn-warning">Lihat Analisa</button></a>


                <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Tambah Sebutharga
        </button> -->
            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pesanan Jualan
                    </div>









                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Sebutharga</th>
                                <th>Perkara</th>
                                <th>Pelanggan</th>
                                <th>Jumlah (RM)</th>
                                <th>Ketua Projek</th>
                                <th>Status</th>

                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getPesananBelianList();
                            while($row_data = $data->fetch_assoc()) {
                                $notel_rujukan=$row_data['notel_rujukan'];
                                $id_sebut_harga=$row_data['id_sebut_harga'];


                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_sebut_harga']; ?></td>
                                    <td><?php echo $row_data['tajuk_sebut_harga']; ?></td>
                                    <td><?php echo $row_data['agensi_rujukan']; ?><br><br>Untuk perhatian: <?php echo $row_data['nama_rujukan']; ?></td>
                                    <td><?php echo number_format($row_data['jumlah_sebut_harga'],2); ?></td>

                                    <td>
                                        <?php echo $row_data['nama_ketua_projek']; ?>
                                    </td>
                                    <td>

                                        <?php
                                        if($row_data['status_penerimaan_tugas']=='SL'){



                                            ?>
                                            <font color=blue><strong><?php echo $row_data['status_projek']; ?></strong></font>
                                        <?} else {

                                            ?>
                                            <font color=red><strong><?php echo $row_data['status_projek']; ?></strong></font>
                                        <?} ?>

                                    </td>



                                    <td>

                                        <a href="niaga_pesanan_belian_view.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>"><button class="btn btn-info" type="button" >Papar S.O</button></a>
                                        <a href="niaga_pesanan_belian_update.php?id_sebut_harga=<? echo $row_data['id_sebut_harga']; ?>"><button type="button" class="btn btn-info">Kemaskini</button></a>


                                        <?php
                                        if ($row_data['status_sebut_harga']== 0 && $row_data['status_penerimaan_sebut_harga'] == 1 && $row_data['status_penerimaan_tugas']=='SL') {

                                            ?>

                                            <!--<a href="../controller/jana_inbois_exec.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>&shortcode=<? echo $shortcode;?>"><button class="btn btn-warning">Jana Inbois</button></a>-->
                                            <a href="../view/report_keseluruhan_pengurusan_projek.php?id=<? echo $row_data['id_pesanan_belian']; ?>" target="_blank">
                                                <button type="button" class="btn btn-info">Laporan Keseluruhan</button></a>

                                        <? } else if($row_data['status_penerimaan_tugas']=='SD'){
                                            ?>
                                            <a href="../view/report_keseluruhan_pengurusan_projek.php?id=<? echo $row_data['id_pesanan_belian']; ?>" target="_blank">
                                                <button type="button" class="btn btn-info">Laporan Keseluruhan</button></a>
                                            <a href="../controller/jana_inbois_exec.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>&shortcode=<? echo $shortcode;?>"><button class="btn btn-warning">Jana Inbois</button></a>

                                        <? } else if($row_data['status_penerimaan_tugas']=='TD'){ ?>
                                            <a href="pengagihan_kerja.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>"><button class="btn btn-warning" type="button" >Pengagihan Semula</button></a>

                                        <? } else if($row_data['status_penerimaan_tugas']=='DP'){ ?>
                                            <a href="../controller/jana_inbois_exec.php?id_sebut_harga=<? echo $row_data['id_sebut_harga'];?>&shortcode=<? echo $shortcode;?>"><button class="btn btn-warning">Jana Inbois</button></a>

                                            <?
                                        }
                                        ?>



                                        <br>
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
