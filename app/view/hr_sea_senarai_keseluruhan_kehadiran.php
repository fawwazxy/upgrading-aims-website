<?php
include ('../controller/auth.php');
require "../model/kehadiran_functions.php";
require "../model/lookup.php";

$current_year = date('Y');
$bln = $_GET['mnt'] ?: date('m');
$thn = $_GET['yr'] ?: $current_year;
$cawangan_kod=$_GET['cawangan_kod'] ?: $_SESSION['SESS_CAWANGAN'];
$jabatan_kod=$_GET['jabatan_kod'] ?: 'AGSHIMSB';
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
    <script type="text/javascript">
        function popitup(url) {
            const newWindow = window.open(url, 'name', 'height=595,width=842');
            if (window.focus) {newWindow.focus()}
            return false;
        }
    </script>
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
        $flagScreen="tab_2";
        include ('../global/menu_kehadiran.php');
        ?>

        <div class="row" style="margin: 8px 0">
            <form action="" method="get">
                <div class="col-md-2">
                    <select required class="form-control" name="cawangan_kod" id="cawangan_kod">
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select required class="form-control" name="jabatan_kod" id="jabatan_kod">
                        <? echo getHRSeaCompany($jabatan_kod);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="mnt" id="mnt">
                        <? foreach (getMonthArray() as $index => $name){ ?>
                            <option value="<? echo $index ?>" <? echo ($index == $bln) ? 'selected' : '' ?>>
                                <? echo $name ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="yr" id="yr">
                        <? for($i=0; $i<5; $i++){
                            $option_year = $current_year - $i;?>
                            <option value="<? echo $option_year ?>" <? echo ($option_year == $thn) ? 'selected' : ''; ?>>
                                <? echo $option_year ?>
                            </option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block font-weight-bold">Cari &nbsp;<i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Keseluruhan Kehadiran
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Status Kehadiran</th>
                                <th>Jum. Jam Masa Bekerja</th>
                                <th>Jum. Baki Beza Masa</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;

                            $data = getKeseluruhanKehadiran($bln,$thn,$cawangan_kod,$jabatan_kod);
                            while($row_data = $data->fetch_assoc()) {
                                //Count Awal, Tepat, & Lewat
                                $attendance = personalAttendanceSummary($row_data['no_staff'],$bln,$thn);

                                //Work Hour Calculation
                                $work_hour_array = workHourArray($row_data['noic'], $bln, $thn);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row_data['name']; ?><b> (<? echo $row_data['nokp_staff']; ?>)</b></td>

                                    <td>
                                        <label>Awal : </label>
                                        <b style="color: green; font-size: 16px"><?echo $attendance['AWAL'] ?: '0' ?></b> Hari
                                        <br><label>Tepat : </label>
                                        <b style="color: purple; font-size: 16px"><? echo $attendance['TEPAT'] ?: '0'?></b> Hari
                                        <br><label>Lewat : </label>
                                        <b style="color: red; font-size: 16px"><? echo $attendance['LEWAT'] ?: '0'?></b> Hari
                                    </td>

                                    <td><?php echo $work_hour_array['sum']; ?></td>
                                    <td><?php echo $work_hour_array['difference']; ?></td>
                                    <td>
                                        <a href="../view/senarai_kehadiran_by_staff.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&name=<?php echo $row_data['name']; ?>&noic=<? echo $row_data['nokp_staff']; ?>"
                                           class="btn btn-info">Keseluruhan</a>
                                        <a href="../view/report_kehadiran_bulan.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data['no_staff']; ?>"
                                           class="btn btn-info" target="_blank">Laporan Keseluruhan</a>
                                        <a href="../view/electronic_time_card.php?mnt=<? echo $bln?>&thn=<? echo $thn?>&noic=<? echo $row_data['no_staff']; ?>"
                                           class="btn btn-success" target="_blank">Electronic Time Card</a>
                                    </td>
                                </tr>
                            <? } ?>
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
</script>
</body>
</html>