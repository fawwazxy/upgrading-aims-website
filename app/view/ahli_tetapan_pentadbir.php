<?php

include ('../controller/auth.php');

require "../model/ahli_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_5';

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
        <?include '../global/ahli_menu_konfigurasi.php'?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">Senarai Ahli</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Ahli</th>
                                <th>Kategori Ahli</th>
                                <th>Nama</th>
                                <th>No. Telefon</th>
                                <th>Alamat</th>
                                <th>Galur</th>
                                <th>kategori Umur</th>
                                <th>Status</th>
                                <th>Peranan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_ahli = getAhliTetapanAdmin();
                            while($row_data_ahli = $data_ahli->fetch_assoc()) {
                                $status=$row_data_ahli['status'];
                                $status_admin=$row_data_ahli['role'];
                                $id=$row_data_ahli['id'];



                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i;?></td>
                                    <td><? echo $row_data_ahli['no_ahli'];?></td>
                                    <td><? echo $row_data_ahli['kategori_ahli'];?></td>
                                    <td><? echo $row_data_ahli['nama'];?></td>
                                    <td><? echo $row_data_ahli['notel'];?></td>
                                    <td><? echo $row_data_ahli['alamat'];?></td>
                                    <td><? echo $row_data_ahli['nama_galur'];?></td>
                                    <td><? echo $row_data_ahli['keterangan'];?></td>
                                    <td>
                                        <?
                                        if ($status == 1) {
                                            echo "<font color=blue><strong>AKTIF</strong></font>";
                                        }
                                        else {
                                            echo "<font color=red><strong>TIDAK AKTIF</strong></font>";
                                        }?>

                                    </td>
                                    <td>
                                        <?
                                        if ($status_admin == 1) {
                                            echo "<font><strong>ADMIN</strong></font>";
                                        }
                                        else {
                                            echo "<font ><strong>AHLI</strong></font>";
                                        }?>

                                    </td>
                                    <td>
                                        <?
                                        if ($status_admin == 1) {
                                            echo "<button class='btn btn-warning' onclick='tetapanAdmin($id,0)'>AHLI</button>";
                                        }
                                        else {
                                            echo "<button class='btn btn-success' onclick='tetapanAdmin($id,1)'>ADMIN</button>";
                                        }?>

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

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function tetapanAdmin(id,status){
        $.ajax({
            url: "../model/ahli_functions.php",
            type: "POST",
            data: {action:"tetapanAdmin",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='ahli_tetapan_pentadbir.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

</script>

</body>

</html>