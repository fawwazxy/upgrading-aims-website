<?

$nama_projek=$_GET['nama_projek'];
?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Senarai Sokongan</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
	

		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="support_all.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&nama_projek=<? echo $_GET['nama_projek']?>">Aduan Baharu
      </a></li>
<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="support_belum_selesai.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&nama_projek=<? echo $_GET['nama_projek']?>">Aduan Belum Selesai


		</a></li>

<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="developer_support_semakan_terakhir.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&nama_projek=<? echo $_GET['nama_projek']?>">Aduan Semakan Terakhir


		</a></li>
<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="developer_support_selesai.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&nama_projek=<? echo $_GET['nama_projek']?>">Aduan Selesai


		</a></li>

		
		




	</ul>
</div>