<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

$no_staff_login = $_GET['SESS_NO_STAFF'];

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();
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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Maklumat Gaji akan dihantar kepada CEO');
        }
    </script>
    <script>
        function calculate(){
            var gaji_pokok = document.getElementById("gaji_pokok").value;
            var elaun = document.getElementById("elaun").value;
            var claim = document.getElementById("claim").value;
            var jumlah_gaji_kasar = +gaji_pokok + +elaun + +claim;


            document.getElementById("gaji_kasar").value=(jumlah_gaji_kasar);


        }
    </script>

    <script>
        function calculate2(){
            var gaji_kasar= document.getElementById("gaji_kasar").value;
            var jumlah_kwsp= (parseFloat(gaji_kasar)*11)/100 ;
            document.getElementById("kwsp").value=(jumlah_kwsp);

        }
    </script>

    <script>
        function calculate3(){
            var kwsp = document.getElementById("kwsp").value;
            var socso = document.getElementById("socso").value;
            var jumlah_tolak_gaji = +kwsp + +socso ;


            document.getElementById("tolak_gaji").value=(jumlah_tolak_gaji);
        }
    </script>

    <script>
        function calculate4(){
            var gaji_kasar = document.getElementById("gaji_kasar").value;
            var tolak_gaji = document.getElementById("tolak_gaji").value;
            var jumlah_gaji_bersih = +gaji_kasar - +tolak_gaji ;


            document.getElementById("gaji_bersih").value=(jumlah_gaji_bersih);
        }
    </script>

    <script>
        function calculate5(){
            var gaji_bersih = document.getElementById("gaji_bersih").value;
            var gaji_dibayar = document.getElementById("gaji_dibayar").value;
            var jumlah_gaji_belum_bayar = +gaji_bersih - +gaji_dibayar ;


            document.getElementById("belum_bayar").value=(jumlah_gaji_belum_bayar);
        }
    </script>

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
                <h1 class="page-header">Maklumat Gaji</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" align="left" type="button" value="Kembali" onclick="goBack()">

            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai gaji
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>


                                <th>#</th>
                                <th>Staff Number</th>
                                <th>No Slip</th>
                                <th>Gaji Dibayar</th>
                                <th>Belum Bayar</th>
                                <th>Tarikh Bayar</th>
                                <th>Status</th>
                                <th>Tindakan</th>


                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_salary = getSalaryStaff($no_staff,$tahun,$bulan);
                            while($row_data_salary = $data_salary->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data_salary['no_staff']; ?></td>
                                    <td><?php echo $row_data_salary['no_slip']; ?></td>
                                    <td><?php echo $row_data_salary['gaji_dibayar']; ?></td>
                                    <td><?php echo $row_data_salary['belum_bayar']; ?></td>
                                    <td><? echo date('d/m/Y',strtotime($row_data_salary['tarikh_bayar']));?></td>

                                    <td><font color=red><strong><?php echo $row_data_salary['salary_status'];?></strong></td>

                                    <td>
                                        <?
                                        if ($row_data_salary['jenis_kelulusan'] == 'BLMHNTR') { ?>



                                            <a href="salary_update.php?salary_id=<? echo $row_data_salary['id'];?>&no_staff=<? echo $row_data_salary['no_staff'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>

                                            <a href="../controller/hantar_exec.php?staff_salary_id=<? echo $row_data_salary['id'];?>&no_staff=<? echo $row_data_salary['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>"><button class="btn btn-warning" type="button" onclick="return Confirm()" >Hantar</button></a>





                                            <?
                                        }    //TAMBAHAN

                                        if ($row_data_salary['jenis_kelulusan'] == 'LULUS') { ?>

                                            <a href="payslip.php?salary_id=<? echo $row_data_salary['id'];?>&no_staff=<? echo $row_data_salary['no_staff'];?>"><button class="btn btn-info" type="button" >Slip Gaji</button></a>




                                            <?
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php $i++; } ?>


                            </tbody>

                        </table>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
            <!-- /.col-lg-12 -->
        </div>


        <!-- /.row -->
        <!-- /.container-fluid -->
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

    function copyToClipboard() {
        var gaji_bersih=document.getElementById("gaji_bersih").value;
        document.getElementById("gaji_dibayar").value=gaji_bersih;
    }


</script>

</script>

</body>

</html>
