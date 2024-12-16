<?php

include ('../controller/auth.php');

require "../model/surat_function.php";

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


    <script language="javascript" type="text/javascript">


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

                <h1 class="page-header">Menjana Surat</h1>


                <? //
                //$flagScreen="tab_1";
                //include ('../global/menu_pemohon.php');
                //	?>

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



                                    <form method="post" action="../controller/surat_exec.php?">
                                        <div class="form-group" align="left">
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />




                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            <br>

                                            <div class="form-group" align="left">
                                                <label>Jenis Surat<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" name="surat" value="">
                                                    <option value="">-- Pilih --</option>

                                                    <? $surat= getJenisSurat();
                                                    while ($list  = $surat -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['surat'];?>"><? echo $list['surat'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Nama Produk<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" name="produk" value="">
                                                    <option value="">-- Pilih --</option>

                                                    <? $produk= getJenisProduk();
                                                    while ($list  = $produk -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['produk'];?>"><? echo $list['produk'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Pelanggan<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control" name="lead" value="">
                                                    <option value="">-- Pilih --</option>

                                                    <? $lead= getLead();
                                                    while ($list  = $lead -> fetch_assoc()){ ?>
                                                        <option value="<? echo $list['lead_name'];?>"><? echo $list['lead_name'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>






                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" >Simpan</button>
                                                <button type="reset" class="btn btn-info">Tetapan Semula</button>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        var tarikh_iv=$('input[name="tarikh_iv"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_iv.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });


    </script>

</body>

</html>