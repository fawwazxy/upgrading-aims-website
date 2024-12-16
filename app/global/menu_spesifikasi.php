<?

        $id=$_GET['id'];


?>

<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Spesifikasi</h1>
			</div>
        </div>
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="spesifikasi_detail.php?id=<? echo $id; ?>">Maklumat Spesifikasi</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="spesifikasi_lukisan.php?id=<? echo $id; ?>">Lukisan</a></li>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="spesifikasi_dimensi.php?id=<? echo $id; ?>">Dimensi</a></li>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="spesifikasi_bahan.php?id=<? echo $id; ?>">Bahan</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="spesifikasi_jentera.php?id=<? echo $id; ?>">Jentera</a></li>
		<li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="spesifikasi_cth_gambar.php?id=<? echo $id; ?>">Contoh Gambar</a></li>
		<li class="<? echo ($flagScreen=='tab_7'?'active':'') ?>"><a href="spesifikasi_youtube.php?id=<? echo $id; ?>">Video Youtube</a></li>
	</ul>
</div>
