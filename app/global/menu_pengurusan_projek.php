<?


?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pengurusan Projek</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
		
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Tugasan </a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="projek_list.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Tugasan Dalam Pelaksanaan</a></li>
		

		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="senarai_projek_yang_telah_selesai.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Tugasan Yang Sudah Selesai</a></li>
		
		
		
	</ul>
</div>