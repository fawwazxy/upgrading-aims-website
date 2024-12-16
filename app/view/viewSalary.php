

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






                                    <label>Nama Pekerja</label><br>
                                    <? echo $row_salary['nama_pekerja'];?>
                                    <br><br>

                                    <label>Jawatan</label><br>
                                    <? echo $row_salary['nama_jawatan'];?>
                                    <br><br>

                                    <label>Bahagian</label><br>
                                    <? echo $row_salary['desc'];?>
                                    <br><br>

                                    <label>nombor slip</label><br>
                                    <? echo $row_salary['no_slip'];?>
                                    <br><br>


                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Gaji Pokok</th>
                                            <th>Elaun</th>
                                            <th>Claim</th>
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

                                            <th>Kwsp</th>
                                            <th>Claim</th>
                                            <th>Tolak Gaji</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>

                                            <td><? echo $row_salary['kwsp'];?></td>
                                            <td><? echo $row_salary['socso'];?></td>
                                            <td><? echo $row_salary['tolak_gaji'];?></td>

                                        </tr>
                                    </table>



                                    <table class="table table-striped">
                                        <thead>
                                        <tr>

                                            <th>Gaji Bersih</th>
                                            <th>Gaji Dibayar</th>
                                            <th>Belum Bayar</th>


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
