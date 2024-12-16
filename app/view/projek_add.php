<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";

?>

<?
//$id_inbois = $_GET['id_inbois'];
//$id_bayaran = $_GET['id_bayaran'];
// $id_sebut_harga =$_GET['id_sebut_harga'];
$id_pesanan_belian = $_GET['id_pesanan_belian'];
$no_staff = $_GET['no_staff'];

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
                <h1 class="page-header">Projek</h1>
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


                                $row=  getInfoPO($id_pesanan_belian)->fetch_assoc();

                                ?>


                                <form method="post" action="../controller/projek_exec.php?id_pesanan_belian=<? echo $id_pesanan_belian;?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF'];?>" >


                                    <input name="id_pesanan_belian" type="hidden" class="input-short" value="<? echo $_GET['id_pesanan_belian']; ?>" />




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
                                        <label class="control-label" for="date">Jangkaan Tarikh Mula Projek<font color="red">**</font>&nbsp;</label>
                                        <input  class="form-control" name="tarikh_mula"  id="tarikh_mula" placeholder="DD/MM/YYY" type="text"  /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label class="control-label" for="date">Jangkaan Tarikh Tamat Projek<font color="red">**</font>&nbsp;</label>
                                        <input  class="form-control" name="tarikh_akhir"  id="tarikh_akhir" placeholder="DD/MM/YYY" type="text" onchange="showDays()" /><br>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Jumlah Hari</label>
                                        <input class="form-control"  name="jumlah_hari" id="jumlah_hari"  required autocomplete="off">
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

        var tarikh_mula=$('input[name="tarikh_mula"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_mula.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        var tarikh_akhir=$('input[name="tarikh_akhir"]'); //our date input has the name "date"
        // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_akhir.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,

            todayHighlight:true
        });

    });
    function showDays(){

        //var tarikh_mula = new Date(document.getElementById("tarikh_mula").value);
        //var tarikh_akhir = new Date(document.getElementById("tarikh_akhir").value);
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
        var tarikh_akhir = stringToDate(document.getElementById("tarikh_akhir").value,"dd/MM/yyyy","/");

        var millisBetween = tarikh_akhir.getTime() - tarikh_mula.getTime();
        var days = millisBetween / millisecondsPerDay;
        days = days+1;// add 1 sebab hari yg sama dikira satu hari
        //var mydate = new Date('2014-04-03');
        //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
        document.getElementById("jumlah_hari").value=days;

    }

    function stringToDate(_date,_format,_delimiter)
    {
        var formatLowerCase=_format.toLowerCase();
        var formatItems=formatLowerCase.split(_delimiter);
        var dateItems=_date.split(_delimiter);
        var monthIndex=formatItems.indexOf("mm");
        var dayIndex=formatItems.indexOf("dd");
        var yearIndex=formatItems.indexOf("yyyy");
        var month=parseInt(dateItems[monthIndex]);
        month-=1;
        var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
        return formatedDate;
    }
</script>

</body>

</html>
