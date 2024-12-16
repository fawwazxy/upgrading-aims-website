<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

//$no_staff_login = $_GET['SESS_NO_STAFF'];

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
            return confirm('Maklumat Gaji akan dihantar untuk kelulusan.');
        }
    </script>
    <script>
        function calculate(){
            var gaji_pokok = document.getElementById("gaji_pokok").value;
            var elaun = document.getElementById("elaun").value;
            var claim = document.getElementById("claim").value;
            var baki_bayar = document.getElementById("baki_bayar").value;
            var jumlah_gaji_kasar = +gaji_pokok + +elaun + +claim + +baki_bayar;


            document.getElementById("gaji_kasar").value=(jumlah_gaji_kasar);


        }
    </script>

    <script>
        function calculate2(){
            var gaji_kasar= document.getElementById("gaji_kasar").value;
            var kwsp_pekerja= document.getElementById("kwsp_pekerja").value;
            var jumlah_kwsp= (parseFloat(gaji_kasar)*(kwsp_pekerja))/100 ;
            document.getElementById("kwsp").value=(jumlah_kwsp);

        }
    </script>

    <!-- <script>
    function calculate10(){
    var gaji_kasar= document.getElementById("gaji_kasar").value;
    var kwsp_majikan= document.getElementById("kwsp_majikan").value;
    var jumlah_kwsp= (parseFloat(gaji_kasar)*(kwsp_majikan))/100 ;
    document.getElementById("kwspmajikan").value=(jumlah_kwsp);

    }
    </script> -->

    <script>
        function calculate3(){
            var kwsp = document.getElementById("kwsp").value;
            var socso = document.getElementById("socso").value;
            var tolak_gaji = document.getElementById("tolak_gaji").value;
            var jumlah_jumlah_potongan = +kwsp + +socso + +tolak_gaji;


            document.getElementById("jumlah_potongan").value=(jumlah_jumlah_potongan);
        }
    </script>

    <script>
        function calculate4(){
            var gaji_kasar = document.getElementById("gaji_kasar").value;
            var jumlah_potongan = document.getElementById("jumlah_potongan").value;
            var jumlah_gaji_bersih = +gaji_kasar - +jumlah_potongan ;


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

    <?        $list_staff =getStaffInfo($no_staff) -> fetch_assoc();
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Gaji</h1>
                <h4><b><font color="blue"><?echo $list_staff['name'];?></font></b></h4>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" align="left" type="button" value="Kembali" onclick="goBack()">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Maklumat
                </button>
            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai gaji
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">


                            <div class="modal-content">
                                <div class="modal-header">


                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Gaji</h4>

                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/salary_add_exec.php">





                                        <input name="no_staff" type="hidden" class="input-short" value="<?echo $no_staff;?>" />
                                        <!--input name="no_staff_login" type="hidden" class="input-short" value="<//s?echo $no_staff;?>" /-->

                                        <div
                                        <label align="left" ><font color="red">** Maklumat Wajib Diisi.</font></label>
                                </div>
                                <?
                                //$list_staff =getSal($no_staff) -> fetch_assoc();

                                $gajiPokok = getStaffGajiPokok($no_staff);

                                $tolakGaji = getStaffTolakGaji($no_staff)->fetch_assoc();

                                $elaunSalary=
                                    checkElaun ($no_staff, $list_staff['department_id']);

                                $claimSalary=
                                    checkClaim ($no_staff,$approve_status,$tahun,$bulan)->fetch_assoc();

                                $belumbayarbaki=getBelumBayar($no_staff,$bulan,$tahun)->fetch_assoc();

                                ?>
                                <input class="form-control" type="hidden" name="gaji_bulan" id="gaji_bulan" value="<? echo $bulan ?>" required autocomplete="off">


                                <input class="form-control" type="hidden" name="gaji_tahun" id="gaji_tahun" value="<? echo $tahun ?>" required autocomplete="off">



                                <div class="form-group" align="left">
                                    <label>Gaji Pokok<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" name="gaji_pokok" id="gaji_pokok" value="<? echo $gajiPokok ?>" required autocomplete="off">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Gaji Belum Bayar<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" name="baki_bayar" id="baki_bayar" value="<?
                                    if(isset($belumbayarbaki['baki_bayar']))
                                        echo $belumbayarbaki['baki_bayar'];
                                    else
                                        echo 0 ?>" required autocomplete="off">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Elaun<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="elaun" id="elaun" value="<? echo $elaunSalary ?>" required autocomplete="off" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tuntutan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" id="claim" name="claim" required autocomplete="off" value="<?
                                    if(isset($claimSalary['total']))
                                        echo $claimSalary['total'];
                                    else
                                        echo 0 ?>" onmouseover="calculate()" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Gaji Kasar<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="gaji_kasar" id="gaji_kasar"  required autocomplete="off" >
                                </div>


                                <div class="form-group" align="left">
                                    <label>KWSP<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="kwsp" id="kwsp" required autocomplete="off" value="<? echo getKWSPpekerja($gajiPokok) ?>">
                                </div>

                                <div class="form-group" align="left">
                                    <label>KWSP Majikan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="kwsp_majikan" id="kwsp_majikan" required autocomplete="off" value="<? echo getKWSPMajikan($gajiPokok) ?>">
                                </div>

                                <div class="form-group" align="left">
                                    <label>SOCSO<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" id="socso" name="socso"  required autocomplete="off" value="<?echo getSocsoPekerja($gajiPokok);?>" onmouseover="calculate3()">
                                </div>

                                <div class="form-group" align="left">
                                    <label>SOCSO Majikan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" id="socso_majikan" name="socso_majikan"  required autocomplete="off" value="<?echo getEmployerSocso($gajiPokok);?>" >
                                </div>



                                <div class="form-group" align="left">
                                    <label>Penolakan Gaji Tambahan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="tolak_gaji" id="tolak_gaji"     value="<?
                                    if(isset($tolakGaji['total']))
                                        echo $tolakGaji['total'];
                                    else
                                        echo 0 ?>"

                                           required autocomplete="off" onmouseover="calculate3()">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Jumlah Potongan<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" id="jumlah_potongan" name="jumlah_potongan"  required autocomplete="off"  onmouseover="calculate4()">
                                </div>




                                <div class="form-group" align="left">
                                    <label>Gaji Bersih<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control"  name="gaji_bersih" id="gaji_bersih" required autocomplete="off">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Gaji Dibayar<font color="red">**</font>&nbsp;</label>

                                    <button onclick="copyToClipboard()">Salin Gaji Bersih</button>&nbsp;

                                    <input class="form-control"  name="gaji_dibayar" id="gaji_dibayar" required autocomplete="off" onmouseover="calculate5()">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Belum Bayar<font color="red">**</font>&nbsp;</label>

                                    <input class="form-control"  name="belum_bayar" id="belum_bayar" value="" required autocomplete="off">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Tarikh Bayar<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="date" name="tarikh_bayar" value="" required autocomplete="off">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>



                                </form>
                            </div><!--modal-body-->

                        </div>
                        <!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->




                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>


                            <th>#</th>
                            <th>Staff Number</th>
                            <!--<th>Tarikh Bayar</th>-->
                            <th>No Slip</th>
                            <!--<th>Kwsp</th>
                            <th>Socso</th>
                            <th>Elaun</th>
                            <th>Gaji Kasar</th>
                            <th>Tolak Gaji</th>
                            <th>Gaji Bersih</th>
                            <th>Total Gaji</th>-->
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
                                <!--<td><//?php echo $row_data_salary['tarikh_bayar']; ?></td>-->
                                <td><?php echo $row_data_salary['no_slip']; ?></td>
                                <!--<td><?php echo $row_data_salary['kwsp']; ?></td>
										<td><?php echo $row_data_salary['socso']; ?></td>
										<td><?php echo $row_data_salary['elaun']; ?></td>
										<td><?php echo $row_data_salary['gaji_kasar']; ?></td>
										<td><?php echo $row_data_salary['tolak_gaji']; ?></td>
										<td><?php echo $row_data_salary['gaji_bersih']; ?></td>
										<td><?php echo $row_data_salary['gaji_pokok']; ?></td>-->
                                <td><?php echo $row_data_salary['gaji_dibayar']; ?></td>
                                <td><?php echo $row_data_salary['belum_bayar']; ?></td>
                                <td><? echo date('d/m/Y',strtotime($row_data_salary['tarikh_bayar']));?></td>

                                <td><font color=red><strong><?php echo $row_data_salary['salary_status'];?></strong></td>

                                <td>
                                    <?
                                    if ($row_data_salary['jenis_kelulusan'] == 'BLMHNTR') { ?>



                                        <a href="salary_update.php?salary_id=<? echo $row_data_salary['id'];?>&no_staff=<? echo $row_data_salary['no_staff'];?>&bulan=<? echo $row_data_salary['gaji_bulan'];?>&tahun=<? echo $row_data_salary['gaji_tahun'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>

                                        <a href="../controller/hantar_exec.php?staff_salary_id=<? echo $row_data_salary['id'];?>&no_staff=<? echo $row_data_salary['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&bulan=<? echo $bulan;?>&tahun=<? echo $tahun ?>"><button class="btn btn-warning" type="button" onclick="return Confirm()" >Hantar</button></a>





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
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- /.row -->
    <!-- /.container-fluid -->
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
