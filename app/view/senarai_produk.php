<?php

include ('../controller/auth.php');

require "../model/surat_function.php";

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
        <?
        $flagScreen="tab_3";
        include ('../global/menu_surat.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Produk</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Baru</button>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Produk
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Produk</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/produk_add_exec.php?" >
                                        <div class="form-group" align="left">
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />




                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group"  align="left">
                                                <label>Nama Produk<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="produk" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Nama singkatan Produk<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" "  name="code" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Penerangan Tentang Produk<font color="red">**</font>&nbsp;</label>
                                                <textarea rows="8" class="form-control" placeholder=" " name="penerangan" ></textarea>
                                            </div>









                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                            </div>

                                    </form>
                                </div><!--modal-body-->
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->

                </div><!-- /.modal -->






                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Singkatan Produk</th>
                            <th>Produk</th>
                            <th>Penerangan Produk</th>



                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?
                        $i= 1;
                        $data = getJenisProduk();
                        while($row_data = $data->fetch_assoc()) {

                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['code']; ?></td>
                                <td><?php echo $row_data['produk']; ?></td>
                                <td><?php echo $row_data['penerangan']; ?></td>



                                <?php echo "<td><a href='#myModal1' class='btn btn-info btn-small' data-toggle='modal' data-id=".$row_data['id'].">Kemaskini</a></td>"; ?>
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
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Produk</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'produk_edit.php',
                            data:'id='+rowid,
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
