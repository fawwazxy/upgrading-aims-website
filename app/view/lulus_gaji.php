

<?php

include ('../controller/auth.php');


require "../model/staff_function.php";

?>
<?php
$id = $_GET['id'];
$staff_salary_id = $_GET['staff_salary_id'];

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



                <h1 class="page-header">Permohonan Kelulusan Gaji Pekerja</h1>

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

                                    $row_salary= getSalaryAppInfo($staff_salary_id)->fetch_assoc();

                                    ?>

                                    <form method="post" action="../controller/status_gaji_exec.php">
                                        <div class="form-group" align="left">
                                            <input name="staff_salary_id" type="hidden" class="input-short" value="<? echo $row_salary['id'];?>" />
                                            <input name="jenis_kelulusan" type="hidden" class="input-short" value="<? echo $row_salary['jenis_kelulusan'];?>" />
                                            <input name="approve_by" type="hidden" class="input-short" value="<? echo $row_salary['approve_by'];?>" />
                                            <input name="catatan" type="hidden" class="input-short" value="<? echo $row_salary['catatan'];?>" />
                                            <!--input name="gaji_dibayar" type="hidden" class="input-short" value="<//? echo $row_salary['tolak_gaji'];?>" /-->




                                            <label>Nama Pekerja</label><br>
                                            <? echo $row_salary['nama_pekerja'];?>
                                            <br><br>

                                            <label>Jawatan</label><br>
                                            <? echo $row_salary['nama_jawatan'];?>
                                            <br><br>

                                            <label>Bahagian</label><br>
                                            <? echo $row_salary['description'];?>
                                            <br><br>

                                            <label>nombor slip</label><br>
                                            <? echo $row_salary['no_slip'];?>
                                            <br><br>


                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Gaji Pokok</th>
                                                    <th>Elaun</th>
                                                    <th>Tuntutan</th>
                                                    <th>Gaji Kasar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td> <? echo $row_salary['gaji_pokok'];?></td>
                                                    <td><? echo $row_salary['elaun'];?></td>
                                                    <td><? echo $row_salary['claim'];?></td>
                                                    <td> <? echo $row_salary['gaji_kasar'];?></td>

                                                </tr>
                                            </table>



                                            <table class="table table-striped">
                                                <thead>
                                                <tr>

                                                    <th>KWSP</th>
                                                    <th>Socso</th>
                                                    <th>Penolakan Gaji Tambahan</th>
                                                    <th>Jumlah Potongan</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>

                                                    <td><? echo $row_salary['kwsp'];?></td>
                                                    <td><? echo $row_salary['socso'];?></td>
                                                    <td><? echo $row_salary['tolak_gaji'];?></td>
                                                    <td><? echo $row_salary['jumlah_potongan'];?></td>

                                                </tr>
                                            </table>

                                            <table class="table table-striped">
                                                <thead>
                                                <tr>

                                                    <th>KWSP Majikan</th>
                                                    <th>Socso Majikan</th>
                                                    <th></th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>

                                                    <td><? echo $row_salary['kwsp_majikan'];?></td>
                                                    <td><? echo $row_salary['socso_majikan'];?></td>
                                                    <td></td>

                                                </tr>
                                            </table>


                                            <table class="table table-striped">
                                                <thead>
                                                <tr>

                                                    <th>Gaji Bersih</th>
                                                    <th>Gaji Dibayar</th>
                                                    <th> Gaji Belum Bayar</th>


                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>

                                                    <td><? echo $row_salary['gaji_bersih'];?></td>
                                                    <td><? echo $row_salary['gaji_dibayar'];?></td>
                                                    <td><? echo $row_salary['belum_bayar'];?></td>

                                                </tr>
                                            </table>
                                            <br>


                                            <label>Tarikh Bayar</label><br>
                                            <? echo date('d/m/Y',strtotime($row_salary['tarikh_bayar']));?>
                                            <br><br>



                                            <label>Tindakan</label><br>

                                            <select required class="form-control" name="jenis_kelulusan" value="jenis_kelulusan">
                                                <option value="">-- Pilih --</option>

                                                <? $status= statusKelulusanGaji();
                                                while ($pilih  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['code'];?>"><? echo $pilih['desc'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                            <br><br>




                                            <div class="form-group">
                                                <label for="comment">Approve By</label>
                                                <br>
                                                <?echo($_SESSION['SESS_NAME']);?>
                                                <input type="hidden" value="<?echo($_SESSION['SESS_NO_STAFF']);?>" name="approve_by" id="approve_by"></input>
                                            </div>

                                            <div class="form-group">
                                                <label for="comment">Catatan</label>
                                                <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                            </div>

                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary">Simpan</button>
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
