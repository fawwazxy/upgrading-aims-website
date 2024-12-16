<?php

include ('../controller/auth.php');

require "../model/niaga_function.php";

?>

<?
//$id_inbois = $_GET['id_inbois'];
//$id_bayaran = $_GET['id_bayaran'];
$id_sebut_harga =$_GET['id_sebut_harga'];
$id_pesanan_belian = $_GET['id_pesanan_belian'];

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
                <h1 class="page-header">Pesanan Jualan (S.O)</h1>
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


                                $row=  getPurchaseOrderInfo($id_sebut_harga)->fetch_assoc();

                                ?>

                                <form method="post" enctype="multipart/form-data" action="../controller/niaga_pesanan_belian_update_exec.php?id_sebut_harga=<? echo $id_sebut_harga;?>" >


                                    <input name="id_sebut_harga" type="hidden" class="input-short" value="<? echo $_GET['id_sebut_harga']; ?>" />




                                    <label><font color="red">Maklumat Wajib Diisi.</font></label><br>

                                    <label>Perkara</label><br>
                                    <? echo $row['tajuk_sebut_harga'];?>
                                    <br><br>

                                    <label>No.Rujukan Sebutharga</label><br>
                                    <? echo $row['norujukan_sebut_harga'];?>
                                    <br><br>

                                    <label>Pelanggan</label><br>
                                    <? echo $row['agensi_rujukan'];?>
                                    <br><br>

                                    <label>Untuk Rujukan</label><br>
                                    <? echo $row['nama_rujukan'];?>
                                    <br><br>



                                    <div class="form-group" align="left">
                                        <label>Tarikh Pesanan Jualan Diterima<font color="red">**</font>&nbsp;</label>
                                        <input type="date" class="form-control" name="tarikh_pesanan_belian"  id="tarikh_pesanan_belian" value="<? echo $row['tarikh_pesanan_belian'];?>"required autocomplete=""/><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Jumlah Harga (RM)<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control" name="jumlah_harga" id="jumlah_harga"  value="<? echo $row['jumlah_harga'];?>" required autocomplete="" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Muat Naik Dokumen Pesanan Jualan (format .JPG sahaja) <font color="red">**</font>&nbsp;</label>
                                        <br>
                                        <?
                                        getPOImg($id_sebut_harga);
                                        ?>


                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                        <input class="form-control"  type="file"   name="document" id="document">



                                        <br>
                                    </div>
                                    <div class="form-group" align="left">
                                        <label>Pilih Pegawai Pelaksana<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control"  name="ketua_projek" value="<? echo $row['name'];?>">
                                            <option value="">-- Pilih --</option>

                                            <? $person= getPegawai();
                                            while ($pilih  = $person -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['no_staff'];?>" <? echo ($pilih['no_staff']==$row['ketua_projek']?'selected':'');?>><? echo $pilih['name'];?> ---<? echo $pilih['nama_bahagian']?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Muat Naik Dokumen Rujukan<font color="red">**</font>&nbsp;</label>
                                        <br>
                                        <?
                                        //getPODoc($id_sebut_harga);
                                        ?>

                                        <a href="../controller/downloadFileProject.php?id_pesanan_belian=<?echo $row['id_pesanan_belian'];?>&action=so"><i class="fa fa-download"></i> Muat Turun Dokumen Projek</a>


                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                        <input class="form-control"  type="file"   name="document_rujukan" id="document_rujukan" value="<? echo $row['nama_document_rujukan'];?>">

                                        <br>
                                    </div>
                                    <div class="form-group" align="left">
                                        <label>Pegawai Rujukan Dalaman<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control"  name="pegawai_dalaman" value="<? echo $row['name'];?>">
                                            <option value="">-- Pilih --</option>

                                            <? $person= getPegawai();
                                            while ($pilih  = $person -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['no_staff'];?>" <? echo ($pilih['no_staff']==$row['pegawai_dalaman']?'selected':'');?>><? echo $pilih['name'];?> ---<? echo $pilih['nama_bahagian']?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>






                                    <br>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>



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
