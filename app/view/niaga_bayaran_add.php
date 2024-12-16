<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>

<?
$id_inbois = $_GET['id_inbois'];
$id_bayaran = $_GET['id_bayaran'];

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
                <h1 class="page-header">Resit Bayaran</h1>
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

                                <?


                                $row_inbois=  getInboiDetails($id_inbois)->fetch_assoc();

                                ?>

                                <form method="post" action="../controller/niaga_bayaran_exec.php?id_inbois=<? echo $id_inbois;?>" >


                                    <input name="id_inbois" type="hidden" class="input-short" value="<? echo $_GET['id_inbois']; ?>" />

                                    <input name="shortcode" type="hidden" class="input-short" value="<? echo $shortcode; ?>" />


                                    <label><font color="red">Maklumat Wajib Diisi.</font></label><br>

                                    <label>Perkara</label><br>
                                    <? echo $row_inbois['tajuk_sebut_harga'];?>
                                    <br><br>

                                    <label>Pelanggan</label><br>
                                    <? echo $row_inbois['agensi_rujukan'];?>
                                    <br><br>

                                    <label>Jumlah Bayaran Keseluruhan (RM)</label><br>
                                    RM<?

                                    if($row_inbois['jumlah_bayaran']>0){
                                        $baki=$row_inbois['jumlah_sebut_harga']-$row_inbois['jumlah_bayaran'];
                                        echo number_format($baki,2);
                                    }
                                    else{

                                        echo number_format($row_inbois['jumlah_sebut_harga'],2);

                                    }
                                    ?>
                                    <br><br>

                                    <div class="form-group" align="left">
                                        <label>Jumlah Bayaran Dibuat (RM)<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control" name="jumlah_bayaran" id="jumlah_bayaran" required autocomplete="" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Tarikh Bayaran<font color="red">**</font>&nbsp;</label>
                                        <input type="date" class="form-control" name="tarikh_bayaran"  id="tarikh_bayaran" required autocomplete=""/><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Kaedah Bayaran<font color="red">**</font>&nbsp;</label><br>
                                        <table>

                                            <tr>
                                                <td colspan="3"><input type="radio" name="kaedah_bayaran" id="kaedah_bayaran" value="TUNAI"> Tunai</td>

                                                <td colspan="2">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td colspan="3"><input type="radio" name="kaedah_bayaran" id="kaedah_bayaran" value="PEMINDAHAN"> Pemindahan Atas Talian</td>

                                                <td colspan="2">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td><input type="radio" name="kaedah_bayaran" id="kaedah_bayaran" value="CEK"> Cek</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>No.Cek&nbsp;<input type="text" name="no_cek_bayaran" id="no_cek_bayaran" /> </td>
                                                <td>&nbsp;</td>
                                                <td>Nama Bank&nbsp;<input type="text" name="nama_bank_bayaran" id="nama_bank_bayaran" /> </td>
                                            </tr>



                                        </table>
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
    });
</script>

</body>

</html>
