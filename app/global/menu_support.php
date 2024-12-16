<?

$nama_projek=$_GET['nama_projek'];
?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Aduan</h1>
				<!--<h4><b><font color="red"></? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
	
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="hr_support.php?nama_projek=<? echo $_GET['nama_projek']?>">Senarai Aduan
       </a></li>

       <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="hr_support_dalam_penerimaan.php?nama_projek=<? echo $_GET['nama_projek']?>">Senarai Aduan Dalam Penerimaan
		</a></li>


		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="hr_support_dalam_proses.php?nama_projek=<? echo $_GET['nama_projek']?>">Senarai Aduan Dalam Proses
		</a></li>

		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="hr_support_semakan_terakhir.php?nama_projek=<? echo $_GET['nama_projek']?>">Senarai Aduan Semakan Terakhir
		</a></li>


		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="hr_support_selesai.php?nama_projek=<? echo $_GET['nama_projek']?>">Senarai Aduan Yang Selesai


		</a></li> 




	</ul>
</div>