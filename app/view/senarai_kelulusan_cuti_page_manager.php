<?php

include ('../controller/auth.php');

require "../model/cuti_function.php";


?>
<?
$staff_holiday_id = $_GET['staff_holiday_id'];
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
                <h1 class="page-header">Permohonan Cuti</h1>
            </div>

            <div class="panel-heading" align="right">


            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Maklumat Cuti Pekerja
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <thead>
                            <tr>
                                <th>#</th>

                                <th>Nama</th>
                                <th>Tarikh Mohon</th>
                                <th>Tarikh Mula Cuti</th>
                                <th>Tarikh Akhir Cuti</th>
                                <th>Jumlah Cuti Dipohon</th>

                                <th>Baki Cuti Semasa</th>
                                <th>Sebab</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?

                            $i= 1;
                            $pemohon=  getSenaraiPemohonCutiPageManager($_SESSION['SESS_NO_STAFF']);


                            while($row_pemohon = $pemohon->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <a data-toggle="modal" href="#modalAkses<?php echo $i; ?>"><?php echo $row_pemohon['nama_pekerja']; ?></a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalAkses<?php echo $i; ?>" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title"><b>Status Cuti Pemohon </b></h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <p>Nama : <?php echo $row_pemohon['nama_pekerja'];?></p><br>
                                                        <p>No Telefon: <?php echo $row_pemohon['phone'];?></p><br>
                                                        <p>Alamat Surat : <?php echo $row_pemohon['alamat_surat'];?></p><br>
                                                        <p>Tarikh Mohon : <?php echo $row_pemohon['created_date'];?></p><br>
                                                        <p>Tarikh Mula Cuti : <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_mula']));?></p><br>
                                                        <p>Tarikh Tarikh Akhir Cuti :<? echo date('d/m/Y',strtotime($row_pemohon['tarikh_akhir']));?></p><br>
                                                        <p>Jumlah Cuti Dipohon: <?php echo $row_pemohon['jumlah_cuti'];?></p><br>

                                                        <p>Baki Cuti Semasa: <?php echo $row_pemohon['baki_cuti'];?></p><br>
                                                        <p>Baki Cuti Dipohon : <?php echo $row_pemohon['baki_pohon_rekod'];?></p><br>
                                                        <p>Status : <?php echo $row_pemohon['status_cuti'];?></p><br>
                                                        <p>Catatan : <?php echo $row_pemohon['catatan'];?><br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $row_pemohon['tarikh_mohon']; ?></td>
                                    <td><? echo date('d/m/Y',strtotime($row_pemohon['tarikh_mula']));?></td>
                                    <td><? echo date('d/m/Y',strtotime($row_pemohon['tarikh_akhir']));?></td>
                                    <td><?php echo $row_pemohon['jumlah_cuti']; ?></td>
                                    <td><?php echo $row_pemohon['baki_cuti'];?></td>
                                    <td><?php echo $row_pemohon['sebab']; ?></td>


                                    <td><font color=red><strong><?php echo $row_pemohon['status_cuti'];?></strong></font></strong></td>

                                    <td>



                                        <?
                                        if ($row_pemohon['approvement'] == 'SD') { ?>

                                            <a href="lulus_cuti_page_manager.php?staff_holiday_id=<? echo $row_pemohon['id'];?>&no_staff=<? echo $row_pemohon['no_staff'];?>"><button class="btn btn-info" onclick="return Alert()" type="button" >Luluskan</button></a>




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
