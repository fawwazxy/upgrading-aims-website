<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$pemohon_id = $_GET['pemohon_id'];
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




            <?
            $flagScreen="tab_1";

            include ('../global/menu_pemohon.php');
            ?>

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

                                $id = $_GET['pemohon_id'];

                                $log_pemohon = getPemohon($pemohon_id)-> fetch_assoc();


                                ?>

                                <form method="post" action="../controller/pemohonUpdate_exec.php?&pemohon_id=<? echo $pemohon_id;?>" >


                                    <input name="pemohon_id" type="hidden" class="input-short" value="<? echo $log_pemohon['pemohon_id']; ?>" />
                                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                                    <label><font color="red">Maklumat Wajib Diisi.</font></label>
                                    <br>

                                    <div class="form-group" align="left">
                                        <label>No K/P<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="noic" id="noic" value="<? echo $log_pemohon['noic']; ?>" onchange="Age()"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Nama Pemohon<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="name" value="<? echo $log_pemohon['name']; ?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>No Telefon<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="phone" value="<? echo $log_pemohon['phone']; ?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Emel<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="email" value="<? echo $log_pemohon['email']; ?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Alamat Tetap<font color="red">**</font>&nbsp;</label>
                                        <textarea class="form-control" name="alamat_tetap" rows="5" value=""><? echo $log_pemohon['alamat_tetap']; ?></textarea>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Alamat Surat Menyurat<font color="red">**</font>&nbsp;</label>
                                        <textarea class="form-control" name="alamat_surat" rows="5" value=""><? echo $log_pemohon['alamat_surat']; ?></textarea>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Umur<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="umur" id="umur" value="<? echo $log_pemohon['umur']; ?>"/>
                                    </div>

                                    <input name="status_pemohon" type="hidden" class="input-short" value="DLMPOHON" />


                                    <div class="form-group" align="left">
                                        <label>Status Perkahwinan<font color="red">**</font>&nbsp;</label>
                                        <select class="form-control" name="martial_status" value="<? echo $log_pemohon['martial_status']; ?>">
                                            <option value="">-- Pilih --</option>

                                            <? $kawin= getKawin();
                                            while ($list  = $kawin -> fetch_assoc()){ ?>
                                                <option value="<? echo $list['martial_status'];?>"
                                                    <?
                                                    if($list['martial_status']==$log_pemohon['martial_status']){
                                                        echo "selected";
                                                    }
                                                    ?>
                                                ><? echo $list['martial_status'];?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Jumlah Tanggungan<font color="red">**</font>&nbsp;</label>
                                        <input type="text" class="form-control" name="tanggungan" value="<? echo $log_pemohon['tanggungan']; ?>"/><br>
                                    </div>


                                    <br>

                                    <button type="submit" class="btn btn-info">Seterusnya</button>
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

<script>
    function Age(){
        var ic= document.getElementById("noic").value;
        var year= ic.slice(0,2);
        var age= "19" +year;

        document.getElementById("umur").value=2018-age;
        document.getElementById("umur").focus;

    }
</script>

</body>

</html>
