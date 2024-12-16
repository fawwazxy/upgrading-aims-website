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
        $flagScreen="tab_4";
        include ('../global/menu_niaga.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Resit Bayaran</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">


            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Bayaran
                    </div>


                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Resit Bayaran</th>
                                <th>No. Inbois</th>
                                <th>Pelanggan</th>
                                <th>Keterangan Bayaran</th>
                                <th>Status Bayaran</th>
                                <th>Status Penerimaan Bayaran</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getBayaran();
                            while($row_data = $data->fetch_assoc()) {

                                $notel_rujukan=$row_data['notel_rujukan'];
                                $id_bayaran=$row_data['id_bayaran'];
                                $noinbois = $row_data['norujukan_inbois'];

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_bayaran']; ?></td>
                                    <td><?php echo $row_data['norujukan_inbois']; ?></td>
                                    <td><?php echo $row_data['agensi_rujukan']; ?><br><br>Untuk perhatian: <?php echo $row_data['nama_rujukan']; ?></td>

                                    <td>Tarikh Bayaran :<b><?php echo $row_data['tarikh_bayaran']; ?></b><br><br>Jumlah Yang Dibayar: <b>RM<?php echo number_format($row_data['jumlah_bayaran'],2); ?></b></td>
                                    <td>

                                        <?
                                        if($row_data['status_bayaran'] == 1) {
                                            echo "<font color=blue><strong>SUDAH DIJELASKAN</strong></font>";

                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $status_penerimaan_bayaran = $row_data['status_penerimaan_bayaran'];

                                        if ($status_penerimaan_bayaran == 0) {
                                            echo "<font color=red><strong>DALAM PENERIMAAN</strong></font>";

                                            ?>
                                            <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $notel_rujukan; ?>&text=Assalamualaikum. Pembayaran bagi No. Inbois:<?php echo $noinbois;?> telah diterima oleh pihak kami. Terima kasih. Sila klik link di bawah untuk mengesahkan dokumen Resit Bayaran anda. Link adalah seperti berikut: <? echo $sys_domain; ?>/app/template/bayaran_niaga.php?id%3d<? echo $id_bayaran; ?>')" >WhatsApp Resit Bayaran </button><br>

                                            <?php
                                        }
                                        else {
                                            echo "<font color=blue><strong> TERIMA</strong></font><br>";

                                            ?>


                                            <?
                                        }
                                        ?>


                                    </td>


                                    <td>



                                        <a href="" onclick="return popitup('../template/bayaran_niaga.php?id=<? echo $row_data['id_bayaran'];?>')"><button class="btn btn-warning" type="button" >Cetak Resit Bayaran</button></a><br>




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
