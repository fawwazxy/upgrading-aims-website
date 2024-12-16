<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

$no_staff_login = $_GET['SESS_NO_STAFF'];
$id = $_GET['id'];
$id_progress = $_GET['id_progress'];



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



                                <form method="post" enctype="multipart/form-data" action="../controller/progress_edit_exec.php?id=<?php echo $id; ?>&no_staff=<?php echo $no_staff; ?>" >


                                    <input name="id_progress" type="text" class="input-short" value="<? echo $_GET['id_progress']; ?>" />

                                    <?


                                    $row=  ViewProgressUpdate($id_progress,$id)->fetch_assoc();

                                    ?>


                                    <label><font color="red">Maklumat Wajib Diisi.</font></label><br>

                                    <label>Nama Projek/Sistem</label><br>
                                    <input class="form-control"  name="tarikh" id="tarikh" required autocomplete="off" value="<? echo $row['tarikh'];?>">
                                    <br><br>

                                    <label>Progress</label><br>
                                    <input class="form-control"  name="catatan" id="catatan" required autocomplete="off" value="<? echo $row['catatan'];?>">






                                    <br><br>







                                    <br>


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
    });
</script>

</body>

</html>
