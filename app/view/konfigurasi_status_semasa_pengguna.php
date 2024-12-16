<?php

include ('../controller/auth.php');

require "../model/config_pengguna_functions.php";
require "../model/lookup.php";

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

</head>
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
                <h1 class="page-header">Status Semasa Penggunaan Aplikasi</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <br><div class="panel panel-red">
                    <div class="panel-heading" align="center">
                        <label class="control-label" for="date">Status Semasa Penggunaan Aplikasi</label>
                    </div>
                    <!-- /.panel-heading -->
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th bgcolor="#D6DBDF" width="33.3%"><center>Pengguna Berdaftar</center></th>
                            <th bgcolor="#D6DBDF" width="33.3%"><center>Telah Pasang</center></th>
                            <th bgcolor="#D6DBDF" width="33.3%"><center>Belum Pasang</center></th>

                        </tr>
                        </thead>
                        <?


                        ?>
                        <tbody>
                        <td bgcolor="#FDFEFE" align="center"><strong><font size="6" color="blue"><?echo countPenggunaBerdaftar();?></font></strong></td>
                        <td bgcolor="#FDFEFE" align="center" onclick="return popitup('laporan_senarai_pengguna.php?status=telah&sys_id=<? echo $sys['sys_id'];?>')"><strong><font size="6" color="green"><?echo countPenggunaTelahPasang();?></font></strong></td>
                        <td bgcolor="#FDFEFE" align="center" onclick="return popitup('laporan_senarai_pengguna.php?status=belum&sys_id=<? echo $sys['sys_id'];?>')"><strong><font size="6" color="red"><?echo countPenggunaBerdaftar() - countPenggunaTelahPasang();?></font></strong></td>

                        </tbody>
                    </table>
                </div>


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