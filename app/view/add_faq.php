<?php
include ('../controller/auth.php');
require "../model/support_function.php";

$no_staff=$_GET['no_staff'];
$no_staff_login=$_GET['SESS_NO_STAFF'];
$id=$_GET['id'];
$id_support=$_GET['id_support'];
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
    <!-- include summernote css/js -->
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Sokongan</h1>
            </div>
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form method="post" enctype="multipart/form-data" action="../controller/add_faq_exec.php?id=<?php echo $row['id']; ?>" >
                                    <!--<input name="no_staff" type="text" class="input-short" value="<? echo $_GET['no_staff']; ?>" />-->
                                    <? $row=  getSupportUpdateDeveloper($id)->fetch_assoc(); ?>
                                    <label><span style="color: red; ">Maklumat Wajib Diisi.</span></label><br>
                                    <div class="form-group">
                                        <label for="faq_produk">Sistem</label><br>
                                        <select class="form-control"  name="faq_produk" id="faq_produk" value=" ">
                                            <option value="">-- Pilih --</option>
                                            <? $produk=  getProduk();
                                            while ($pilih  = $produk -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['code'];?>"> <? echo $pilih['code']?>-<? echo $pilih['produk']?> </option>
                                                <?} ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="faq_title">Tajuk<span style="color: red; "></span>&nbsp;</label>
                                        <input type="text" class="form-control" name="faq_title" id="faq_title"><? echo $row['faq_title']; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="summernote">Catatan<span style="color: red; "></span>&nbsp;</label>
                                        <textarea id="summernote" name="faq_answer" rows="5" ><? echo $row['faq_answer']; ?></textarea>
                                    </div>
                                    <!--  <div class="form-group" align="left">
                                     <label>Gambar</label>
                                              <input class="form-control"  type="file"  name="document" id="document"  ><br>
                                     </div> -->
                                    <br><br><br>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
</body>
</html>
