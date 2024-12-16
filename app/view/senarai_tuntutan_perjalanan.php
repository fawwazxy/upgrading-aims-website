<?php

include ('../controller/auth.php');

require "../model/claim_function.php";


?>
<?
$tuntut_jarak_id = $_GET['tuntut_jarak_id'];
$no_staff = $_GET['no_staff'];





// $nama = getLoguser($_GET ($_SESSION['SESS_COM'])) -> fetch_assoc();
?>


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <script language="JavaScript" type="text/javascript">
        function Alert(){
            return confirm('Anda pasti untuk meneruskan?');
        }

    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

</head>

<body>

<style>
    p{
        font-size: 120%;

    }
</style>
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
                <h1 class="page-header">Senarai Tuntutan Perjalanan/Kenderaan</h1>
            </div>

            <div class="panel-heading" align="right">


            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Maklumat Tuntutan <b>Perjalanan/Kenderaan</b>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th>#</th>

                                <th>Nama Pekerja</th>
                                <th>Tarikh Pohon</th>
                                <th>Tarikh Perjalanan</th>
                                <th>Dari</th>
                                <th>Ke</th>
                                <th>jumlah jarak</th>
                                <th>Jumlah Tuntutan</th>
                                <th>Dokumen</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?

                            $i= 1;
                            $pemohon=  getSenaraiTuntutanPerjalananPemohon($_SESSION['SESS_NO_STAFF']);


                            while($row_pemohon = $pemohon->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><b><?php echo $row_pemohon['nama_pekerja']; ?></b></td>

                                    <td><? echo date('d/m/Y',strtotime($row_pemohon['tarikh_pohon']));?></td>
                                    <td><? echo date('d/m/Y',strtotime($row_pemohon['tarikh_journey']));?></td>
                                    <td><?php echo $row_pemohon['tempat_from']; ?></td>
                                    <td><?php echo $row_pemohon['tempat_to'];?></td>
                                    <td><?php echo $row_pemohon['jumlah_jarak']; ?> KM</td>
                                    <td>RM <?php echo $row_pemohon['jumlah_tuntutan']; ?></td>
                                    <td></td>
                                    <td><?php echo $row_pemohon['catatan_perjalanan'];?></td>



                                    <td><font color=red><strong><?php echo $row_pemohon['status_jarak'];?></strong></font></strong></td>

                                    <td>



                                        <?



                                        if ($row_maklumat_cuti['approve_status'] == 'BD') { ?>

                                            <a href="kemaskini_borang_permohonan.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-info" type="button" onclick="return Kemaskini()" >Kemaskini</button></a>

                                            <a href="../controller/hantar_button_exec.php?staff_holiday_id=<? echo $row_maklumat_cuti['id'];?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-success" type="button" onclick="return Confirm()" >Hantar</button></a>


                                            <?
                                        }

                                        ?>


                                    </td>


                                </tr>
                                <?php $i++; } ?>

                            </tbody>

                        </table><center>
                            <!-- Button trigger modal -->



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
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Adakah anda pasti untuk padam Peranan ini?');
    }


</script>

</body>

</html>

