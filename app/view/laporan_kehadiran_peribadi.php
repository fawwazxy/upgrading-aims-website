<?php
include ('../controller/auth.php');
require "../model/kehadiran_functions.php";

$thn = $_GET['yr'] ?: date('Y');
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
                <h1 class="page-header">Laporan Kehadiran Peribadi</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <form action="" method="get" id="filter-form">
                    <input type="hidden" name="sys_id" value="1">
                    <select  required class="form-control" name="tahun" id="tahun">
                        <?php
                        for ($i = 0; $i <= 6; ++$i){
                            $value = date('Y') - $i;?>
                            <option value="<? echo $value?>" <? echo ($value == $thn) ? 'selected' : ''; ?>><? echo $value ?></option>
                        <? } ?>
                    </select>
                </form>

            </div>
        </div>

        <div class="row" style="margin-top: 16px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Laporan Bulan
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Status Kehadiran</th>
                                <th>Jum. Jam Masa Bekerja</th>
                                <th>jum. Baki Beza Masa</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;

                            $data = getKeseluruhanKehadiranPeribadi($_SESSION['SESS_NOKP'],$thn);
                            while($row_data = $data->fetch_assoc()) {
                                //Count Awal, Tepat, & Lewat
                                $attendance = personalAttendanceSummary($row_data['no_staff'],$row_data['month'],$thn);

                                //Work Hour Calculation
                                $work_hour_array = workHourArray($row_data['noic'], $row_data['month'], $thn);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo getMonthStringArr($row_data['month']).' '.$thn; ?></td>

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
                                        <a href="../view/report_kehadiran_bulan.php?mnt=<? echo $row_data['month']?>&thn=<? echo $thn?>&noic=<? echo $row_data['noic']; ?>"
                                           target="_blank" class="btn btn-info">Laporan Keseluruhan</a>
                                        <a href="../view/electronic_time_card.php?mnt=<? echo $row_data['month']?>&thn=<? echo $thn?>&noic=<? echo $row_data['noic']; ?>"
                                           target="_blank" class="btn btn-success">Electronic Time Card</a>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $('#tahun').on('change', function (){
            $('#filter-form').submit();
        })
    });
</script>
</body>
</html>
