<?php

include ('../controller/auth.php');

require "../model/support_function.php";

$no_staff=$_GET['no_staff'];

$no_staff_login=$_SESSION['SESS_NO_STAFF'];
$id=$_GET['id'];

$id_support_developer=$_GET['id_support_developer'];



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
                <h1 class="page-header">Kemaskini Sokongan</h1>
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






                                <form method="post" enctype="multipart/form-data" action="../controller/update_support_developer_exec.php?id=<?php echo $row['id']; ?>" >



                                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff_login ?>" />

                                    <input name="id" type="hidden" class="input-short" value="<? echo $id; ?>" />
                                    <input name="id_support_developer" type="hidden" class="input-short" value="<? echo $id_support_developer; ?>" />


                                    <?


                                    $row=  getSupportUpdateDeveloper($id)->fetch_assoc();

                                    ?>


                                    <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>

                                    <label>Nama Projek/Sistem</label><br>
                                    <? echo $row['nama_projek'];?>
                                    <br><br>

                                    <label>Aduan</label><br>

                                    <? echo $row['aduan'];?>

                                    <br><br>

                                    <label>Nama Penghantar</label><br>
                                    <? echo $row['nama_client'];?>
                                    <br><br>

                                    <label>Nombor Telefon</label><br>
                                    <? echo $row['notel'];?>
                                    <br><br>

                                    <label>Catatan</label><br>
                                    <? echo $row['remarks'];?>
                                    <br><br>


                                    <div class="form-group">
                                        <label>Tahap Keutamaan<font color="red">**</font>&nbsp;</label><br>
                                        <?
                                        for ($i = 1; $i <= 5; $i++) {
                                            $ratingClass = "btn-default btn-grey";
                                            if($i <= $row['level_developer']) {
                                                $ratingClass = "btn-warning";
                                            }
                                            ?>
                                            <button type="button" class="btn btn-sm <?php echo $ratingClass; ?> rateButton" aria-label="Left Align"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></button>

                                        <?}?>
                                        <input type="hidden" class="form-control" id="level_developer" name="level_developer" value="<?echo $row['level_developer']?>">

                                    </div>



                                    <div class="form-group" align="left">
                                        <label>Tarikh Mula</label>
                                        <input class="form-control" id="tarikh_mula" name="tarikh_mula" placeholder="DD/MM/YYY" type="text" value="<?if($row['tarikh_mula']==''){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($row['tarikh_mula']));} ?>"/>
                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Tarikh Tamat</label>
                                        <input class="form-control" id="tarikh_tamat" name="tarikh_tamat" placeholder="DD/MM/YYY" type="text" onchange="showDays()" value="<?if($row['tarikh_tamat']==''){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($row['tarikh_tamat']));} ?>"/>
                                    </div>


                                    <div class="form-group" align="left">
                                        <label>Bil. Hari Penyelesaian</label>
                                        <input class="form-control"  name="jumlah_hari_siap" id="jumlah_hari_siap"  value="<?if($row['jumlah_hari_siap']==''){echo '1';}else{echo $row['jumlah_hari_siap'];} ?>">
                                    </div>



                                    <div class="form-group" align="left">
                                        <label>Status Penerimaan<font color="red"></font>&nbsp;</label>
                                        <select required class="form-control"  name="status_tindakan" id="status_tindakan" value=" <? echo $row['status_tindakan']; ?>">


                                            <? $status= statusKelulusanSupport();
                                            while ($pilih  = $status -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['code'];?>"><? echo $pilih['keterangan'];?></option>




                                                <?
                                            }
                                            ?>
                                        </select>                       </div>

                                    <div class="form-group" align="left">
                                        <label>Catatan<font color="red"></font>&nbsp;</label>
                                        <textarea class="form-control" name="catatan" rows="5" ><? echo $row['catatan']; ?></textarea>
                                    </div>

                                    <br><br>



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
<script >
    function showDays(){

        //var tarikh_mula = new Date(document.getElementById("tarikh_mula").value);
        //var tarikh_akhir = new Date(document.getElementById("tarikh_akhir").value);
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var tarikh_mula = stringToDate(document.getElementById("tarikh_mula").value,"dd/MM/yyyy","/");
        var tarikh_tamat = stringToDate(document.getElementById("tarikh_tamat").value,"dd/MM/yyyy","/");

        var millisBetween = tarikh_tamat.getTime() - tarikh_mula.getTime();
        var days = millisBetween / millisecondsPerDay;
        days = days+1;// add 1 sebab hari yg sama dikira satu hari
        //var mydate = new Date('2014-04-03');
        //var days= dateDiff(new Date(tarikh_mula), new Date(tarikh_akhir);
        document.getElementById("jumlah_hari_siap").value=days;




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

    $(document).ready(function() {
        $( ".rateButton" ).click(function() {
            if($(this).toggleClass('btn-grey')) {
                $(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            } else {
                $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
            }
            $("#level_developer").val($('.star-selected').length);
        });
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
