<?  
	$date = new DateTime();
	$date->modify('first day of this month');
	
	
	date_sub($date,date_interval_create_from_date_string("1 months"));
	$month1 = date_format($date,"F Y");
	$bulan1 = date_format($date,"m");
	$tahun1 = date_format($date,"Y");
	
  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month2 = date_format($date,"F Y");
	  $bulan2 = date_format($date,"m");
	  $tahun2 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month3 = date_format($date,"F Y");
	  $bulan3 = date_format($date,"m");
	  $tahun3 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month4 = date_format($date,"F Y");
	  $bulan4 = date_format($date,"m");
	  $tahun4 = date_format($date,"Y");	
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month5 = date_format($date,"F Y");
	  $bulan5 = date_format($date,"m");
	  $tahun5 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month6 = date_format($date,"F Y");
	  $bulan6 = date_format($date,"m");
	  $tahun6 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month7 = date_format($date,"F Y");
	  $bulan7 = date_format($date,"m");
	  $tahun7 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month8 = date_format($date,"F Y");
	  $bulan8 = date_format($date,"m");
	  $tahun8 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month9 = date_format($date,"F Y");
	  $bulan9 = date_format($date,"m");
	  $tahun9 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month10 = date_format($date,"F Y");
	  $bulan10 = date_format($date,"m");
	  $tahun10 = date_format($date,"Y");
	  
	  date_sub($date,date_interval_create_from_date_string("1 months"));
	  $month11 = date_format($date,"F Y");
	  $bulan11 = date_format($date,"m");
	  $tahun11 = date_format($date,"Y");
	  
	  
	  

?>


<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flag=='tb_1'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan;?>&yr=<? echo $tahun;?>&flg=<? echo tb_1 ;?>"><? echo $month;?></a></li>
		<li class="<? echo ($flag=='tb_2'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan1;?>&yr=<? echo $tahun1;?>&flg=<? echo tb_2 ;?>"><? echo $month1;?></a></li>
		<li class="<? echo ($flag=='tb_3'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan2;?>&yr=<? echo $tahun2;?>&flg=<? echo tb_3 ;?>"><? echo $month2;?></a></li>
		<li class="<? echo ($flag=='tb_4'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan3;?>&yr=<? echo $tahun3;?>&flg=<? echo tb_4 ;?>"><? echo $month3;?></a></li>
		<li class="<? echo ($flag=='tb_5'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan4;?>&yr=<? echo $tahun4;?>&flg=<? echo tb_5 ;?>"><? echo $month4;?></a></li>
		<li class="<? echo ($flag=='tb_6'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan5;?>&yr=<? echo $tahun5;?>&flg=<? echo tb_6 ;?>"><? echo $month5;?></a></li>
		<li class="<? echo ($flag=='tb_7'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan6;?>&yr=<? echo $tahun6;?>&flg=<? echo tb_7 ;?>"><? echo $month6;?></a></li>
		<li class="<? echo ($flag=='tb_8'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan7;?>&yr=<? echo $tahun7;?>&flg=<? echo tb_8 ;?>"><? echo $month7;?></a></li>
		<li class="<? echo ($flag=='tb_9'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan8;?>&yr=<? echo $tahun8;?>&flg=<? echo tb_9 ;?>"><? echo $month8;?></a></li>
		<li class="<? echo ($flag=='tb_10'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan9;?>&yr=<? echo $tahun9;?>&flg=<? echo tb_10 ;?>"><? echo $month9;?></a></li>
		<li class="<? echo ($flag=='tb_11'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan10;?>&yr=<? echo $tahun10;?>&flg=<? echo tb_11 ;?>"><? echo $month10;?></a></li>
		<li class="<? echo ($flag=='tb_12'?'active':'') ?>"><a href="aims2_critical_list.php?mnt=<? echo $bulan11;?>&yr=<? echo $tahun11;?>&flg=<? echo tb_12 ;?>"><? echo $month11;?></a></li>
		
		
	</ul>
</div>