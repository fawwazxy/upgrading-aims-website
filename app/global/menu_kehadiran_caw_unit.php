<?
function weeks($month, $year){
        $firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
        $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
        return $count_weeks;
} 
 //date_default_timezone_set("Asia/Kuala_lumpur");
	$date = new DateTime();
	$current_date=$date->format('d-m-Y');
    $crt_dt = date_format($date,"D d-F-Y");
	$month = date_format($date,"F Y");
    $bulan = date_format($date,"m");
	$tahun = date_format($date,"Y");
	
	$week=weeks($bulan,$tahun);
	
?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pengurusan Kehadiran</h1>
			</div>
        </div>

<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="senarai_kehadiran_caw_unit.php?dt=<? echo $current_date;?>&flg=<? echo tb_1; ?>">Kehadiran Terkini</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="senarai_keseluruhan_kehadiran_caw_unit.php?mnt=<? echo $bulan;?>&yr=<? echo $tahun;?>&flg=<? echo tb_1; ?>">Laporan Kehadiran</a></li>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="log_kehadiran.php" target="_blank">Terminal Kehadiran Manual</a></li>
	</ul>
</div>