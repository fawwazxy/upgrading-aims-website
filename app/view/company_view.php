<?php

include ('../controller/auth.php');

require "../model/functions.php";

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
                <h1 class="page-header">Maklumat Syarikat</h1>
            </div>
        </div>
        <div class="panel-heading" align="right">
            <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Syarikat
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?$company = getCompanyDetails($_SESSION['SESS_COM'])->fetch_assoc();?>
                        <form>
                            <div class="form-group" align="left">
                                <div class="form-group" align="left">
                                    <label>Nama Syarikat</label><br>
                                    <?echo $company['name']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Nama Ringkas Syarikat</label><br>
                                    <?echo $company['short_name']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>No. Pendaftaran</label><br>
                                    <?echo $company['registration_no']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>No. Telefon</label><br>
                                    <?echo $company['tel']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Emel</label><br>
                                    <?echo $company['email']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Laman Sesawang</label><br>
                                    <?echo $company['website']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Alamat</label><br>
                                    <?echo $company['address']?>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Pemilik Syarikat</label><br>
                                    <?echo $company['authorized_name']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tagline</label><br>
                                    <?echo $company['tagline']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Slogan</label><br>
                                    <?echo $company['slogan']?>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Penandatangan</label><br>
                                    <?echo '<img border="1" width="200" height="200" src="data:image/jpeg;base64,'.base64_encode( $company['authorized_signatory'] ).'"/>';?><br>
                                    <?echo $company['authorized_signatory_filename']?>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Cop Perniagaan</label><br>
                                    <?echo '<img border="1" width="200" height="200" src="data:image/jpeg;base64,'.base64_encode( $company['company_stamp'] ).'"/>';?><br>
                                    <?echo $company['company_stamp_filename']?>
                                </div>
                                <div class="form-group" align="left">
                                    <label>Logo Perniagaan</label><br>
                                    <?echo '<img border="1" width="200" height="300" src="data:image/jpeg;base64,'.base64_encode( $company['logo'] ).'"/>';?><br>
                                    <?echo $company['logo_filename']?>
                                </div>


                                <div class="modal-footer">
                                    <div align="left">
                                        <a href="company_edit.php"><button class="btn btn-primary" onclick="" type="button" >Kemaskini</button></a><br><br>
                                    </div>
                                </div><br>
                        </form>
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

</body>

</html>
