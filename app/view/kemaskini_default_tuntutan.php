<?php

include ('../controller/auth.php');


require "../model/claim_function.php";

?>

<?php
$no_pemohon= $_GET['no_pemohon'];
$jenis_tuntutan=$_GET['jenis_tuntutan'];
$value=$_GET['value'];
$nama_tuntutan=$_GET['nama_tuntutan'];
$id=$_GET['id'];

?>

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

                $default= getTuntutanDefault($no_pemohon,$jenis_tuntutan,$id)-> fetch_assoc();

                ?>


                <h1 class="page-header">Tuntutan <? echo $default['nama_tuntutan'];?></h1>

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




                                    <form method="post" action="../controller/tuntutan_default_edit_exec.php" enctype="multipart/form-data"  >
                                        <div class="form-group" align="left">
                                            <!--<input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" />-->
                                            <!--<input name="staff_record_id" type="hidden" c-lass="input-short" value="<? echo $staff['id'];?>" />-->
                                            <!--<input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department_id'];?>"/>-->
                                            <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />



                                            <input name="default_id" type="hidden" class="input-short" value="<? echo $default['id'];?>" />

                                            <label>Jenis Tuntutan</label>

                                            <input class="form-control" type="hidden" name="jenis_tuntutan" id="jenis_tuntutan" value="<?echo $default['jenis_tuntutan'];?>"  required autocomplete="off">

                                            <input class="form-control" value="<? echo $default['nama_tuntutan'];?>" required autocomplete="off" readonly="readonly">
                                            <br>
                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" for="date">Tarikh Rujukan Tuntutan</label>
                                                <input class="form-control" value="<?echo date('d/m/Y');?>" name="tarikh_pohon" placeholder="DD/MM/YYY" type="text"/>

                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Jumlah Tuntutan</label> <strong> (RM)</strong><font color="red">**</font>&nbsp;</label>
                                                <input class="form-control"  value="<? echo $default['jumlah_tuntut'];?>" name="jumlah_tuntutan" id="jumlah_tuntutan"  required autocomplete="off"><br>

                                                <div class="form-group" align="left">
                                                    <label>Dokumen/Bukti </label><font color="red">**</font>&nbsp;</label>
                                                    <br>
                                                    <?

                                                    //header ("Content-type: image/jpeg");
                                                    //$myimg = $default["document"];
                                                    //echo'<img height="300" width="300" src="data:image;base64,'.base64_decode($myimg).'">';
                                                    //echo base64_decode($myimg);

                                                    getTuntutanDefaultImg($no_pemohon,$jenis_tuntutan,$id);
                                                    ?><br>
                                                    <input class="form-control"  type="file"   name="document" id="document" ><br>
                                                </div>

                                                <div class="form-group" align="left">
                                                    <label>Pilih Pelulus<font color="red">**</font>&nbsp;</label>
                                                    <select required class="form-control" name="pelulus" value="<? echo $default['pelulus'];?>">
                                                        <option value="">-- Pilih --</option>

                                                        <? $person= getTuntutanPelulus();
                                                        while ($pilih  = $person -> fetch_assoc()){ ?>
                                                            <option value="<? echo $pilih['approve_person'];?>" <?echo ($pilih['approve_person']==$default['approve_by']?'selected':'');?>><? echo $pilih['nama_pelulus'];?></option>

                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>


                                                <div class="form-group">
                                                    <label for="comment">Catatan</label>
                                                    <textarea class="form-control" rows="5"  name="catatan" id="catatan"><? echo $default['catatan'];?></textarea>
                                                </div>



                                                <div class="modal-footer">

                                                    <button type="submit" class="btn btn-primary" onclick="return Confirm()">Simpan</button>
                                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                                </div>

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
