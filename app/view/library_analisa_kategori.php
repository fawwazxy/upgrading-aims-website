<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$id_jenis = $_GET['id'];
$data_jenis = getJenisById($id_jenis)->fetch_assoc();


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
                <h1 class="page-header">Kategori : <?echo $data_jenis['jenis']?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Pinjaman Bahan Bacaan</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">Bil.</th>
                                <th width="30%">Tajuk</th>
                                <th width="20%">Jum. Dipinjam</th>
                                <th width="20%">Jum. Keseluruhan</th>
                                <th width="20%">Jum. Tempahan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $jenis = getAnalisaJenis($id_jenis);
                            $i=1;
                            while($list_jenis = $jenis->fetch_assoc()) {

                                //$bil_masih_ada=$list_jenis['bil_naskah_hardcopy']- getBilDokumenDipinjam($list_jenis['id_library']);
                                //$bil_dipinjam =getBilDokumenDipinjam($list_jenis['id_library']);
                                $bil_ditempah=getBilDokumenDitempah($list_jenis['id_library']);

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td>
                                        <strong><font size="5" color="black"><?echo $list_jenis['nama_library'] ;?></font></strong>
                                    </td>
                                    <td>
                                        <center><strong><font size="5" color="blue"><?echo getBilDokumenDipinjam($list_jenis['id_library']);?></font></strong></center>
                                    </td>
                                    <td>
                                        <center><strong><font size="5" color="green"><?echo $list_jenis['bil_naskah_hardcopy']?></font></strong></center>
                                    </td>
                                    <td>
                                        <center><strong><font size="5" color="red"><?echo $bil_ditempah;?></font></strong></center>
                                    </td>
                                </tr>
                            <?}?>

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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>