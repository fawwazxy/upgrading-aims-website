<?php

include ('../controller/auth.php');

require "../model/support_function.php";

$no_staff=$_GET['no_staff'];

$no_staff_login=$_SESSION['SESS_NO_STAFF'];
$id=$_GET['id'];
$id_support_developer=$_GET['id_support_developer'];
$row=  getSupportUpdateDeveloper($id)->fetch_assoc();



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
                <h1 class="page-header">Kemaskini Tahap Keutamaan</h1>
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

                                <form method="post" enctype="multipart/form-data" action="../controller/support_exec.php?action=dev_update_rate" >
                                    <input name="id_support_developer" type="hidden" class="input-short" value="<? echo $id_support_developer; ?>" />
                                    <input name="status_tindakan" type="" class="input-short" value="<? echo $row['status_tindakan']; ?>" />


                                    <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>

                                    <label>Nama Projek/Sistem</label><br>
                                    <? echo $row['nama_projek'];?>
                                    <br><br>

                                    <label>Aduan</label><br>

                                    <? echo $row['aduan'];?>

                                    <br><br>

                                    <label>Nama Penghantar</label><br>
                                    <? echo $row['nama_client'];?>
                                    <br><br>

                                    <label>Nombor Telefon</label><br>
                                    <? echo $row['notel'];?>
                                    <br><br>

                                    <label>Catatan</label><br>
                                    <? echo $row['remarks'];?>
                                    <br><br>


                                    <div class="form-group">
                                        <label>Tahap Keutamaan<font color="red">**</font>&nbsp;</label><br>
                                        <?
                                        for ($i = 1; $i <= 5; $i++) {
                                            $ratingClass = "btn-default btn-grey";
                                            if($i <= $row['level_developer']) {
                                                $ratingClass = "btn-warning";
                                            }
                                            ?>
                                            <button type="button" class="btn btn-sm <?php echo $ratingClass; ?> rateButton" aria-label="Left Align"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></button>

                                        <?}?>
                                        <input type="hidden" class="form-control" id="level_developer" name="level_developer" value="<?echo $row['level_developer']?>">

                                    </div>



                                    <br>

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
        $( ".rateButton" ).click(function() {
            if($(this).toggleClass('btn-grey')) {
                $(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            } else {
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            }
            $("#level_developer").val($('.star-selected').length);
        });
    });
</script>
</body>

</html>
