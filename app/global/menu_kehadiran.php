<?
function weeks($month, $year){
    $firstday = date("w", mktime(0, 0, 0, $month, 1, $year));
    $lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
    $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
    return $count_weeks;
}
$date = new DateTime();
$current_date = date('d-m-Y');
$crt_dt = date("D d-F-Y");
$month = date("F Y");
$bulan = date("m");
$tahun = date("Y");

$week = weeks($bulan,$tahun);

?>
<div class="row" style="margin: 8px 0 0">
    <div class="col-lg-12">
        <h1 class="page-header">Pengurusan Kehadiran</h1>
    </div>
</div>

<div id='cssmenu'>
    <ul>
        <? if(in_array($_SESSION['SESS_ROLE'], ["ADMIN", "SUPERADMIN"]) || $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
            <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="../view/senarai_kehadiran.php?dt=<? echo $current_date;?>&flg=<? echo 'tb_1'; ?>">Kehadiran Terkini</a></li>
            <!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
            <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="../view/senarai_keseluruhan_kehadiran.php?mnt=<? echo $bulan;?>&yr=<? echo $tahun;?>&flg=<? echo 'tb_1'; ?>">Laporan Kehadiran</a></li>
        <? } else { ?>
            <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="../view/hr_sea_senarai_kehadiran.php?dt=<? echo $current_date;?>&flg=<? echo 'tb_1'; ?>">Kehadiran Terkini</a></li>
            <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="../view/hr_sea_senarai_keseluruhan_kehadiran.php?mnt=<? echo $bulan;?>&yr=<? echo $tahun;?>&flg=<? echo 'tb_1'; ?>">Laporan Kehadiran</a></li>
        <? } ?>
        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="../view/log_kehadiran.php" target="_blank">Terminal Kehadiran Manual</a></li>
        <? if(in_array($_SESSION['SESS_ROLE'], ["ADMIN", "SUPERADMIN"])){ ?>
            <li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="../view/masa_mula_bekerja.php">Masa Mula Bekerja</a></li>
            <li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="../view/hari_cuti.php">Hari Cuti</a></li>
            <li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="../view/lokasi_kehadiran.php">Lokasi Kehadiran</a></li>
        <? } ?>

    </ul>
</div>