<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$pemohon_id = $_GET['pemohon_id'];
$no_staff = $_GET['no_staff'];
$act = $_GET['act'];
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
                <h1 class="page-header">Kemaskini Kelulusan Pemohon</h1>


            </div>



            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

            <? //
            //$flagScreen="tab_1";
            //$act="update";
            //include ('../global/menu_pemohon.php');
            //?>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">



                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">


                                <?

                                //$id = $_GET['pemohon_id'];

                                $log_status = getPemohonStatus($pemohon_id)-> fetch_assoc();

                                ?>

                                <form method="post" action="../controller/pemohonKelulusan_exec.php?pemohon_id=<? echo $pemohon_id;?>&act=<? echo $act;?>" >


                                    <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $log_status['pemohon_id']; ?>" />
                                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                                    <label><font color="red">Maklumat Wajib Diisi.</font></label>
                                    <br>

                                    <div class="form-group" align="left">
                                        <label for="comment">Gaji Dipersetujui<font color="red"></font>&nbsp;</label>
                                        <input class="form-control" name="gaji_dipersetujui" value="0.00" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">Tarikh Mula Bekerja<font color="red"> (**Untuk Permohonan Perjawatan)</font>&nbsp;</label>
                                        <input type="date" class="form-control" name="tarikh_mula" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">No. Rujukan Surat<font color="red"> (**Untuk Permohonan Latihan Industri)</font>&nbsp;</label>
                                        <input class="form-control" name="no_rujukan"  /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">Tarikh Rujukan Surat<font color="red"> (**Untuk Permohonan Latihan Industri)</font>&nbsp;</label>
                                        <input type="date" class="form-control" name="tarikh_rujukan" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">No. Matrik<font color="red"> (**Untuk Permohonan Latihan Industri)</font>&nbsp;</label>
                                        <input class="form-control" name="nomatrik"  /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">Program<font color="red"> (**Untuk Permohonan Latihan Industri)</font>&nbsp;</label>
                                        <input class="form-control" name="program"  /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">Tempoh<font color="red"> (**Untuk Permohonan Latihan Industri)</font>&nbsp;</label>
                                        <input class="form-control" name="tempoh"  /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label for="comment">Catatan<font color="red"></font>&nbsp;</label>
                                        <textarea class="form-control" name="catatan" rows="5" value="<? echo $log_status['catatan']; ?>"/></textarea><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Status Pemohon<font color="red">**</font>&nbsp;</label>
                                        <select required class="form-control" name="status_pemohon" value="<? echo $log_status['status_pemohon']; ?>">
                                            <option value="">-- Pilih --</option>

                                            <? $mohon=getStatusKelulusan();
                                            while ($list  = $mohon -> fetch_assoc()){ ?>
                                                <option value="<? echo $list['code'];?>" <?echo ($list['code']==$log_status['status_pemohon']?'selected':'');?>
                                                ><? echo $list['desc'];?></option>

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
