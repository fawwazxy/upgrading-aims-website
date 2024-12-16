<?php

include ('../controller/auth.php');

require "../model/claim_function.php";

?>

<?
$value = $_GET['value'];
$claim_id=$_GET['claim_id'];
$no_staff=$_GET['no_staff'];

updateNotiPelulus('1',$no_staff,'TL');

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
    <script language="JavaScript" type="text/javascript">
        function Alert(){
            return confirm('Anda pasti untuk meneruskan?');
        }

        <script language="javascript" type="text/javascript">


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
                include ('../global/menu_tuntutan_2.php');

                ?>

                <h1 class="page-header">Senarai Tuntutan Tidak Lulus</h1>
            </div>

            <!--<div class="panel-heading" align="right">
		<a href="pohon_tuntutan_baru.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']; ?>">
		<button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Pohon Tuntutan Baru</button></a>
		
		</div>--></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Tuntutan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pemohon</th>
                                <th>Tarikh Tuntutan</th>
                                <th>Nama Tuntutan</th>
                                <th>Jumlah (RM)</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_tuntutan= getSenaraiTuntutanPekerjaTidakLulus($no_staff);
                            while($list = $log_tuntutan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $list['nama']; ?>
                                    <td><?php echo $list['tarikh_dipohon']; ?></td>
                                    <td><?php echo $list['nama_tuntutan']; ?></td>
                                    <td>RM <?php echo $list['jumlah_tuntut']; ?></td>
                                    <td><font color=red><strong><?php echo $list['status_tuntut'];?></strong></font></td>

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
        <? include ('../global/footer.php'); ?>
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