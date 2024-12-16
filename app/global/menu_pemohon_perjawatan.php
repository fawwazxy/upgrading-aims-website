<?


?>



<div id='cssmenu'>
	<ul>
		<!--<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>">
		<a href="<? echo ($act=='update'?'pemohon_update.php?pemohon_id='.$pemohon_id.'&act='.$act:'permohonan_baru.php?pemohon_id='.$pemohon_id.'&act='.$act) ?>">Maklumat Peribadi</a></li>-->
		
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="permohonan_perjawatan.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Peribadi</a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="permohonan_perjawatan_pendidikan.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Pendidikan</a></li>
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="permohonan_perjawatan_pengalaman.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Pekerjaan Terdahulu</a></li>
		
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="permohonan_perjawatan_kemahiran.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Kemahiran</a></li>
		
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="permohonan_perjawatan_keluarga.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Maklumat Keluarga</a></li>

	   <li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="permohonan_perjawatan_resume_cv.php?pemohon_id=<? echo $pemohon_id ?>&act=<? echo $act ?>">Lampiran</a></li>
	</ul>
	</ul>
</div>