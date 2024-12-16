<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>
<?

$lead = $_GET['lead'];

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
        $flagScreen="tab_3";
        include ('../global/menu_niaga.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Inbois</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">


            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Inbois
                    </div>






                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Inbois</th>
                                <th>No. Sebutharga</th>
                                <th>Pelanggan</th>
                                <th>Jumlah (RM)</th>
                                <th>Status</th>
                                <th>Baki Bayaran</th>
                                <th>Status Penerimaan Inbois</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getInbois();
                            while($row_data = $data->fetch_assoc()) {



                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_inbois']; ?></td>
                                    <td><?php echo $row_data['norujukan_sebut_harga']; ?></td>
                                    <td><?php echo $row_data['agensi_rujukan']; ?><br><br>Untuk perhatian: <?php echo $row_data['nama_rujukan']; ?></td>								        <td><?php echo number_format($row_data['jumlah_sebut_harga'],2); ?></td>
                                    <td>
                                        <?php
                                        $status_inbois = $row_data['status_inbois'];

                                        if ($status_inbois == 0) {
                                            echo "<font color=red><strong>AKTIF</strong></font><br>";

                                            ?>


                                            <?
                                        }
                                        else {
                                            echo "<font color=blue><strong>SELESAI</strong></font><br>";

                                        }
                                        ?>
                                    </td>

                                    <td><?php $baki=($row_data['jumlah_sebut_harga']-$row_data['jumlah_bayaran']);

                                        echo number_format($baki,2);?></td>

                                    <td>
                                        <?php
                                        $status_penerimaan_inbois = $row_data['status_penerimaan_inbois'];

                                        if ($status_penerimaan_inbois == 0) {
                                            echo "<font color=red><strong>BELUM TERIMA</strong></font>";

                                            ?><?php $id_inbois = $row_data['id_inbois']; ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo  $row_data['notel_rujukan']; ?>&text=Assalamualaikum. Sila klik link di bawah untuk mengesahkan dokumen Inbois anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/inbois_niaga.php?id%3d<? echo $id_inbois;?>')" >WhatsApp Inbois </button><br>

                                            <?php
                                        }
                                        else {
                                            echo "<font color=blue><strong> TERIMA</strong></font><br>";

                                        }
                                        ?>


                                    </td>
                                    <td>

                                        <a href="" onclick="return popitup('../template/do_niaga.php?id=<? echo $row_data['id_inbois'];?>')"><button class="btn btn-info" type="button" >Cetak D.O</button></a>

                                        <a href="" onclick="return popitup('../template/inbois_niaga.php?id=<? echo $row_data['id_inbois'];?>')"><button class="btn btn-info" type="button" >Cetak Inbois</button></a>

                                        <? if($baki>0){ ?>

                                        <a href="niaga_bayaran_add.php?id_inbois=<? echo $row_data['id_inbois']; ?>"><button type="button" class="btn btn-warning">Jana Resit Bayaran</button>


                                            <? } ?>




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
