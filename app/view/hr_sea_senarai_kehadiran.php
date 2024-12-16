<?php
include ('../controller/auth.php');
require "../model/kehadiran_functions.php";
require "../model/lookup.php";

$flag = $_GET['flg'] ?: 'tb_1';
$selected_date = $_GET['dt'] ?: date('Y-m-d');
$cawangan_kod = $_GET['cawangan_kod'] ?: $_SESSION['SESS_CAWANGAN'];
$jabatan_kod = $_GET['jabatan_kod'] ?: 'AGSHIMSB';

function dateDifference($date_1 , $date_2 , $differenceFormat)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}
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
        <?
        $flagScreen="tab_1";
        include ('../global/menu_kehadiran.php');
        ?>
        <div class="row" style="margin: 8px 0">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary" onClick="popitup('senarai_kehadiran_today.php','Paparan Kehadiran')">Pemantauan</button>
                <button class="btn btn-primary" onClick="popitup('pemantauan_kehadiran_semasa_keseluruhan.php','Paparan Kehadiran')">Pemantauan Mengikut Jabatan</button>
                <button class="btn btn-primary" onClick="popitup('pemantauan_kehadiran_semasa_keseluruhan_lokasi.php','Paparan Kehadiran')">Pemantauan Mengikut Lokasi</button>
            </div>
        </div>

        <div class="row" style="margin: 4px 0">
            <form action="" method="get">
                <input type="hidden" name="flg" value="<? echo $flag ?>">
                <div class="col-md-3">
                    <select  required class="form-control" name="cawangan_kod" id="cawangan_kod">
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select  required class="form-control" name="jabatan_kod" id="jabatan_kod">
                        <? echo getHRSeaCompany($jabatan_kod);?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="dt" id="dt" class="form-control" value="<? echo $selected_date ?>"
                           max="<? echo date('Y-m-d') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block font-weight-bold">Cari &nbsp;<i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row" style="margin: 8px 0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Senarai Kehadiran</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="panel_imbasan_masuk.php" class="btn btn-primary" target="_blank">Panel Imbas Masuk</a>
                                <a href="panel_imbasan_keluar.php" class="btn btn-primary" target="_blank">Panel Imbas Keluar</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Nama</th>
                                <th>Tarikh & Masa</th>
                                <th>Platform</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getKehadiran($selected_date,$cawangan_kod,$jabatan_kod);
                            while($row_data = $data->fetch_assoc()) {
                                $beza = $row_data['beza'];
                                $total = $row_data['total'];
                                $belum_kira = getTotalJamBekerjaStafSemasa($row_data['nokp_staff']);
                                $total_masa = getJumlahMasaBezaBekerja($row_data['nokp_staff'],$selected_date,$belum_kira)->fetch_assoc();

                                if($total == ""){
                                    $total = $belum_kira;
                                }else{
                                    $total = $total_masa['total_masa_bekerja'];
                                    $beza = $total_masa['total_beza'];
                                    $jam_bekerja_semasa = $total_masa['total_bekerja_semasa'];
                                }

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?>
                                        <br><b>(<?php echo $row_data['nokp_staff']; ?>)</b>
                                    </td>
                                    <td>
                                        <label class="control-label">Masuk :</label>&nbsp;<?php echo $row_data['masa_masuk']; ?>
                                        <br><label class="control-label">Keluar :</label>&nbsp;<?php echo $row_data['masa_keluar']; ?>
                                        <br><label class="control-label">Baki Beza Masa : </label><?
                                        if($beza>'00:00:00'){?>
                                            <b><font style="color:blue;"><?php echo $beza; ?></font></b>
                                        <?}
                                        else {?>
                                            <b><font style="color:red;"><?php echo $beza; ?></font></b>
                                        <?}?>
                                        <br><label class="control-label">Jum. Jam Bekerja : </label>
                                        <?if($total>'08:00:00'){?>
                                            <b><font style="color:blue;"><?php echo $total;?></font></b>
                                        <?}else{?>
                                            <b><font style="color:red;"><?php echo $total;?></font></b>
                                        <?}

                                        if($selected_date == date('Y-m-d') && $total != "" && $belum_kira!="0"){ ?>
                                            <br><label class="control-label">Jum. Jam Terkini : </label>
                                            <b style="color: <? echo $jam_bekerja_semasa > '08:00:00' ? 'blue' : 'red' ?>">
                                                <?php echo $jam_bekerja_semasa;?>
                                            </b>
                                            <br><label class="control-label">Jum. Jam Belum Kira : </label><?php echo $belum_kira;?>
                                        <? } ?>
                                    </td>
                                    <td>
                                        <label class="control-label">Masuk :</label>&nbsp;<?php echo $row_data['device_masuk']; ?>
                                        <br><label class="control-label">Keluar :</label>&nbsp;<?php echo $row_data['device_keluar']; ?>
                                    </td>
                                    <td>
                                        <label class="control-label">Masuk :</label>
                                        <strong style="color: <? echo $row_data['remark_masuk']=="LUAR KAWASAN" ? 'red' : 'blue' ?>">
                                            <?php echo $row_data['remark_masuk']; ?></strong>

                                        <br><label class="control-label">Keluar :</label>
                                        <strong style="color: <? echo $row_data['remark_keluar']=="LUAR KAWASAN" ? 'red' : 'blue' ?>">
                                            <?php echo $row_data['remark_keluar']; ?></strong>
                                    </td>
                                    <td>
                                        <? $status_color = $row_data['status_kehadiran']=="LEWAT" ? 'red'
                                            : $row_data['status_kehadiran']=="AWAL" ? 'green' : 'purple'; ?>
                                        <strong style="color: <? echo $status_color ?>"><?php echo $row_data['status_kehadiran']; ?></strong>
                                    </td>
                                    <td>
                                        <a href="../view/report_kehadiran_hari.php?dateSelection=<? echo $selected_date; ?>&noic=<? echo $row_data['nokp_staff']; ?>&sys_id=<? echo $sys['sys_id']; ?>" target="_blank"><button class="btn btn-info" type="button" >Laporan Kehadiran</button></a>
                                        <a><button class="btn btn-info" onclick="return popitup('../view/pinned_map.php?lokasi=<? echo $row_data['lokasi_masuk'];?>&id=<? echo $row_data['id']?>')">Papar Peta</button></a>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
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
    function popitup(url) {
        const newWindow = window.open(url, 'name', 'height=595,width=842');
        if (window.focus) {
            newWindow.focus()
        }
        return false;
    }
</script>
</body>
</html>