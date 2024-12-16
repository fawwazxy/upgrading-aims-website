<?php

include ('../controller/auth.php');


require "../model/cuti_function.php";

$no_staff = $_GET['no_staff'];
$staff_record_id = $_GET['staff_record_id'];
$staff = getStaffInformation($_SESSION['SESS_NO_STAFF'])-> fetch_assoc();
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

    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>

</head>
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 6px 6px 6px 6px;
    }
</style>
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

                    <? include ('../../app/global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Borang Permohonan Cuti</h1>

                <div class="row">
                    <div class="col-lg-12">
                        <label>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['staff_name'];?>
                        <br><label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['noic'];?>
                        <br><label>No. Staf &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $_SESSION['SESS_NO_STAFF'];?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/permohonan_cuti_tahunan_add_exec.php" enctype="multipart/form-data">
                    <div>
                        <input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff['id'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                        <input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department'];?>"/>
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                    </div>

                    <div class="form-group" align="right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Tambah Maklumat Permohonan Cuti</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <input name="alamat_tetap" type="hidden"  id="alamat_tetap" value="<? echo $staff['alamat_tetap']?>"/>
                                    <label>Alamat Bercuti<font color="red">&nbsp;**</font></label>&nbsp;
                                    <button onclick="copyToClipboard()">Salin Alamat Tetap</button>
                                    <textarea class="form-control" rows="5" name="alamat_cuti" id="alamat_cuti" required autocomplete="off"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <input name="phone" type="hidden"  id="phone" value="<? echo $staff['phone']?>"/>
                                    <label>No Telefon<font color="red">&nbsp;**</font></label>&nbsp;
                                    <button onclick="copyToClipboard1()">Salin Nombor Telefon</button>&nbsp;
                                    <input class="form-control" placeholder=" " id="telepon" name="telepon" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-7">
                                    <label>Jenis Cuti<font color="red">&nbsp;**</font></label><br>
                                    <?
                                    $cuti= getJenisCuti();
                                    while ($pilih  = $cuti -> fetch_assoc()){
                                        if($pilih['code'] == 'AL') {
                                            $checked = "checked";}
                                        else {$checked = '';}?>
                                        <input name="cuti_dipohon" id="cuti_dipohon" onclick="loadCuti(this)" type="radio" <?echo $checked;?> value="<?echo $pilih['code']?>">&nbsp;&nbsp;<?echo $pilih['desc'].'&nbsp;&nbsp;&nbsp;';?>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Tarikh Mula<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" id="tarikh_mula" name="tarikh_mula" placeholder="dd/mm/yyyy" type="text" required value="<?if(!$tarikh_mula){
                                        echo date("d/m/Y");
                                    }else{
                                        echo date($tarikh_mula);
                                    }
                                    ?>">
                                </div>
                                <div class="col-xs-4">
                                    <label>Tarikh Akhir<font color="red">&nbsp;**</font></label>
                                    <input class="form-control" id="tarikh_akhir" name="tarikh_akhir" placeholder="dd/mm/yyyy" type="text"  required value="<?if(!$tarikh_akhir){
                                        echo date("d/m/Y");
                                    }else{
                                        echo date($tarikh_akhir);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-4">
                                    <label>Jumlah Cuti Dipohon (Hari)</label>
                                    <input class="form-control"  name="jumlah_cuti" id="jumlah_cuti"  required autocomplete="off">
                                </div>
                                <div class="col-xs-4">
                                    <label>Baki Cuti (Hari)</label>
                                    <input class="form-control" value="" id="baki_cuti_pohon" name="baki_cuti_pohon"  required autocomplete="off">
                                    <input class="form-control" value="" id="baki_cuti_pohon_cons" name="baki_cuti_pohon" type="hidden" />
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label for="comment">Sebab/Alasan</label>
                                    <textarea class="form-control" rows="5" name="sebab" id="sebab"></textarea>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-xs-8">
                                    <label>Lampiran&nbsp;<font color="red"><i>(Hanya fail format pdf/jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-success" onclick="return Confirm()">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                <!-- <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()"> -->
            </div>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>
<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        loadCuti(document.getElementById('cuti_dipohon'));

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
        $("#tarikh_akhir").change(function () {
            var days = 0;
            var millisecondsPerDay = 1000 * 60 * 60 * 24;
            var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
            var tarikh_akhir = stringToDate(document.getElementById("tarikh_akhir").value,"dd/MM/yyyy","/");

            var millisBetween = tarikh_akhir.getTime() - tarikh_mula.getTime();
            days = millisBetween / millisecondsPerDay;
            // days = days+1;// add 1 sebab hari yg sama dikira satu hari
            //var mydate = new Date('2014-04-03');
            //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
            days = days+1;
            document.getElementById("jumlah_cuti").value=days;
            var baki_cuti = document.getElementById("baki_cuti_pohon_cons").value;
            document.getElementById("baki_cuti_pohon").value=baki_cuti-days;
            // console.log(baki_cuti);
        });



    });

    function copyToClipboard() {
        var alamat_tetap=document.getElementById("alamat_tetap").value;
        document.getElementById("alamat_cuti").value=alamat_tetap;
    }


    function copyToClipboard1(){

        var phone=document.getElementById("phone").value;
        document.getElementById("telepon").value=phone;

    }

    // function showDays(){

    //   //var tarikh_mula = new Date(document.getElementById("tarikh_mula").value);
    //   //var tarikh_akhir = new Date(document.getElementById("tarikh_akhir").value);
    //   var days = 0;
    //   var millisecondsPerDay = 1000 * 60 * 60 * 24;
    //   var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
    //   var tarikh_akhir = stringToDate(document.getElementById("tarikh_akhir").value,"dd/MM/yyyy","/");

    //   var millisBetween = tarikh_akhir.getTime() - tarikh_mula.getTime();
    //   days = millisBetween / millisecondsPerDay;
    //   days = days+1;// add 1 sebab hari yg sama dikira satu hari
    //   //var mydate = new Date('2014-04-03');
    //   //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
    //   document.getElementById("jumlah_cuti").value=days;
    //   var baki_cuti = document.getElementById("baki_cuti").value;
    //   document.getElementById("baki_cuti").value=baki_cuti-days;
    //   console.log(baki_cuti);


    // }

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

    function loadCuti(obj) {
        //alert(obj.value);
        if(obj.checked) {
            var objValue = obj.value;

            // alert('objValue-'+objValue);
            $.ajax({
                url: "../model/cuti_function.php",
                type: "POST",
                data: {action:"getCutiInfo",code:obj.value,staff_record_id:"<? echo $staff_record_id;?>"},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    var dataObject = $.parseJSON(response);
                    // $.alert('test here:'+response.length);
                    if(response.length == 2){


                        $('#nama').val("");
                        $('#notel').val("");

                    }else{
                        $('#baki_cuti_pohon').val(dataObject[0].baki_cuti_pohon);
                        $('#baki_cuti_pohon_cons').val(dataObject[0].baki_cuti_pohon);
                        // $('#notel').val(dataObject[0].notel);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }



</script>

</body>

</html>