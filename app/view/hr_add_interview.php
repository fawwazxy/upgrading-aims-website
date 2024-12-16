<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";
require "../model/lookup.php";

?>

<?
$pemohon_id = $_GET['pemohon_id'];
$id = $_GET['id'];
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


    <script language="javascript" type="text/javascript">


    </script>

</head>

<body>

<div id="wrapper">

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

                <h1 class="page-header">Tetapan Jadual Temuduga</h1>


                <? //
                //$flagScreen="tab_1";
                //include ('../global/menu_pemohon.php');
                //	?>

                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>

                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


                                    <?

                                    $log_pemohon = getPemohon($pemohon_id)-> fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/hr_addIV_exec.php?" >
                                        <div class="form-group" align="left">
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />

                                            <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $log_pemohon['id'];?>" />


                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group"  align="left">
                                                <label>Tarikh Temuduga<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="tarikh_iv" required autocomplete="">
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Masa Temuduga<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " type="time" name="masa_iv" value="10:00:00"  required autocomplete="">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Peranan Dipohon<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="role_id" value="<? echo $log_pemohon['peranan'];?>" >
                                            </div>

                                            <div class="form-group" align="left">
                                                <label class="control-label" for="date">Cawangan<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
                                                    <option value="">-- Pilih --</option>
                                                    <?echo getLookupTable("lkp_cawangan","cawangan_kod","nama");?>
                                                </select>
                                            </div>



                                            <table class="table table-striped">

                                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $log_staff['no_staff'];?>" />

                                                <thead>
                                                <tr>
                                                    <th>Nama Penemuduga</th>
                                                    <th>Pilih</th>
                                                    <th>Ketua Penemuduga</th>
                                                </tr>
                                                </thead>

                                                <?

                                                $i=1;
                                                $log_staff = getStaff();
                                                while($staff = $log_staff->fetch_assoc()) {

                                                    ?>

                                                    <tbody>
                                                    <tr>
                                                        <td> <? echo $staff['name'];?></td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label><input name="staffs[]" type="checkbox"
                                                                              value="<?php echo $staff['no_staff']; ?>"></label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="radio">
                                                                <label><input name="ketua" type="radio"
                                                                              value="<?php echo $staff['no_staff']; ?>"></label>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                    <?php $i++; } ?>
                                            </table>



                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning">Tetapkan Jadual</button>
                                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        var tarikh_iv=$('input[name="tarikh_iv"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_iv.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });


    </script>

</body>

</html>
