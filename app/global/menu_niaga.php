<?


?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">UrusNiaga-Jualan</h1>
			</div>
			<?
			    $data_bayaran= getJumlahBayaran()->fetch_assoc();
			    $data_bayarantunai= getJumlahBayaranTunai()->fetch_assoc();
			    $jumlahbayaran = number_format($data_bayaran["jumlahbayaran"], 2, '.', ',');
			    $jumlahbayarantunai = number_format($data_bayarantunai["jumlahbayarantunai"], 2, '.', ',');
			    
			    $data_bayaranterima= getJumlahBayaranTerima()->fetch_assoc();
			    $jumlahbayaranterima = number_format($data_bayaranterima["jumlahbayaranterima"], 2, '.', ',');
			    $totalbayaran = $data_bayaran["jumlahbayaran"]+$data_bayarantunai["jumlahbayarantunai"];
			    $bayaranbelumterima = $data_bayaran["jumlahbayaran"]-$data_bayaranterima["jumlahbayaranterima"];
			    
			    //echo number_format($bayaranbelumterima, 2, '.', ',');
									
			?>
			<div align="center">
				<h3>Jum. Jualan : <b>RM<?php echo number_format($totalbayaran, 2, '.', ','); ?></b>&nbsp;&nbsp;&nbsp;Bayaran Belum Terima : <b>RM<?php echo number_format($bayaranbelumterima, 2, '.', ','); ?></b></h3><br>
			</div>
        </div>

<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_0'?'active':'') ?>"><a href="niaga_reqsebut_harga.php">Permohonan Sebutharga</a></li>
		<li class="<? echo ($flagScreen=='tab_7'?'active':'') ?>"><a href="niaga_bil_tunai.php">Bil Tunai</a></li>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="niaga_sebut_harga.php">Sebutharga</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="niaga_pesanan_belian_list.php">Pesanan Jualan (S.O)</a></l>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="niaga_inbois.php">Inbois</a></l>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="niaga_bayaran.php">Resit Bayaran</a></l>
		<!--<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="senarai_lead_sebutharga.php">Senarai Pelanggan</a></l>-->
		<li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="#">Laporan</a></l>
	</ul>
</div>