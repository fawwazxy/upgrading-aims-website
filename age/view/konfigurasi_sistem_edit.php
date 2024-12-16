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
                <h1 class="page-header">Maklumat Konfigurasi Sistem</h1>
            </div>
         </div>  
         
            <div class="panel-heading" align="right">
               <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->
        
        </div>

                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maklumat Konfigurasi Sistem
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
            <form method="post" action="../controller/keselamatan_exec.php"
            enctype="multipart/form-data">   
            <input type="hidden" name="action" value="konfigurasi_sistem_edit" />    
                         <div class="form-group" align="left">
                                <div class="form-group" align="left">
                                 <label>Nama Sistem</label><br>
                                  <input class="form-control" placeholder="" id="sys_name" name="sys_name" value="<?echo $sys['sys_name']?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                  <label>Tagline</label><br>
                                   <input class="form-control" placeholder=" " id="sys_tagline" name="sys_tagline" value="<?echo $sys['sys_tagline']?>" />
                                </div>

                                <div class="form-group" align="left">
                                  <label>Nama Kedai</label><br>
                                  <input class="form-control" placeholder=" " id="sys_owner" name="sys_owner" value="<?echo $sys['sys_owner']?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                 <label>Domain</label><br>
                                  <input class="form-control" placeholder=" " id="sys_domain" name="sys_domain" value="<?echo $sys['sys_domain']?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                  <label>Email</label><br>
                                  <input class="form-control" placeholder=" " id="sys_email" name="sys_email" value="<?echo $sys['sys_email']?>" />
                                </div>

                                <div class="form-group" align="left">
                                  <label>Hotline</label><br>
                                  <input class="form-control" placeholder="Contoh : +609-7406589" 
                                  id="sys_hotline" name="sys_hotline" 
                                  value="<?echo $sys['sys_hotline']?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                      <label>Alamat</label><br>
                                    <textarea rows="4" cols="50"class="form-control" placeholder=" " 
                                    id="sys_address" name="sys_address"><?echo $sys['sys_address']?></textarea>
                                </div>
                                
                                <div class="form-group" align="left">
                                      <label>Facebook</label><br>
                                    <input class="form-control" placeholder=" " id="sys_fb" name="sys_fb" value="<?echo $sys['sys_fb']?>" />
                                </div>
                                
                                <div class="form-group" align="left">
                                      <label>Version</label><br>
                                    <input class="form-control" placeholder=" " id="version" name="version" value="<?echo $sys['version']?>" />
                                </div>
                                <div class="form-group" align="left">
                                  <label>Logo</label><br>
                                <?echo '<img width="200" height="200" src="data:image/jpeg;base64,'.base64_encode( $sys['logo'] ).'"/><br>';?><?echo $sys['logo_filename']?><br><br>
                                <div class="input-group input-file" name="logo">
                                <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Pilih Logo Baru</button>
                                </span>
                                <input type="text" class="form-control" placeholder='' />
                                </div>
                                </div>
                                <!--div class="form-group" align="left">
                                      <label>No. SSM</label><br>
                                    <input class="form-control" placeholder=" " id="sys_ssm" name="sys_ssm" value="<?//echo $sys['sys_ssm']?>" />
                                </div>
                                <div class="form-group" align="left">
                                      <label>Whatsapp</label><br>
                                    <input class="form-control" placeholder="Contoh : +6011-53549769" id="sys_whatsapp" name="sys_whatsapp" value="<?//echo $sys['sys_whatsapp']?>" />
                                </div-->

                             <div class="modal-footer">
                                    <div align="left">
                          <button type="submit" class="btn btn-primary">Simpan</button>
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
        </div>

        <!-- /#page-wrapper -->

    </div>

    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>

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
