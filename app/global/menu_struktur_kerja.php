<?
$id=$_GET['id'];

?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pengurusan Pasukan Kerja</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
		
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="struktur_kerja.php?id=<? echo $_GET['id'] ?>">Struktur Kerja </a></li>
		
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="senarai_ahli_projek.php?id=<? echo $_GET['id']; ?>">Pemilihan Ahli</a></li>
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="ahli_kumpulan_add.php?id=<? echo $_GET['id']; ?>">Tetapan Pasukan Kerja</a></li>
		
		
		
	</ul>
</div>