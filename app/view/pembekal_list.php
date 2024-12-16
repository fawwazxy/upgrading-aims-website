<?php

include ('../controller/auth.php');
require "../model/pembekal_function.php";
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
                <h1 class="page-header">Senarai Pembekal</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">
                <a href="pembekal_add.php" > <button type="button" class="btn btn-primary">Tambah Pembekal</button></a>
            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pembekal
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th>Kod Pembekal</th>
                                <th>Nama Syarikat</th>
                                <th>Nama Singkatan</th>
                                <th>Pegawai Perhubungan</th>
                                <th>Alamat</th>
                                <th>No. Tel</th>
                                <th>No. Fax</th>

                                <th widht="50px">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getPembekal();
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['supplier_code']; ?></a></td>
                                    <td><a href="pembekal_detail.php?id=<? echo $row_data['id'];?>"><?php echo $row_data['company_name']; ?></a></td>
                                    <td><?php echo $row_data['short_name']; ?></a></td>
                                    <td><?php echo $row_data['person_incharge']; ?></a></td>
                                    <td><?php echo $row_data['address1']; ?>, <?php echo $row_data['address2']; ?>, <?php echo $row_data['district']; ?>, <?php echo $row_data['city']; ?>, <?php echo $row_data['state']; ?>, <?php echo $row_data['country']; ?></a></td>
                                    <td><?php echo $row_data['contact_no']; ?></td>
                                    <td><?php echo $row_data['fax_no']; ?></a></td>

                                    <td>

                                        <a href="pembekal_edit.php?id=<?php echo $row_data['id']; ?>"><button type="button" class="btn btn-info"  >Kemaskini</button></a>

                                        <a href="../controller/pembekal_exec.php?act=pembekal_delete&id=<?php echo $row_data['id']; ?>">
                                            <button type="button" class="btn btn-danger" onClick="return confirm('Adakah anda pasti mahu memadam data ini?')";\">Padam</button></a>

                                        <a href="config_supplier.php?supplier=<?php echo $row_data['supplier_code']; ?>"><button type="button" class="btn btn-info"  >Konfigurasi Pembekal</button></a>

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
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Projek</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'pm_projek_kemaskini.php',
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
