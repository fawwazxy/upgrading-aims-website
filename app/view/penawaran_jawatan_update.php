<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$com_id=$_GET['SESS_COM'];
$id = $_GET['id'];
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
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>

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
                <h1 class="page-header">Kemaskini Penawaran Jawatan</h1>


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



                                $log_jawatan= getPenawaranJaw($id)-> fetch_assoc();


                                ?>


                                <label><font color="red">Maklumat Wajib Diisi.</font></label>
                                <br>



                                <div class="form-group" align="left">
                                    <form id="formsubmit" method="post" action="../controller/penawaran_jawatan_update_exec.php?&id=<? echo $id;?>">

                                        <input type="hidden" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
                                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                        <input type="hidden" id="catatancode" name="catatancode" value="" />
                                        <div class="form-group" align="left">
                                            <label>Peranan <font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="role" value="<? echo $log_jawatan['role']; ?>">
                                                <option value="">-- Pilih --</option>

                                                <? $role= getJenisPeranan();
                                                while ($list  = $role -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>" <?echo ($list['code']==$log_jawatan['role']?'selected':'');?>
                                                    ><? echo $list['role'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>




                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Mula</label>
                                            <input class="form-control" id="tarikh_mula" name="tarikh_mula" placeholder="DD/MM/YYY"
                                                   value="<? echo date('d/m/Y',strtotime($log_jawatan['tarikh_mula']));?>" type="text"/>
                                        </div>


                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Akhir</label>
                                            <input class="form-control" id="tarikh_akhir" name="tarikh_akhir"  placeholder="DD/MM/YYY"
                                                   value="<? echo date('d/m/Y',strtotime($log_jawatan['tarikh_akhir']));?>" type="text" onchange="showDays()"/>
                                        </div>


                                    </form>
                                    <div class="form-group">
                                        <label for="comment">Keterangan</label>
                                        <textarea class="form-control" rows="5" name="keterangan" id="summernote"><? echo $log_jawatan['keterangan'];?></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" form="formsubmit" class="btn btn-primary" >Simpan</button>
                                        <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

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
            $('#summernote').summernote({
                height: "300px",
                styleWithSpan: false

            });

            //make default run
            var markupStr = $('#summernote').summernote('code');

            markupStr = markupStr.replace(/\(/g, "^)·(");
            markupStr = markupStr.replace(/\{/g, "=?¿¡12");
            markupStr = markupStr.replace(/\</g, "++ççcsacsa");
            //markupStr = markupStr.replace(/\*/g, "++ççcsacsta");
            //markupStr = markupStr.replace(/'/g, '&lsquo;');
            //alert(markupStr);
            $('#catatancode').val(markupStr);
            //end default

            $("#summernote").on("summernote.change", function (e) {   // callback as jquery custom event
                var markupStr = $('#summernote').summernote('code');

                markupStr = markupStr.replace(/\(/g, "^)·(");
                markupStr = markupStr.replace(/\{/g, "=?¿¡12");
                markupStr = markupStr.replace(/\</g, "++ççcsacsa");
                //markupStr = markupStr.replace(/\*/g, "++ççcsacsta");
                //markupStr = markupStr.replace(/'/g, '&lsquo;');
                //alert(markupStr);
                $('#catatancode').val(markupStr);
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

        function reset() {
            $("#formsubmit").trigger("reset");
            $('#summernote').summernote('reset');
        }
    </script>


</body>

</html>
