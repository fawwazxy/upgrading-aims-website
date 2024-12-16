<?


?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Permohonan Tuntutan</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="pohon_tuntutan_baru.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Tuntutan Lain-Lain</a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="tuntutan_perjalanan_jarak.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Tuntutan Perjalanan</a></li>
		
	</ul>
</div>