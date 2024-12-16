<?php

include ('../controller/auth.php');
// require "../global/menu_bulan1.php";
require "../model/perbelanjaan_functions.php";
//require "../model/menuleft_function.php";
?>
<?
$id=$_GET['id'];
$no_staff=$_GET['no_staff'];
$bulan=$_GET['bulan'];
$tahun=$_GET['tahun'];


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
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
            function popitup(url) {
                /*newwindow=window.open(url,'name','height=842,width=595');*/
                newwindow=window.open(url,'name','height=595,width=842');
                if (window.focus) {newwindow.focus()}
                return false;
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
        <?
        $flagScreen="tab_1";
        include ('../global/menu_perbelanjaan.php');
        ?>


        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Perbelanjaan Syarikat</h1>
            </div>
        </div>
        <?
        $flagScreen1=['flag'];
        include ('../global/menu_tahun.php');
        ?>
        <br>


        <div class="row">
            <div class="panel-heading" align="right">

                <!--  <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                         Tambah Perbelanjaan
                 </button> -->
            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Perbelanjaan Syarikat
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Perbelanjaan</h4>
                                </div>

                                <div class="modal-body">


                                    <form method="post" action="../controller/perbelanjaan_add_exec.php?bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&id=<?  echo $id;?>" enctype="multipart/form-data">

                                        <div>
                                            <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        </div>

                                        <input type="hidden" class="form-control" placeholder=" " id="shortcode" name="shortcode" value="<? echo $shortcode; ?>"/>

                                        <div class="form-group" align="left">
                                            <label>Perbelanjaan<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="perbelanjaan" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $perbelanjaan= getNamaPerbelanjaan();
                                                while ($listN  = $perbelanjaan -> fetch_assoc()){ ?>
                                                    <option value="<? echo $listN['id'];?>"><? echo $listN['description'];?></option>
                                                    <?
                                                }
                                                ?>

                                            </select>
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Penerima Bayaran<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="nama_penerima" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $nama_penerima= getNamaPenerima();
                                                while ($listM  = $nama_penerima -> fetch_assoc()){ ?>
                                                    <option value="<? echo $listM['id'];?>"><? echo $listM['nama_penerima'];?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Kaedah Bayaran<font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="jenis_perbelanjaan" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $jenis_perbelanjaan= getJenisPerbelanjaan();
                                                while ($listP  = $jenis_perbelanjaan -> fetch_assoc()){ ?>
                                                    <option value="<? echo $listP['id'];?>"><? echo $listP['nama'];?></option>
                                                    <?
                                                }

                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Muat Naik Resit<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" type="file" id="file_upload" name="file_upload" required autocomplete="off" accept="image/*">
                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Amaun Bayaran (RM)<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="amaun_bayaran" name="amaun_bayaran" required autocomplete="">
                                        </div>

                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Bayaran Dibuat<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" id="tarikh_bayaran_dibuat" name="tarikh_bayaran_dibuat" placeholder="DD/MM/YYY" type="date" />
                                        </div>

                                        <div class="form-group" align="left">
                                            <!-- <label>Rujukan<font color="red">**</font>&nbsp;</label> -->
                                            <input type="hidden" class="form-control" placeholder=" " id="rujukan" name="rujukan" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <!-- <label>Maklumat Rujukan<font color="red">**</font>&nbsp;</label> -->
                                            <input type="hidden" class="form-control" placeholder=" " id="details_rujukan" name="details_rujukan" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Catatan<font color="red">**</font>&nbsp;</label>
                                            <textarea class="form-control" placeholder=" " id="catatan" name="catatan" required autocomplete=""></textarea>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" onClick="return confirm('Adakah anda pasti mahu menyimpan data ini?')";\">Simpan</button>
                                            <button type="reset" class="btn btn-warning" onClick="return confirm('Adakah anda pasti untuk membuat tatapan semua ?')";\">Tetapan Semula</button>
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
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Perbelanjaan</th>
                                <th>Penerima Bayaran</th>
                                <th>Kaedah Bayaran</th>
                                <th>Amaun Bayaran (RM)</th>
                                <th>Tarikh Bayaran</th>
                                <th>No. Rujukan</th>
                                <!-- <th>Maklumat Rujukan</th> -->
                                <th>Tindakan</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?
                            $i= 1;

                            $data = getPerbelanjaan($bulan,$tahun);
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['tahun']; ?></td>
                                    <td><?php echo $row_data['bulan']; ?></td>
                                    <td>
                                        <a href="perbelanjaan_details.php?id=<? echo $row_data['id'];?>"><?php echo $row_data['description']; ?></a>
                                    </td>
                                    <td><?php echo $row_data['nama_penerima']; ?></td>
                                    <td><?php echo $row_data['nama']; ?></td>
                                    <td><?php echo $row_data['amaun_bayaran']; ?></td>
                                    <td><?php echo $row_data['tarikh_bayaran_dibuat']; ?></td>
                                    <td><?php echo $row_data['no_rujukan']; ?></td>

                                    <td>

                                        <div class="modal-footer">
                                            <a href="perbelanjaan_edit.php?id=<? echo $row_data['id']; ?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>

                                            <a href="../controller/perbelanjaan_delete_exec.php?id=<? echo $row_data['id']; ?>"><button type="button" class="btn btn-danger" onClick="return confirm('Adakah anda pasti mahu memadam data ini?')";\">Padam</button>

                                        </div>

                                    </td>
                                </tr>


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
</script>

</body>

</html>
