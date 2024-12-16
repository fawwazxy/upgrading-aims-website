<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff=$_GET['no_staff'];

$no_staff_login=$_GET['SESS_NO_STAFF'];
$faq_id=$_GET['id'];

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
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>


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






                                <form method="post" enctype="multipart/form-data" action="../controller/update_faq_exec.php?id=<?php echo $row['faq_id']; ?>" >



                                    <input name="faq_id" type="hidden" class="input-short" value="<? echo $faq_id; ?>" />



                                    <?


                                    $row=  getFAQid($faq_id)->fetch_assoc();

                                    ?>


                                    <label><font color="red">Maklumat Wajib Diisi.</font></label><br>


                                    <div class="form-group" align="left" >

                                        <label>Sistem</label><br>
                                        <select class="form-control"  name="faq_produk" id="faq_produk" value="<? echo $row['faq_produk']; ?> ">

                                            <option value="">-- Pilih --</option>
                                            <? $produk=  getProduk();
                                            while ($pilih  = $produk -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['code'];?>"  <? echo ($pilih['code']==$row['faq_produk']?'selected':'');?>>   <? echo $pilih['produk']?></option>






                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Tajuk<font color="red"></font>&nbsp;</label>
                                        <input type="text" class="form-control" name="faq_title" rows="5" value="<? echo $row['faq_title']; ?>">
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Catatan<font color="red"></font>&nbsp;</label>
                                        <textarea id="summernote" rows="5" name="faq_answer"  required autocomplete=""><? echo $row['faq_answer']; ?></textarea>

                                    </div>

                                    <br><br>





                                    <br><br>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>



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

<script>


    $(document).ready(function() {
        $('#summernote').summernote();
    });


</script>

</body>

</html>
