<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$id_library = $_GET['id'];
$data_library = getLibraryById($id_library)->fetch_assoc();


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
                <h3 class="page-header">Tajuk : <?echo $data_library['nama']?><br><br>Kategori : <?echo $data_library['jenis']?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Tempahan Bahan Bacaan</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th>Nama</th>
                                <th>No. Kad Pengenalan</th>
                                <th>No. Telefon</th>
                                <th width="15%">Status Tempahan</th>
                                <!--<th width="18%">Tindakan</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $tempahan = getAnalisaBooking($id_library);
                            $i=1;
                            while($list_tempahan = $tempahan->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo $list_tempahan['nama_peminjam'] ;?></td>
                                    <td><?echo $list_tempahan['nokp'] ;?></td>
                                    <td><strong><font size="4" color="brown">+6<?echo $list_tempahan['notel'] ;?></font></strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <?if($list_tempahan['status_urgent']==1){?>
                                                <font size="4" color="red">Segera</font>
                                            <?}else{?>
                                                <font size="4" color="blue">Tidak Segera</font>
                                            <?}?>
                                        </strong>
                                    </td>
                                    <!--<td>
                                            <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<? echo $list_tempahan['id_tempahan'];?>">Pinjaman</a>
                                        </td>-->
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Peminjam</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'library_peminjam_tempahan.php',
                            data:{id_tempahan:rowid},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>