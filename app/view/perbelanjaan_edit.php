<?php

include ('../controller/auth.php');

require "../model/perbelanjaan_functions.php";

?>
<?
$id=$_GET['id'];
$no_staff=$_GET['no_staff'];
$bulan=$_GET['bulan'];
$tahun=$_GET['tahun'];
$flag=$_GET['flg'];

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

        // -->
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
                <h1 class="page-header">Kemaskini Maklumat Perbelanjaan</h1>
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

                                <form id="myform" method="post"  action="../controller/perbelanjaan_edit_exec.php?bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&id=<?  echo $id;?>" name="myform"  enctype="multipart/form-data" >


                                    <?

                                    $list = getPerbelanjaanInfo($id)->fetch_assoc();

                                    ?>

                                    <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />

                                    <label align="left"><font color="red">"Maklumat Wajib Diisi.</font></label>
                                    <br>



                                    <div class="form-group" align="left">
                                        <label>Perbelanjaan<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="perbelanjaan" value="<? echo $list['perbelanjaan']; ?>">
                                            <option value="">-- Pilih --</option>

                                            <? $perbelanjaan= getNamaPerbelanjaan();
                                            while ($listN  = $perbelanjaan -> fetch_assoc()){ ?>
                                                <option value="<? echo $listN['id'];?>"<? echo($listN['id']==$list['perbelanjaan']?'selected':'');?>><? echo $listN['description']; ?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Penerima Bayaran<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="nama_penerima" value="<? echo $list['nama_penerima']; ?>">
                                            <option value="">-- Pilih --</option>

                                            <? $nama_penerima= getNamaPenerima();
                                            while ($listM  = $nama_penerima -> fetch_assoc()){ ?>
                                                <option value="<? echo $listM['id'];?>"<? echo($listM['id']==$list['nama_penerima']?'selected':'');?>><? echo $listM['nama_penerima']; ?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group" align="left">
                                        <label>Kaedah Bayaran<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="jenis_perbelanjaan" value="<? echo $list['jenis_perbelanjaan']; ?>">
                                            <option value="">-- Pilih --</option>

                                            <? $jenis_perbelanjaan= getJenisPerbelanjaan();
                                            while ($listP  = $jenis_perbelanjaan -> fetch_assoc()){ ?>
                                                <option value="<? echo $listP['id'];?>"<? echo($listP['id']==$list['jenis_perbelanjaan']?'selected':'');?>><? echo $listP['nama']; ?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!--  <div class="form-group" align="left">
                                     <label>Muat Naik Resit<font color="red">**</font>&nbsp;</label>
                                     <input class="form-control" type="file" id="file_upload" name="file_upload" required autocomplete="off" accept="image/*">
                                 </div> -->

                                    <div class="form-group" align="left">
                                        <label>Muat Naik Resit&nbsp;</label><br>
                                        <?
                                        getResitImg($id)
                                        ?>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                        <input class="form-control"  type="file"   name="file_upload" id="file_upload" >

                                    </div>


                                    <div class="form-group" align="left">
                                        <label>Catatan<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control" name="catatan" value="<? echo $list['catatan'];?>">
                                    </div>



                                    <div class="form-group" align="left">
                                        <label>Amaun Bayaran(RM)<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control" name="amaun_bayaran" value="<? echo $list['amaun_bayaran'];?>">
                                    </div>

                                    <div class="form-group"> <!-- Date input -->
                                        <label class="control-label" for="date">Tarikh Bayaran Dibuat<font color="red">**</font>&nbsp;</label>
                                        <input class="form-control" id="tarikh_bayaran_dibuat" name="tarikh_bayaran_dibuat" value="<? echo $list['tarikh_bayaran_dibuat'];?>"/>
                                    </div>



                                    <div class="form-group" align="left">

                                        <input type="hidden" class="form-control" name="rujukan" value="<? echo $list['rujukan'];?>">
                                    </div>

                                    <div class="form-group" align="left">
                                        <input type="hidden" class="form-control" name="details_rujukan" value="<? echo $list['details_rujukan'];?>">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"  onClick="return confirm('Adakah anda mahu menyimpan data ini?')";\">Simpan</button></a>
                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                    </div>
                            </div>

                            </form>

                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div></div>
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
