<?php

include ('../controller/auth.php');

require "../model/analisa_kehadiran_functions.php";
require "../model/lookup.php";

//$kod_cawangan = $_SESSION['SESS_CAWANGAN'];
$department_id = $_SESSION['SESS_DEPARTMENT'];

$noic = $_GET['noic'];
$data_jabatan = getJabatanByKod($department_id)->fetch_assoc();
$staff_details = getStaffDetailsByNokp($noic)->fetch_assoc();
$no_staff = $staff_details['no_staff'];
$sys = getSys(1)->fetch_assoc();
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
                <h1 class="page-header">Analisa Kehadiran Bahagian <?echo $data_jabatan['description'];?></h1>
            </div>
            <div class="form-group" align="left">
                <div class="col-xs-4">

                </div>

                <div class="col-xs-4">

                </div>

                <div class="col-xs-4">
                    <select required class="form-control" id="noic" name="noic" value="<?echo $noic?>" onchange="reloadStaff(this.value)">
                        <option value="">-- Pilih Staf --</option>
                        <?echo getDropDownStaffByDepartment($department_id,$noic);?>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <?if($noic ==''){?>
                <div class="col-lg-12">


                    <div class="panel panel-red">
                        <!-- /.panel-heading -->
                        <div class="panel-heading">
                            <center><b>Analisa Kehadiran Staf</b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th bgcolor="#D6DBDF" width="13%"><center>Jumlah Staf</center></th>
                                <th bgcolor="#D6DBDF" width="13%"><center>Bil. Hadir</center></th>
                                <th bgcolor="#D6DBDF" width="13%"><center>Bil. Tidak Hadir</center></th>
                                <th bgcolor="#D6DBDF" width="13%"><center>Bil. Bercuti</center></th>
                                <th bgcolor="#D6DBDF" width="20%" colspan="3"><center>Jumlah Hadir</center></th>
                                <th bgcolor="#D6DBDF" width="30%"><center>Peratusan Kehadiran</center></th>
                            </tr>
                            </thead>
                            <?
                            $kehadiran = getBilStafHadirByDepartment($department_id)->fetch_assoc();
                            if($kehadiran['bil_staff']!=0 && $kehadiran['bil_hadir']!=0){
                                $peratusan = ($kehadiran['bil_hadir']/$kehadiran['bil_staff'])*100;

                            }else{
                                $peratusan='0.00';

                            }
                            ?>

                            <tbody>
                            <tr>

                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="black"><? echo $kehadiran['bil_staff'];?></font></strong></td>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="blue"><? echo  $kehadiran['bil_hadir'];?></font></strong></td>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><?echo getBilStafTidakHadirByDepartment($department_id);?></font></strong></td>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><?echo getCountCutiByDepartment($department_id);?></font></strong></td>
                                <th width="10%" bgcolor="#E8E8E8"><center>Awal</center></th>
                                <th width="10%" bgcolor="#E8E8E8"><center>Tepat</center></th>
                                <th width="10%" bgcolor="#E8E8E8"><center>Lewat</center></th>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="brown"><? echo round($peratusan,2);?>%</font></strong></td>
                            </tr>
                            <tr>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="green"><?echo getBilKehadiranStatusByDepartment($department_id,'AWAL');?></font></strong>
                                </td>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="purple"><?echo getBilKehadiranStatusByDepartment($department_id,'TEPAT');?></font></strong>
                                </td>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="red"><?echo getBilKehadiranStatusByDepartment($department_id,'LEWAT');?></font></strong>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?}?>
            <?if($department_id !='' && $noic==''){?>
                <div class="col-lg-12">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <center><b>Analisa Kehadiran Bahagian <?echo $data_jabatan['description'];?></b></center>
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th bgcolor="#D6DBDF" width="5%">Bil.</th>
                                <th bgcolor="#D6DBDF" width="28%">Nama Staf</th>
                                <th bgcolor="#D6DBDF" width="13%"><center>Jumlah Hari Bekerja</center></th>
                                <th bgcolor="#D6DBDF" width="40%" colspan="4"><center>Jumlah Hadir</center></th>
                                <th bgcolor="#D6DBDF" width="18%"><center>Peratusan Kehadiran</center></th>
                            </tr>
                            <tr>
                                <th bgcolor="#D6DBDF" width="5%" rowspan="2"></th>
                                <th bgcolor="#D6DBDF" width="28%" rowspan="2"></th>
                                <th bgcolor="#D6DBDF" width="13%" rowspan="2"><center></center></th>
                                <th bgcolor="#E8E8E8" width="10%"><center>Keseluruhan</center></th>
                                <th bgcolor="#E8E8E8" width="10%"><center>Awal</center></th>
                                <th bgcolor="#E8E8E8" width="10%"><center>Tepat</center></th>
                                <th bgcolor="#E8E8E8" width="10%"><center>Lewat</center></th>
                                <th bgcolor="#D6DBDF" width="18%" rowspan="2"><center></center></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $data_caw = analisaKehadiranByJabatan($department_id);
                            $i=1;
                            while($list_caw = $data_caw->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td bgcolor="#FDFEFE"><?echo $i++;?>.</td>
                                    <td bgcolor="#FDFEFE"><?echo $list_caw['name']?></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="black"><?echo $working=workdays($date_month,$date_year,$list_caw['no_staff'])?></font></b></center></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="blue"><?echo $list_caw['bil_kehadiran']?></font></b></center></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="green"><?echo analisaKehadiranStaffByJabatan($department_id,$list_caw['noic'],'AWAL');?></font></b></center></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="purple"><?echo analisaKehadiranStaffByJabatan($department_id,$list_caw['noic'],'TEPAT');?></font></b></center></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo analisaKehadiranStaffByJabatan($department_id,$list_caw['noic'],'LEWAT');?></font></b></center></td>
                                    <td bgcolor="#FDFEFE"><center><b><font size="5" color="brown"><? $percent = ($list_caw['bil_kehadiran']/$working)*100; echo number_format($percent,2);?>%</font></b></center></td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?}else if($department_id !='' && $noic!=''){?>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['name'];?><br>
                            <label>No. Kad Pengenalan &nbsp;&nbsp;:</label>&nbsp;<?echo $noic;?><br>
                            <label>No. Staf &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['no_staff'];?><br>
                            <label>Jawatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $staff_details['role'];?><br>
                            <label>Bahagian &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo '<b>'.$staff_details['code_department'].'</b>'.'&nbsp;-&nbsp'.$staff_details['description'];?><br>
                            <label>Lokasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo '<b>'.$staff_details['cawangan_kod'].'</b>'.'&nbsp;-&nbsp'.$staff_details['nama'];?>
                        </div>
                    </div>
                    <br><div class="panel panel-red">
                        <div class="panel-heading" align="center">
                            <label class="control-label" for="date">Analisa Kehadiran Peribadi</label>
                        </div>
                        <!-- /.panel-heading -->
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th bgcolor="#D6DBDF" width="17%"><center>Jumlah Hari Bekerja</center></th>
                                <th bgcolor="#D6DBDF" width="17%"><center>Jumlah Kehadiran</center></th>
                                <th bgcolor="#D6DBDF" width="17%"><center>Awal</center></th>
                                <th bgcolor="#D6DBDF" width="17%"><center>Tepat</center></th>
                                <th bgcolor="#D6DBDF" width="17%"><center>Lewat</center></th>
                                <th bgcolor="#D6DBDF" width="17%"><center>Peratusan Kehadiran</center></th>
                            </tr>
                            </thead>
                            <?
                            $jumlah_hari_bekerja = getAnalisaJumlahHariBekerja($noic,$no_staff);
                            $jumlah_kehadiran = getAnalisaJumlahKehadiran($noic);
                            $kehadiran_awal = getAnalisaKehadiranAwal($noic);
                            $kehadiran_tepat = getAnalisaKehadiranTepat($noic);
                            $kehadiran_lewat = getAnalisaKehadiranLewat($noic);

                            if($jumlah_hari_bekerja != 0 ) {
                                $peratusan_kehadiran = $jumlah_kehadiran/$jumlah_hari_bekerja * 100;
                            }
                            else {
                                $peratusan_kehadiran = 0.00;
                            }
                            ?>
                            <tbody>
                            <tr>
                                <td align="center" rowspan="3" bgcolor="#FDFEFE">
                                    <h2><strong><font color="black"><?echo $jumlah_hari_bekerja;?></font></strong></h2>
                                </td>

                                <td align="center" rowspan="3" bgcolor="#FDFEFE" onclick="getAnalisaKehadiranAllDetails()">
                                    <h2><strong><font color="blue"><?echo $jumlah_kehadiran;?></font></strong></h2>
                                </td>

                                <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('AWAL')">
                                    <h2><strong><font color="green"><?echo $kehadiran_awal;?></font></strong></h2>
                                </td>

                                <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('TEPAT')">
                                    <h2><strong><font color="purple"><?echo $kehadiran_tepat;?></font></strong></h2>
                                </td>

                                <td align="center" rowspan="3"  bgcolor="#FDFEFE" onclick="getAnalisaKehadiranDetails('LEWAT')">
                                    <h2><strong><font color="red"><?echo $kehadiran_lewat;?></font></strong></h2>
                                </td>

                                <td align="center" rowspan="3" bgcolor="#FDFEFE">
                                    <h2><strong><font color="brown"><?echo round($peratusan_kehadiran,2);?>%</font></strong></h2>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <?if(isset($noic))
                    {
                        ?>
                        <div id="kehadiran_details_all">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label class="control-label" for="date">Maklumat Kehadiran Peribadi <?if($status_kehadiran=='AWAL'){echo '<strong><font color="green">'.'AWAL'.'</font></strong>';}else if($status_kehadiran=='TEPAT'){echo '<strong><font color="purple">'.'TEPAT'.'</font></strong>';}else if($status_kehadiran == 'LEWAT'){echo '<strong><font color="red">'.'LEWAT'.'</font></strong>';} else{echo '<strong><font color="blue">'.'KESELURUHAN'.'</font></strong>';}?></label>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th width="7%">Bil</th>
                                            <th width="10%">Hari</th>
                                            <th width="15%">Tarikh & Masa</th>
                                            <th width="15%">Platform</th>
                                            <th width="15%">Lokasi</th>
                                            <th width="15%">Status</th>
                                            <th width="15%">Sebab Kelewatan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        if($status_kehadiran == '') {
                                            $details = getAnalisaKehadiranAllDetails($noic);
                                        }
                                        else {
                                            $details = getAnalisaKehadiranDetails($noic,$status_kehadiran);
                                        }
                                        $i=1;
                                        while($kehadiran_details = $details->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?echo $i++;?></td>
                                                <td><?echo $kehadiran_details['hari_masuk'];?></td>
                                                <td>
                                                    <label class="control-label">Masuk :</label>&nbsp;
                                                    <?echo $kehadiran_details['masa_masuk'];?>
                                                    <br><label class="control-label">Keluar :</label>&nbsp;
                                                    <?echo $kehadiran_details['masa_keluar'];?>
                                                </td>
                                                <td>
                                                    <label class="control-label">Masuk :</label>&nbsp;
                                                    <?echo $kehadiran_details['device_masuk'];?>
                                                    <br><label class="control-label">Keluar :</label>&nbsp;
                                                    <?echo $kehadiran_details['device_keluar'];?>

                                                </td>

                                                <td>
                                                    <label class="control-label">Masuk :</label>&nbsp;
                                                    <?echo $kehadiran_details['remark_masuk'];?>
                                                    <br><label class="control-label">Keluar :</label>&nbsp;
                                                    <?echo $kehadiran_details['remark_keluar'];?>

                                                </td>
                                                <td>
                                                    <?echo '<b>'.'<font color="blue">'.$kehadiran_details['bil_jam_bekerja'].'</font></b>';?>
                                                    <br>
                                                    <?
                                                    if($kehadiran_details['status_kehadiran'] == 'AWAL') {
                                                        echo '<b>'.'<font color = "green">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>';
                                                    }
                                                    else if($kehadiran_details['status_kehadiran'] == 'TEPAT') {
                                                        echo '<b>'.'<font color = "purple">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>';
                                                    }
                                                    else {
                                                        echo '<b>'.'<font color = "red">'.$kehadiran_details['status_kehadiran'].'</font>'.'</b>';
                                                    }
                                                    ?>

                                                </td>
                                                <td><?echo $kehadiran_details['sebab_kelewatan'];?></td>
                                            </tr>
                                        <?}?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <?}?>
                    <div id="kehadiran_details"></div>


                </div>
            <?}?>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


    function reloadStaff(noic){
        //console.log(obj);
        location.href = "analisa_kehadiran_jabatan.php?noic="+noic;
    }
    function getAnalisaKehadiranDetails(status_kehadiran){
        //alert(status_kehadiran);
        $.ajax({
            type: "POST",
            url: "analisa_kehadiran_peribadi_details.php",
            data: {noic:"<?echo $noic;?>",status_kehadiran:status_kehadiran},
            success: function (data) {
                $('#kehadiran_details').html(data);
                $('#kehadiran_details_all').hide();
                // you will get response from your php page (what you echo or print)

            }

        });
    }

    function getAnalisaKehadiranAllDetails(){
        //alert(status_kehadiran);
        $.ajax({
            type: "POST",
            url: "analisa_kehadiran_peribadi_details.php",
            data: {noic:"<?echo $noic;?>"},
            success: function (data) {
                $('#kehadiran_details').html(data);
                $('#kehadiran_details_all').hide();
                // you will get response from your php page (what you echo or print)

            }

        });
    }


</script>

</body>
</html>
