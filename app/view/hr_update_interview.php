<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

require "../model/lookup.php";

?>

<?
$pemohon_id = $_GET['pemohon_id'];
$no_staff = $_GET['no_staff'];
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

                <h1 class="page-header">Kemaskini Jadual Temuduga</h1>


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


                                    $log_pemohon = getUpdateLogKelulusan($pemohon_id)-> fetch_assoc();


                                    ?>


                                    <form method="post" action="../controller/hr_updateIV_exec.php?&pemohon_id=<? echo $pemohon_id;?>" >
                                        <div class="form-group" align="left">

                                            <input name="pmhn_kllusn_id" type="hidden" class="input-short" value="<? echo $log_pemohon['id'];?>" />

                                            <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $log_pemohon['pemohon_id'];?>" />
                                            <input name="id" type="hidden" class="input-short" value="<? echo $id; ?>" />

                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group"  align="left">
                                                <label>Tarikh Temuduga<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="tarikh_iv" value="<? echo date('d/m/Y',strtotime($log_pemohon['tarikh_iv']));?>" >
                                            </div>

                                            <div class="form-group"  align="left">
                                                <label>Masa Temuduga<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " type="time" name="masa_iv" value="<? echo $log_pemohon['masa_iv']; ?>"  required autocomplete="">
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Peranan Dipohon<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" placeholder=" " name="role_id" value="<? echo $log_pemohon['role_id'];?>" readonly />
                                            </div>

                                            <div class="form-group" align="left">
                                                <label class="control-label" for="date">Cawangan<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
                                                    <option value="">-- Pilih --</option>
                                                    <?echo getDropDown("lkp_cawangan","cawangan_kod","nama",$log_pemohon['cawangan_kod']);?>
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
                                                $log_staff = getStaff($no_staff);
                                                while($staff = $log_staff->fetch_assoc()) {

                                                    ?>

                                                    <tbody>
                                                    <tr>
                                                        <td> <? echo $staff['name'];?></td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label><input name="staffs[]" type="checkbox" <?php echo checkCheckbox($staff['no_staff'],$log_pemohon['id']);?>
                                                                              value="<?php echo $staff['no_staff']; ?>"></label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="radio">
                                                                <label><input name="ketua" type="radio" <?php echo checkRadio($staff['no_staff'],$log_pemohon['id']);?>
                                                                              value="<?php echo $staff['no_staff']; ?>"></label>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                    <?php $i++; } ?>
                                            </table>



                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
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


        function stringToDate(_date,_format,_delimiter)
        {
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
            return formatedDate;
        }

    </script>


</body>

</html>
