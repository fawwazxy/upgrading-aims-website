<?php

include ('../controller/auth.php');


require "../model/claim_function.php";

?>

<?php
$no_staff = $_GET['no_staff'];
$jenis_tuntutan=$_GET['jenis_tuntutan'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk meneruskan?');
        }

    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


    <!-- <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>-->




    <script>
        function goBack()
        {
            window.history.back()
        }
        function HantarUrl(obj){


// var url=$('#jenis_tuntutan').find('option:selected').data('id');
            var url=$('.mytest').find('option:selected').attr('url');
            if(url != ""){
                //alert("Anda Pasti Untuk Meneruskan?"+url);
                $("#myform").attr('action',url);
                $("#myform").submit();
            }else{
                //$("#myform2").attr('hidden','false');
                document.getElementById('myhidden').hidden = false;
            }


        }


    </script>




</head>

<body >

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
                <?
                $flagScreen="tab_2";
                include ('../global/menu_tuntutan_4.php');

                ?>
                <h1 class="page-header">Tuntutan Perjalanan Jarak/Kenderaan</h1>
            </div>





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




                                <form method="post" action="../controller/tuntutan_perjalanan_jarak_add_exec.php" enctype="multipart/form-data"  >
                                    <div class="form-group" align="left">
                                        <!--<input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" />-->
                                        <!--<input name="staff_record_id" type="hidden" c-lass="input-short" value="<? echo $staff['id'];?>" />-->
                                        <!--<input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department_id'];?>"/>-->
                                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />

                                        <?
                                        $transport= getJenisTuntutanTRNSPRT()-> fetch_assoc();

                                        ?>
                                        <label>Jenis Tuntutan</label>

                                        <input class="form-control" type="hidden" name="jenis_tuntutan" id="jenis_tuntutan" value="TRNSPRT"  required autocomplete="off">

                                        <input class="form-control" value="<? echo $transport['nama_tuntutan'];?>"  readonly="readonly" required autocomplete="off">
                                        <br>
                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Memohon</label>
                                            <input class="form-control" value="<?echo date('d/m/Y');?>" name="tarikh_pohon" placeholder="DD/MM/YYY" type="text"/>

                                        </div>


                                        <div class="form-group" align="left">
                                            <label>Dari <font color="red">**</font>&nbsp;</label>
                                            <input class="form-control"  name="tempat_from" id="tempat_from" required autocomplete="off">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Ke <font color="red">**</font>&nbsp;</label>
                                            <input class="form-control"  name="tempat_to" id="tempat_to" required autocomplete="off">
                                        </div>

                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Perjalanan<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" id="tarikh_journey" name="tarikh_journey" placeholder="DD/MM/YYY" type="text"/>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jumlah Jarak Perjalanan<strong>(KM)</strong></strong><font color="red">**</font>&nbsp;</label>
                                            <input class="form-control"  name="jumlah_jarak" id="jumlah_jarak"  onblur="getNilaiTuntutan()" required autocomplete="off">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Jumlah Tuntutan<strong>(RM)</strong></strong></label>
                                            <input class="form-control"  name="jumlah_tuntutan" id="jumlah_tuntutan" required autocomplete="off">
                                        </div>

                                        <div class="form-group" align="left">

                                            <input class="form-control"  name="jarak_id" id="jarak_id" type="hidden" required autocomplete="off">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Dokumen/Bukti<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" type="file"  name="document" id="document" required autocomplete="off">
                                            <br>

                                            <div class="form-group" align="left">
                                                <label>Pilih Pelulus<font color="red">**</font>&nbsp;</label>
                                                <select required class="form-control"  name="pelulus" value="">
                                                    <option value="">-- Pilih --</option>

                                                    <? $person= getTuntutanPelulus();
                                                    while ($pilih  = $person -> fetch_assoc()){ ?>
                                                        <option value="<? echo $pilih['approve_person'];?>"><? echo $pilih['nama_pelulus'];?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="comment">Catatan</label>
                                                <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                            </div>

                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-primary" onclick="return Confirm()">Simpan</button>
                                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
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
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        var tarikh_mula=$('input[name="tarikh_pohon"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_mula.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        var tarikh_akhir=$('input[name="tarikh_journey"]'); //our date input has the name "date"
        // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_akhir.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,

            todayHighlight:true
        });

    });

    function getNilaiTuntutan(){

        var jumlah_jarak = document.getElementById('jumlah_jarak').value;

        $.ajax({
            url: "../model/claim_function.php",
            type: "POST",
            data: {action:"get_nilai",jumlah_jarak: jumlah_jarak},
            success: function (response) {

                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);
                var nilai=response.split('|');
                document.getElementById('jumlah_tuntutan').value = nilai[0]  ;
                document.getElementById('jarak_id').value = nilai[1]  ;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }


        });
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
