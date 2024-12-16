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
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="aims_critical_list.php"> Aishah Aims 1</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="aims2_critical_list.php">Aishah Aims 2</a></li>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="aims3_critical_list.php"> Aishah Aims 3</a></li>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="aims4_critical_list.php">Aishah Aims 4</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="aims5_critical_list.php">Aishah Aims 5</a></li>
	</ul>
</div>