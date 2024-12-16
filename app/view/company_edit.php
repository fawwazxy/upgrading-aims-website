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
                        <div class="col-sm-10">
                            <?$company = getCompanyDetails($_SESSION['SESS_COM'])->fetch_assoc();?>
                            <form method="post" action="../controller/keselamatan_exec.php"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="action" value="company_edit" />
                                <input type="hidden" name="id" value="<?echo $company['id']; ?>" />
                                <input type="hidden" name="sys_id" value="<?echo $sys['sys_id']; ?>" />
                                <div class="form-group" align="left">
                                    <div class="form-group" align="left">
                                        <label>Nama Syarikat</label><br>
                                        <input class="form-control" placeholder="" id="nama_company" name="nama_company" value="<?echo $company['name']?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Nama Ringkas Syarikat</label><br>
                                        <input class="form-control" placeholder="" id="short_name" name="short_name" value="<?echo $company['short_name']?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>No. Pendaftaran</label><br>
                                        <input class="form-control" placeholder="" id="registration_no" name="registration_no" value="<?echo $company['registration_no']?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>No. Telefon</label><br>
                                        <input class="form-control" placeholder="" id="tel" name="tel" value="<?echo $company['tel']?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Emel</label><br>
                                        <input class="form-control" placeholder="" id="email" name="email" value="<?echo $company['email']?>" />
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Laman Sesawang</label><br>
                                        <input class="form-control" placeholder="" id="website" name="website" value="<?echo $company['website']?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Alamat</label><br>
                                        <input class="form-control" placeholder="" id="address" name="address" value="<?echo $company['address']?>"/>
                                    </div>
                                    <div class="form-group" align="left">
                                        <label>Pemilik Syarikat</label><br>
                                        <input class="form-control" placeholder="" id="authorized_name" name="authorized_name" value="<?echo $company['authorized_name']?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Tagline</label><br>
                                        <input class="form-control" placeholder="" id="tagline" name="tagline" value="<?echo $company['tagline']?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Slogan</label><br>
                                        <input class="form-control" placeholder="" id="slogan" name="slogan" value="<?echo $company['slogan']?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Penandatangan</label><br>
                                        <?echo '<img border="1" width="200" height="200" src="data:image/jpeg;base64,'.base64_encode( $company['authorized_signatory'] ).'"/>';?><br>
                                        <?echo $company['authorized_signatory_filename']?><br>
                                        <div class="input-group input-file" name="authorized_signatory">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Pilih Logo Baru</button>
                                </span>
                                            <input type="text" class="form-control" placeholder='' />
                                        </div>
                                    </div>
                                    <div class="form-group" align="left">
                                        <label>Cop Perniagaan</label><br>
                                        <?echo '<img border="1" width="200" height="200" src="data:image/jpeg;base64,'.base64_encode( $company['company_stamp'] ).'"/>';?><br>
                                        <?echo $company['company_stamp_filename']?><br>
                                        <div class="input-group input-file" name="company_stamp">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Pilih Logo Baru</button>
                                </span>
                                            <input type="text" class="form-control" placeholder='' />
                                        </div>
                                    </div>
                                    <div class="form-group" align="left">
                                        <label>Logo Perniagaan</label><br>
                                        <?echo '<img border="1" width="200" height="300" src="data:image/jpeg;base64,'.base64_encode( $company['logo'] ).'"/>';?><br>
                                        <?echo $company['logo_filename']?><br>
                                        <div class="input-group input-file" name="logo">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Pilih Logo Baru</button>
                                </span>
                                            <input type="text" class="form-control" placeholder='' />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div align="left">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div><br>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
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

    function bs_input_file() {
        $(".input-file").before(
            function() {
                if ( ! $(this).prev().hasClass('input-ghost') ) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name",$(this).attr("name"));
                    element.change(function(){
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });
                    $(this).find("button.btn-choose").click(function(){
                        element.click();
                    });
                    $(this).find("button.btn-reset").click(function(){
                        element.val(null);
                        $(this).parents(".input-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor","pointer");
                    $(this).find('input').mousedown(function() {
                        $(this).parents('.input-file').prev().click();
                        return false;
                    });
                    return element;
                }
            }
        );
    }
    $(function() {
        bs_input_file();
    });
</script>

</body>

</html>
