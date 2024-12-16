<?php

include ('../controller/auth.php');

require "../model/analisa_kehadiran_functions.php";
require "../model/lookup.php";
//$bulan = date('m');
//$hariini = date('d');
$kod_cawangan = $_GET['kod_cawangan'];
$department_id = $_GET['department_id'];
$noic = $_GET['noic'];
$data_cawangan = getCawanganByKod($kod_cawangan)->fetch_assoc();
$staff_details = getStaffDetailsByNokp($noic)->fetch_assoc();
/*
if($kod_cawangan==''){
	$kod_cawangan = $_SESSION['SESS_CAWANGAN'];
}else{
	$kod_cawangan = $_GET['kod_cawangan'];
}
*/
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
                <h1 class="page-header">Analisa Kehadiran Keseluruhan</h1>
            </div>
            <div class="form-group" align="left">
                <div class="col-xs-4">
                    <select required class="form-control" id="kod_cawangan" name="kod_cawangan" value="<?echo $kod_cawangan?>">
                        <option value="">-- Pilih Lokasi--</option>
                        <?echo getDropDown("lkp_cawangan","cawangan_kod","nama",$kod_cawangan);?>
                    </select>
                </div>

                <div class="col-xs-4">
                    <select required class="form-control" id="department_id" name="department_id" value="<?echo $department_id?>">
                        <option value="">-- Pilih Bahagian--</option>
                        <?echo getDropDownJabatan($department_id);?>
                    </select>
                </div>

                <div class="col-xs-4">
                    <select required class="form-control" id="noic" name="noic" value="<?echo $noic?>" onchange="reloadStaff(this.value)">
                        <option value="">-- Pilih Staf--</option>
                        <?echo getDropDownStaff($kod_cawangan,$department_id,$noic);?>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <?if($noic ==''){?>
                <div class="col-lg-12">
                    <!-- <div class="panel panel-red"> -->
                    <!-- /.panel-heading -->
                    <!-- <div class="panel-heading">
								<center><b>Analisa Kehadiran Staf</b></center>
							</div>
							<table width="100%" class="table  table-bordered">

								<thead>
									<th bgcolor="#D6DBDF" width="17%"><center>Jumlah Staf</center></th>
									<th bgcolor="#D6DBDF" width="17%"><center>Bil. Hadir</center></th>
									<th bgcolor="#D6DBDF" width="17%"><center>Awal</center></th>
									<th bgcolor="#D6DBDF" width="17%"><center>Tepat</center></th>
									<th bgcolor="#D6DBDF" width="17%"><center>Lewat</center></th>
									<th bgcolor="#D6DBDF" width="17%"><center>Peratusan Kehadiran</center></th>
						            
						       </thead>
						       <? $kehadiran = getBilStafHadir($kod_cawangan,$department_id)->fetch_assoc();
                    if($kehadiran['bil_staff']!=0 && $kehadiran['bil_hadir']!=0){
                        $peratusan = ($kehadiran['bil_hadir']/$kehadiran['bil_staff'])*100;

                    }else{
                        $peratusan='0.00';

                    }
                    ?>
								<tbody>
									<td align="center"><strong><font size="6" color="black"><? echo $kehadiran['bil_staff'];?></font></strong></td>
									<td align="center"><strong><font size="6" color="blue"><? echo  $kehadiran['bil_hadir'];?></font></strong></td>
									<td align="center"><strong><font size="6" color="green"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'AWAL');?></font></strong>
									</td>
									<td align="center"><strong><font size="6" color="purple"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'TEPAT');?></font></strong></td>
									<td align="center"><strong><font size="6" color="red"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'LEWAT');?></font></strong></td>
									<td align="center"><strong><font size="6" color="brown"><? echo round($peratusan,2);?>%</font></strong>
									</td>
								</tbody>
							</table>
						</div> -->

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
                            $kehadiran = getBilStafHadir($kod_cawangan,$department_id)->fetch_assoc();
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
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><?echo getBilStafTidakHadir($kod_cawangan,$department_id);?></font></strong></td>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><?echo getCountCuti($kod_cawangan,$department_id);?></font></strong></td>
                                <th width="10%" bgcolor="#E8E8E8"><center>Awal</center></th>
                                <th width="10%" bgcolor="#E8E8E8"><center>Tepat</center></th>
                                <th width="10%" bgcolor="#E8E8E8"><center>Lewat</center></th>
                                <td align="center" rowspan="3" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="7" color="brown"><? echo round($peratusan,2);?>%</font></strong></td>
                            </tr>
                            <tr>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="green"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'AWAL');?></font></strong>
                                </td>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="purple"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'TEPAT');?></font></strong>
                                </td>
                                <td rowspan="2" bgcolor="#FDFEFE" align="center">
                                    <strong><font size="6" color="red"><?echo getBilKehadiranStatus($kod_cawangan,$department_id,'LEWAT');?></font></strong>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?}?>
            <?if($kod_cawangan =='' && $department_id=='' && $noic == ''){?>
            <div class="col-lg-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><b>Analisa Kehadiran Keseluruhan</b></center>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th bgcolor="#D6DBDF" width="5%">Bil.</th>
                            <th bgcolor="#D6DBDF" width="13%">Nama Lokasi</th>
                            <th bgcolor="#D6DBDF" width="12%"><center>Jumlah Staf</center></th>
                            <th bgcolor="#D6DBDF" width="12%"><center>Bil. Hadir</center></th>
                            <th bgcolor="#D6DBDF" width="12%"><center>Bil. Tidak Hadir</center></th>
                            <th bgcolor="#D6DBDF" width="12%"><center>Bil. Bercuti</center></th>
                            <th bgcolor="#D6DBDF" width="7%"><center>Awal</center></th>
                            <th bgcolor="#D6DBDF" width="7%"><center>Tepat</center></th>
                            <th bgcolor="#D6DBDF" width="7%"><center>Lewat</center></th>
                            <th bgcolor="#D6DBDF" width="18%"><center>Peratusan Kehadiran</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $data_semua = analisaKehadiranSemuaCawangan();
                        $i=1;
                        while($list_semua = $data_semua->fetch_assoc()) {
                            $bil_awal = analisaKehadiranCawangan($list_semua['cawangan_kod'],'AWAL');
                            $bil_tepat = analisaKehadiranCawangan($list_semua['cawangan_kod'],'TEPAT');
                            $bil_lewat = analisaKehadiranCawangan($list_semua['cawangan_kod'],'LEWAT');
                            $bil_total = $bil_awal+$bil_tepat+$bil_lewat;
                            ?>
                            <tr>
                            <tr>
                                <td bgcolor="#FDFEFE"><?echo $i++;?>.</td>
                                <td bgcolor="#FDFEFE"><?echo $list_semua['nama']?></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="black"><?echo $list_semua['bil_staff']?></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="blue"><?echo $list_semua['bil_kehadiran'];?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo getBilStafTidakHadir($list_semua['cawangan_kod'],'');?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="orange"><?echo getCountCuti($list_semua['cawangan_kod'],'');?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><!-- <font bgcolor="#FDFEFE">Awal</font><br> --><font size="5" color="green"><?echo $bil_awal;?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="purple"><?echo $bil_tepat;?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo $bil_lewat;?></font></b></center></td>
                                <td bgcolor="#FDFEFE"><center><b><font size="5" color="brown">
                                                <?if($list_semua['bil_kehadiran']!=0 && $list_semua['bil_staff']!=0)
                                                {$percentage = ($list_semua['bil_kehadiran']/$list_semua['bil_staff'])*100;
                                                    echo number_format($percentage,2);}
                                                else{echo '0';}?>%</font></b></center></td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>
                </div>

                <?}else if($kod_cawangan !='' && $department_id =='' && $noic==''){?>
                    <div class="col-lg-12">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <center><b>Analisa Kehadiran Lokasi <?echo $data_cawangan['nama'];?></b></center>
                            </div>
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th bgcolor="#D6DBDF" width="5%">Bil.</th>
                                    <th bgcolor="#D6DBDF" width="13%">Nama Bahagian</th>
                                    <th bgcolor="#D6DBDF" width="12%"><center>Jumlah Staf</center></th>
                                    <th bgcolor="#D6DBDF" width="12%"><center>Bil. Hadir</center></th>
                                    <th bgcolor="#D6DBDF" width="12%"><center>Bil. Tidak Hadir</center></th>
                                    <th bgcolor="#D6DBDF" width="12%"><center>Bil. Bercuti</center></th>
                                    <th bgcolor="#D6DBDF" width="7%"><center>Awal</center></th>
                                    <th bgcolor="#D6DBDF" width="7%"><center>Tepat</center></th>
                                    <th bgcolor="#D6DBDF" width="7%"><center>Lewat</center></th>
                                    <th bgcolor="#D6DBDF" width="18%"><center>Peratusan Kehadiran</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $data_jabatan = analisaKehadiranJabatanByKod($kod_cawangan);
                                $i=1;

                                while($list_jabatan = $data_jabatan->fetch_assoc()) {
                                    $working=workdays($date_month,$date_year,$list_jabatan['no_staff']);
                                    $awal = analisaKehadiranStaffCawangan($kod_cawangan,$list_jabatan['code_department'],'AWAL');
                                    $tepat = analisaKehadiranStaffCawangan($kod_cawangan,$list_jabatan['code_department'],'TEPAT');
                                    $lewat = analisaKehadiranStaffCawangan($kod_cawangan,$list_jabatan['code_department'],'LEWAT');
                                    $jum = $awal + $tepat + $lewat;
                                    ?>
                                    <tr>
                                        <td bgcolor="#FDFEFE"><?echo $i++;?>.</td>
                                        <td bgcolor="#FDFEFE"><?echo $list_jabatan['description']?></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="black"><?echo $list_jabatan['bil_staff']; ?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="blue"><?echo $jum?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo getBilStafTidakHadir($kod_cawangan,$list_jabatan['code_department']);?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="orange"><?echo getCountCuti($kod_cawangan,$list_jabatan['code_department']);?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="green"><?echo $awal;?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="purple"><?echo $tepat;?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo $lewat;?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="brown"><? $percent = ($jum/$working)*100; echo number_format($percent,2);?>%</font></b></center></td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?}else if($kod_cawangan !='' && $department_id !='' && $noic==''){?>
                    <div class="col-lg-12">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <center><b>Analisa Kehadiran Lokasi <?echo $data_cawangan['nama'];?></b></center>
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
                                $data_caw = analisaKehadiranCawanganJabatan($kod_cawangan,$department_id);
                                $i=1;
                                while($list_caw = $data_caw->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td bgcolor="#FDFEFE"><?echo $i++;?>.</td>
                                        <td bgcolor="#FDFEFE"><?echo $list_caw['name']?></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="black"><?echo $working=workdays($date_month,$date_year,$list_caw['no_staff'])?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="blue"><?echo $list_caw['bil_kehadiran']?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="green"><?echo analisaKehadiranStaffJabatan($kod_cawangan,$department_id,$list_caw['noic'],'AWAL');?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="purple"><?echo analisaKehadiranStaffJabatan($kod_cawangan,$department_id,$list_caw['noic'],'TEPAT');?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="red"><?echo analisaKehadiranStaffJabatan($kod_cawangan,$department_id,$list_caw['noic'],'LEWAT');?></font></b></center></td>
                                        <td bgcolor="#FDFEFE"><center><b><font size="5" color="brown"><? $percent = ($list_caw['bil_kehadiran']/$working)*100; echo number_format($percent,2);?>%</font></b></center></td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?}else if($kod_cawangan !='' && $department_id !='' && $noic!=''){?>
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
                                $jumlah_hari_bekerja = getAnalisaJumlahHariBekerja($noic,$staff_details['no_staff']);
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
                                                    <!-- <td>
                                            <label class="control-label">Masuk :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_masuk']);?>
                                            <br><label class="control-label">Keluar :</label>&nbsp;
                                            <br><?echo getLokasiKehadiran($kehadiran_details['lokasi_keluar']);?>
                                                
                                        </td> -->
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
        </div>

        <? include ('../global/footer.php'); ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });


        function reloadStaff(noic){
            //console.log(obj);
            location.href = "analisa_kehadiran_keseluruhan.php?kod_cawangan=<?echo $kod_cawangan?>&department_id=<?echo $department_id?>&noic="+noic;
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

        $(document).ready(function() {
            $("#kod_cawangan").change(function(){

                var selected_cawangan=$(this).val();
                reloadCawangan(selected_cawangan);
            });

            $("#department_id").change(function(){
                if($("#kod_cawangan").val()==''){
                    alert('SILA PILIH LOKASI DAHULU!');
                    $("#department_id").val('');
                }else{
                    var selected_jabatan=$(this).val();
                    var cawangan = $("#kod_cawangan").val();
                    reloadDepartment(selected_jabatan,cawangan);

                }
            });

        });

        function reloadCawangan(cawangan){
            //console.log(cawangan);
            location.href = "analisa_kehadiran_keseluruhan.php?kod_cawangan="+cawangan;
        }
        function reloadDepartment(department,cawangan){
            //console.log(obj);
            location.href = "analisa_kehadiran_keseluruhan.php?kod_cawangan="+cawangan+"&department_id="+department;
        }

    </script>

</body>
</html>
