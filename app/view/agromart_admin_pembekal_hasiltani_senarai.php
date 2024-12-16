<?php

include ('../controller/auth.php');

require "../model/agromart_functions.php";
require "../model/lookup.php";

$nokp_seller = $_GET['nokp'];
$id = $_GET['id'];
$id_agencies = $_GET['id_agencies'];
$pembekal_info = getPembekalInfoById($id,$id_agencies)->fetch_assoc();

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
                <h1 class="page-header">Senarai Produk</h1>
                <h4><b><?echo $pembekal_info['nama'];?></b></h4>
                <h4><b><?echo $nokp_seller;?></b></h4>
                <h4><b><?echo $pembekal_info['nama_agensi'];?></b></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="form-group" align="right">
                </div>
                <div class="form-group" align="right">
                    <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='agromart_admin_pembekal_hasiltani_tambah.php?id=<?echo $id;?>&id_agencies=<?echo $id_agencies;?>&nokp_seller=<?echo $nokp_seller;?>'">Kemaskini</button>
                    <a class="view" target="blank" href="agromart_admin_tag_cetak_semua.php?id_agencies=<?echo $id_agencies;?>&nokp_seller=<?echo $nokp_seller;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Semua Tag</button></a>
                    <button class="btn btn-primary" id="btn_pelanggan" onclick="window.location.href='agromart_admin_pembekal_senarai.php?id=<?echo $id_agencies;?>'">Kembali</button>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">Senarai Produk</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil.</th>
                                <th width="15%">Nama Item</th>
                                <th width="15%">Kodbar</th>
                                <th width="20%">Harga Belian Semasa (RM)</th>
                                <th width="20%">Harga Jualan Semasa (RM)</th>
                                <th width="10%">Kuantiti</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $hasiltani = getPembekalHasilTaniList($id_agencies,$nokp_seller);
                            $i=1;
                            while($list_hasiltani = $hasiltani->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><b><?echo $list_hasiltani['kod'];?></b> - <?echo $list_hasiltani['nama_item'];?>
                                        <br></td>
                                    <td><p><font size="1"><?echo $list_hasiltani['nama_item'];?> RM<?echo $list_hasiltani['harga_runcit'];?></font>
                                            <br><img border=0 alt="<?echo $data['barcode']?>" src="../../util/barcode.php?codetype=Code25&size=30&text=<?echo $list_hasiltani['barcode'];?>&print=true" />
                                    </td>
                                    <td><b><font size="5" color="brown"><?echo $list_hasiltani['harga_jualan_semasa'];?></font></b></td>
                                    <td><b><font size="5" color="brown"><?echo $list_hasiltani['harga_runcit'];?></font></b></td>
                                    <td><b><font size="5" color="blue"><?echo $list_hasiltani['kuantiti'];?></font></b></td>
                                    <td>
                                        <a class="view" target="blank" href="agromart_admin_tag_cetak.php?id=<?echo $list_hasiltani['id'] ;?>&id_stock_type=<?echo $list_hasiltani['id_stock_type'] ;?>&id_agencies=<?echo $id_agencies;?>&nokp_seller=<?echo $nokp_seller;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Tag</button></a>

                                        <input type="hidden" id="row_id" value="<?echo $list_hasiltani['id'];?>">
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

</script>

</body>

</html>