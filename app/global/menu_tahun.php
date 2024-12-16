<?
	$date = new DateTime();
	$current_date=$date->format('d-m-Y');
    $crt_dt = date_format($date,"D d-F-Y");
	//$month = date_format($date,"F Y");
    //$bulan = date_format($date,"m");
	$tahuncurr = date_format($date,"Y");
	


	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun1 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun2 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun3 = date_format($date,"Y");
	

	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun4 = date_format($date,"Y");
	
	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun5 = date_format($date,"Y");
	

	$date->modify('first day of this year');
	date_sub($date,date_interval_create_from_date_string("1 years"));
	$tahun6 = date_format($date,"Y");
	
	
	

?>


<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagtahun=='tb_1'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahuncurr?>&flagtahun=<? echo tb_1; ?>">Tahun <? echo $tahuncurr?></a></li>

		<li class="<? echo ($flagtahun=='tb_2'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun1?>&flagtahun=<? echo tb_2; ?>">Tahun <? echo $tahun1?></a></li>

		<li class="<? echo ($flagtahun=='tb_3'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun2?>&flagtahun=<? echo tb_3; ?>">Tahun <? echo $tahun2?></a></li>

		<li class="<? echo ($flagtahun=='tb_4'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun3?>&flagtahun=<? echo tb_4; ?>">Tahun <? echo $tahun3?></a></li>

		<li class="<? echo ($flagtahun=='tb_5'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun4?>&flagtahun=<? echo tb_5; ?>">Tahun <? echo $tahun4?></a></li>

		<li class="<? echo ($flagtahun=='tb_6'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun5?>&flagtahun=<? echo tb_6; ?>">Tahun <? echo $tahun5?></a></li>

		<li class="<? echo ($flagtahun=='tb_7'?'active':'') ?>"><a href="perbelanjaan_syarikat.php?tahun=<? echo $tahun6?>&flagtahun=<? echo tb_7; ?>">Tahun <? echo $tahun6?></a></li>

		

		
	</ul>
</div>