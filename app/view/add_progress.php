<?php
include ('../controller/auth.php');
require "../model/support_function.php";

$no_staff=$_GET['no_staff'];
$no_staff_login=$_GET['SESS_NO_STAFF'];
$id=$_GET['id'];
$id_support=$_GET['id_support'];
$id_progress=$_GET['id_progress'];
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Perkembangan Aduan</h1>
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
                                <form method="post" enctype="multipart/form-data" action="../controller/add_progress_exec.php?id=<? echo $id; ?>&id_progress=<? echo $id_progress; ?>" >
                                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $_GET['no_staff']; ?>" />
                                    <input name="id" type="hidden" class="input-short" value="<? echo $_GET['id']; ?>" />
                                    <input name="id_progress" type="text" class="input-short" value="<? echo $_GET['id_progress']; ?>" />
                                    <div class="form-group">
                                        <label>Tarikh Hari Ini</label><br>
                                        <input class="form-control"  name="tarikh" id="tarikh" required autocomplete="off" value="<?php
                                        echo " " . date("d/m/Y") . "";
                                        ?> ">
                                    </div>

                                    <div class="form-group">
                                        <label for="catatan">Progress<span style="color: red; "></span>&nbsp;</label>
                                        <textarea class="form-control" name="catatan" rows="5" id="catatan"></textarea>
                                    </div>
                                    <br><br><br>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    function showDays(){
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
        var tarikh_tamat = stringToDate(document.getElementById("tarikh_tamat").value,"dd/MM/yyyy","/");

        var millisBetween = tarikh_tamat.getTime() - tarikh_mula.getTime();
        var days = millisBetween / millisecondsPerDay;
        days = days+1;// add 1 sebab hari yg sama dikira satu hari
        document.getElementById("jumlah_hari_siap").value=days;
    }
    function stringToDate(_date,_format,_delimiter) {
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
        var tarikh_tamat=$('input[name="tarikh_tamat"]'); //our date input has the name "date"
        // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_tamat.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            todayHighlight:true
        });
    });
</script>
</body>
</html>
