

<?php

include ('../controller/auth.php');


require "../model/cuti_function.php";

?>
<?php
$id = $_GET['id'];
$staff_holiday_id = $_GET['staff_holiday_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk teruskan?');
        }

    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


    <!-- <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>-->




    <script>
        function goBack()
        {
            window.history.back()
        }
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



                <h1 class="page-header">Pembahagian Kelulusan Cuti Pekerja</h1>

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

                                    // $id = $_GET['id'];

                                    $row_pemohon= getMaklumatPemohonCuti($staff_holiday_id)->fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/hantar_pelulus_exec.php">
                                        <div class="form-group" align="left">



                                            <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $row_pemohon['staff_record_id'];?>" />
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                                            <input name="staff_holiday_id" type="hidden" class="input-short" value="<? echo $row_pemohon['id'];?>" />



                                            <label>Nama Pekerja</label><br>
                                            <? echo $row_pemohon['nama_pekerja'];?>
                                            <br><br>

                                            <label>Bahagian</label><br>
                                            <? echo $row_pemohon['department_name'];?>
                                            <br><br>
                                            <label>Jenis Cuti Dipohon</label><br>
                                            <? echo $row_pemohon['nama_cuti'];?>
                                            <br><br>
                                            <label>Alamat Semasa Cuti</label><br>
                                            <? echo $row_pemohon['alamat_cuti'];?>
                                            <br><br>

                                            <label>No Telefon</label><br>
                                            <? echo $row_pemohon['telepon'];?>
                                            <br><br>



                                            <label>Tarikh Mula Cuti</label><br>
                                            <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_mula']));?>
                                            <br><br>


                                            <label>Tarikh Akhir Cuti</label><br>
                                            <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_akhir']));?>
                                            <br><br>


                                            <label>Sebab/Alasan</label><br>
                                            <? echo $row_pemohon['sebab'];?>
                                            <br><br>

                                            <table class="table table-striped">

                                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $log_staff['no_staff'];?>" />


                                                <thead>
                                                <tr>
                                                    <th>Nama Pelulus</th>
                                                    <th>Pilih</th>
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
                                                                <label><input name="staffs[]" type="checkbox" <?php echo checkCheckbox($no_staff,$_SESSION['SESS_COM'],$staff['no_staff']);?>
                                                                              value="<?php echo $staff['no_staff']; ?>"></label>
                                                            </div>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                    <?php $i++; } ?>
                                            </table>

                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary" onclick="return Confirm()" >Simpan</button>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
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

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

</body>

</html>
