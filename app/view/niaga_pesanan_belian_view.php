<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>

<?
//$id_inbois = $_GET['id_inbois'];
//$id_bayaran = $_GET['id_bayaran'];
$id_sebut_harga =$_GET['id_sebut_harga'];
$id_pesanan_belian = $_GET['id_pesanan_belian'];

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

        .blink_text_2 {

            animation:1s blinker linear infinite;
            -webkit-animation:1s blinker linear infinite;
            -moz-animation:1s blinker linear infinite;

            color: blue;
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
                <h1 class="page-header">Pesanan Jualan (S.0)</h1>
            </div>

            <div class="panel-heading" align="right">

                <a href="niaga_pesanan_belian_update.php?id_sebut_harga=<? echo $id_sebut_harga; ?>"><button type="button" class="btn btn-info">Kemaskini</button></a>
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">

                                <?


                                $row=  getMaklumatPO($id_sebut_harga)->fetch_assoc();

                                ?>

                                <form method="post" enctype="multipart/form-data"action="../controller/niaga_pesanan_belian_exec.php?id_sebut_harga=<? echo $id_sebut_harga;?>" >


                                    <input name="id_inbois" type="hidden" class="input-short" value="<? echo $_GET['id_sebut_harga']; ?>" />





                                    <label>Perkara</label><br>
                                    <? echo $row['tajuk_sebut_harga'];?>
                                    <br><br>

                                    <label>No. Rujukan Sebutharga</label><br>
                                    <? echo $row['norujukan_sebut_harga'];?>
                                    <br><br>

                                    <label>Pelanggan</label><br>
                                    <? echo $row['agensi_rujukan'];?>
                                    <br><br>

                                    <label>Untuk Rujukan</label><br>
                                    <? echo $row['nama_rujukan'];?>
                                    <br><br>

                                    <label>Tarikh Pesanan Jualan Diterima</label><br>
                                    <? echo $row['tarikh_pesanan_belian'];?>
                                    <br><br>

                                    <label>Jumlah Harga </label><br>
                                    RM<? echo number_format($row['jumlah_harga'],2);?>
                                    <br><br>

                                    <label>Dokumen Pesanan Jualan</label><br>
                                    <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['document'] ).'" style="width: 300px; height: 310px;"/>';?>
                                    <br><br>

                                    <label>Pegawai Pelaksana </label><br>
                                    <? echo $row['nama_pegawai_pelaksana'];?>
                                    <br><br>



                                    <label>Nama Bahagian </label><br>
                                    <? echo $row['nama_bahagian'];?>
                                    <br><br>


                                    <label>Dokumen Rujukan</label>
                                    <br>

                                    <a href="../controller/downloadFileProject.php?id_pesanan_belian=<?echo $row['id_pesanan_belian'];?>&action=so"><i class="fa fa-download"></i> Muat Turun Dokumen Projek</a><br><br>

                                    <label>Status Penerimaan Kerja </label><br>
                                    <? echo $row['penerangan'];?>
                                    <br><br>

                                    <label>Pegawai Rujukan Dalaman </label><br>
                                    <? echo $row['pegawai_rujukan_dalaman'];?>
                                    <br><br>



                            </div>




                            <br>



                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
    </div>



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
