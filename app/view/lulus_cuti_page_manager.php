

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



                <h1 class="page-header">Permohonan Cuti Pekerja</h1>

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

                                    $id = $_GET['id'];

                                    $row_pemohon= getMaklumatPemohonCuti($staff_holiday_id)->fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/status_cuti_page_manager_exec.php">
                                        <div class="form-group" align="left">
                                            <input name="staff_holiday_id" type="hidden" class="input-short" value="<? echo $row_pemohon['id'];?>" />
                                            <input name="total_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['total_cuti'];?>" />
                                            <input name="baki_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['baki_cuti'];?>" />
                                            <input name="baki_cuti_pohon" type="hidden" class="input-short" value="<? echo $row_pemohon['baki_pohon_rekod'];?>" />
                                            <input name="jumlah_cuti" type="hidden" class="input-short" value="<? echo $row_pemohon['jumlah_cuti'];?>" />
                                            <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $row_pemohon['staff_record_id'];?>" />
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />



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

                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Jumlah Cuti</th>
                                                    <th>Baki Cuti Semasa </th>
                                                    <th>Baki Cuti Selepas Memohon</th>
                                                    <th>Jumlah Hari Cuti Dipohon</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td> <? echo $row_pemohon['total_cuti'];?></td>
                                                    <td><? echo $row_pemohon['baki_cuti'];?></td>
                                                    <td><? echo $row_pemohon['baki_pohon_rekod'];?></td>
                                                    <td><? echo $row_pemohon['jumlah_cuti'];?></td>

                                                </tr>
                                            </table>


                                            <label>Tarikh Mula Cuti</label><br>
                                            <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_mula']));?>
                                            <br><br>


                                            <label>Tarikh Akhir Cuti</label><br>
                                            <? echo date('d/m/Y',strtotime($row_pemohon['tarikh_akhir']));?>
                                            <br><br>


                                            <label>Sebab/Alasan</label><br>
                                            <? echo $row_pemohon['sebab'];?>
                                            <br><br>

                                            <label>Tindakan</label><br>

                                            <select required class="form-control" name="approvement" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $status= statusKelulusanCuti();
                                                while ($pilih  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['code'];?>"><? echo $pilih['jenis_lulus'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                            <br><br>

                                            <label>Diluluskan Oleh</label><br>
                                            <? echo $_SESSION['SESS_NAME'] ?>
                                            <br><br>


                                            <div class="form-group">
                                                <label for="comment">Catatan</label>
                                                <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                            </div>





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
