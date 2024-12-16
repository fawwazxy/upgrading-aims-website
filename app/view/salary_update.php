<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>

<?
$salary_id = $_GET['salary_id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
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
                <h1 class="page-header">Kemaskini Maklumat</h1>
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
                                $log_salary = getSalaryInfo($salary_id)-> fetch_assoc();


                                ?>


                                <form method="post" action="../controller/salary_update_exec.php">





                                    <div

                                    <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                            </div>


                            <input name="salary_id" type="hidden" class="input-short" value="<? echo $salary_id;?>" />
                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                            <input name="gaji_bulan" type="hidden" class="input-short" value="<? echo $log_salary['gaji_bulan']; ?>" />
                            <input name="gaji_tahun" type="hidden" class="input-short" value="<? echo $log_salary['gaji_tahun']; ?>" />

                            <div class="form-group" align="left">
                                <label>Gaji Pokok<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="gaji_pokok" value="<? echo $log_salary['gaji_pokok']; ?>" >


                            </div>


                            <div class="form-group" align="left">
                                <label>Elaun<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="elaun" value="<? echo $log_salary['elaun']; ?>" >


                            </div>

                            <div class="form-group" align="left">
                                <label>Claim<font color="red">**</font>&nbsp;</label>
                                <input class="form-control" type="text" name="claim" value="<? echo $log_salary['claim']; ?>" >


                            </div>


                            <div class="form-group" align="left">
                                <label>Gaji Kasar<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="gaji_kasar" value="<? echo $log_salary['gaji_kasar']; ?>" >

                            </div>

                            <div class="form-group" align="left">
                                <label>KWSP<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="kwsp" value="<? echo $log_salary['kwsp']; ?>" >


                            </div>

                            <div class="form-group" align="left">
                                <label>KWSP Majikan<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="kwsp_majikan" value="<? echo $log_salary['kwsp_majikan']; ?>" >


                            </div>

                            <div class="form-group" align="left">
                                <label>SOCSO<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="socso" value="<? echo $log_salary['socso']; ?>" >


                            </div>

                            <div class="form-group" align="left">
                                <label>SOCSO Majikan<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="socso_majikan" value="<? echo $log_salary['socso_majikan']; ?>" >


                            </div>




                            <div class="form-group" align="left">
                                <label>Penolakan Gaji Tambahan<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="tolak_gaji" value="<? echo $log_salary['tolak_gaji']; ?>" >

                            </div>


                            <div class="form-group" align="left">
                                <label>Gaji Bersih<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="gaji_bersih" value="<? echo $log_salary['gaji_bersih']; ?>" >

                            </div>




                            <div class="form-group" align="left">
                                <label>Gaji Dibayar<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="gaji_dibayar" value="<? echo $log_salary['gaji_dibayar']; ?>" >


                            </div>

                            <div class="form-group" align="left">
                                <label>Belum Bayar<font color="red">**</font>&nbsp;</label>
                                <input class="form-control"  name="belum_bayar" value="<? echo $log_salary['belum_bayar']; ?>" >


                            </div>



                            <div class="form-group" align="left">
                                <label>Tarikh Bayar<font color="red">**</font>&nbsp;</label>
                                <input class="form-control" type="date" name="tarikh_bayar" required value="<? echo $log_salary['tarikh_bayar']; ?>" >


                            </div>




                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>



                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
    </div>



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
</script>

</body>

</html>
