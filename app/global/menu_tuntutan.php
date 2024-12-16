<?


?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pengurusan Data Rujukan</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		<!--<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>">
		<a href="<? echo ($act=='update'?'pemohon_update.php?pemohon_id='.$pemohon_id.'&act='.$act:'permohonan_baru.php?pemohon_id='.$pemohon_id.'&act='.$act) ?>">Tuntutan Jarak / Kenderaan</a></li>-->
		
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="jenis_tuntutan.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>">Jenis Tuntutan</a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="tambah_tuntutan_jarak.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Tuntutan Jarak/Kenderaan</a></li>
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="pelulus_tuntutan.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Pelulus Tuntutan</a></li>

		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="tarikh_tuntutan.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Tarikh Tuntutan</a></li>
		
		<!--<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="pmohon_fmly.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Keluarga</a></li>-->
	</ul>
</div>