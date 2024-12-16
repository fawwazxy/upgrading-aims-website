<?


?>

<div class="row" align="center">
		<div class="col-lg-12">
			<h1 class="page-header">Borang Permohonan Latihan Industri</h1>
		</div>
</div>

<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>">
		<a href="<? echo ($act=='update'?'intern_mohon.php?pemohon_id='.$pemohon_id.'&act='.$act:'intern_mohon.php?pemohon_id='.$pemohon_id.'&act='.$act) ?>">Maklumat Peribadi</a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="intern_ed.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Pendidikan</a></li>
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="intern_exp.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Pekerjaan Terdahulu</a></li>
		
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="intern_skills.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Kemahiran</a></li>
		
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="intern_fmly.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Keluarga</a></li>
		
		<li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="intern_lampiran.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Lampiran</a></li>

	</ul>
</div>