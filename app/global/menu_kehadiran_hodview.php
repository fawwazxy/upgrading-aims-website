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
	
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="aims_kehadiran_list.php?mnt=<? echo $bulan;?>&yr=<? echo $tahun;?>&flg=<? echo tb_1; ?>">Laporan Kehadiran</a></li>
		
	
	</ul>
</div>

