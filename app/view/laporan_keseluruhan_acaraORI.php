<?
   
	require "../model/acara_functions.php";
	date_default_timezone_set("Asia/Kuala_Lumpur");
	
	$id_sesi = $_GET['id_sesi'];
	$sys = getSys(1)->fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/favicon.ico" />
		<link href="../../js/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<title><? echo $sys['sys_name']; ?> :: <? echo $sys['sys_tagline']; ?></title>
		<style>
			#map_wrapper {
				height: 500px;
			}

			#map_canvas {
				width: 100%;
				height: 100%;
			}
		</style>
		<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}
table { page-break-inside:auto }
tr { page-break-inside:avoid; page-break-after:auto }
@media print {
tr {
    -webkit-print-color-adjust: exact; 
}}
@media print {
  #html-content-holder {
    display: none;
  }
  #btn-Preview-Image {
    display: none;
  }
}
</style>
	</head>
	<body>
		<input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
		
	<? /* Start Frontpage Cover */ ?>
	<?
	$sesi = getSesiAcaraById($id_sesi) -> fetch_assoc();
	
	?>
<center>
<br><br><br><br><br><br><br><br><br><br>
<h1>LAPORAN KESELURUHAN</h1><br>
<h3>ACARA</h3>
<h3><? echo $sesi['nama'];?></h3>
<h3>LOKASI</h3>
<h3><? echo $sesi['lokasi'];?></h3>
<h3>TARIKH MULA</h3>
<h3><? echo date("d F Y", strtotime($sesi['tarikh_mula']));?></h3>
<h3>TARIKH TAMAT</h3>
<h3><? echo date("d F Y", strtotime($sesi['tarikh_tamat']));?></h3>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</center>

<? /* End Frontpage Cover */ ?>
<p style="page-break-after:always;"></p>

<? /* Start TOC */ ?>

<br><br>
<center>
    <u><h1>Isi Kandungan</h1></u>
</center>
<br>
<div align="left">

<h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Status Kehadiran<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Senarai Peserta Hadir<br>
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Senarai Peserta Tidak Hadir<br>
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Rating Sesi Aturcara<br>
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5. Senarai Q & A<br>
    <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Senarai Ahli Layak Mengundi<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Senarai Ahli Hadir Mengundi<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5. Senarai Ahli Telah Mengundi<br-->
    
</h2>
</div>

<? /* End TOC */ ?>
<p style="page-break-after:always;"></p>
<?//start status kehadiran?>
<br><br><br>
<center>
    <h1>1. Status Kehadiran</h1>

<br>
</center>
	<?
		$tarikh_mula=$sesi['tarikh_mula'];
		$tarikh_tamat=$sesi['tarikh_tamat'];
		while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
			$hari=date("d F Y", strtotime($tarikh_mula));
			
			?>
	
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Status Kehadiran <? echo $hari;?></b></center>
						</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="33%">Penyertaan</th>
									<th width="33%">Hadir</th>
									<th width="33%">Peratusan</th>
								</tr>
							</thead>
							<tbody>
							<?
								$kehadiran = getPeratusanKehadiran($id_sesi,$tarikh_mula)->fetch_assoc();
								if($kehadiran['bilangan_peserta'] !='' && $kehadiran['bilangan_hadir'] != ''){
									$kehadiran_peserta = $kehadiran['bilangan_peserta'];
									$kehadiran_hadir = $kehadiran['bilangan_hadir'];
									$peratusan = round(($kehadiran_hadir/$kehadiran_peserta)*100);

								}else{
									$kehadiran_peserta = 0;
									$kehadiran_hadir = 0;
									$peratusan = 0;
								}
								
							?>
								<tr class="odd gradeX">
									<td><center><strong><font color="black" size="7px"><?php echo $kehadiran_peserta; ?></font></strong></center></td>
									<td><center><strong><font color="blue" size="7px"><?php echo $kehadiran_hadir; ?></font></strong></center></td>
									<td><center><strong><font color="red" size="7px"><?php echo number_format($peratusan, 0);?>%</font></strong></center></td>
								</tr>
							</tbody>
						</table>
					</div><br><br>
			<?
				$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
			}
			
							?>
		
	<? /* End status kehadiran */ ?>
<p style="page-break-after:always;"></p>
<?//start senarai hadir?>
<br><br><br>
<center>
    <h1>2. Senarai Peserta Hadir</h1>

<br>
</center>
<?
		
		$tarikh_mula=$sesi['tarikh_mula'];
		$tarikh_tamat=$sesi['tarikh_tamat'];
		while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
			$hari=date("d F Y", strtotime($tarikh_mula));
			
			?>
	
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Senarai Peserta Hadir <? echo $hari;?></b></center>
						</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">Bil.</th>
									<th >Nama</th>
									<th >No. Kad Pengenalan</th>
									<th >Kumpulan</th>
									<th >Masa</th>
									<th >Kehadiran</th>
								</tr>
							</thead>
							
							<?
									$i= 1;
									$data_peserta = getPesertaHadir($id_sesi,$tarikh_mula);
									while($list_peserta = $data_peserta->fetch_assoc()) {								
								?>
							<tbody>
								<tr>
									<td><? echo $i;?></td>
									<td><? echo $list_peserta['nama'];?></td>
									<td><? echo $list_peserta['nokp'];?></td>
									<td><? echo $list_peserta['nama_kumpulan'];?></td>
									<td><? echo $list_peserta['masa'];?></td>
									<td>
									<? if($list_peserta['status']==1){
										echo "SELF CHECK-IN (APP)"; 
									}else{
										echo "URUSETIA CHECK-IN";
									}?>
									</td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div><br><br>
			<?
				$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
			}
			
							?>
<? /* End senarai hadir */ ?>
<p style="page-break-after:always;"></p>
<?//start senarai tidak hadir?>
<br><br><br>
<center>
    <h1>3. Senarai Peserta Tidak Hadir</h1>

<br>
</center>
<?
		
		$tarikh_mula=$sesi['tarikh_mula'];
		$tarikh_tamat=$sesi['tarikh_tamat'];
		while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
			$hari=date("d F Y", strtotime($tarikh_mula));
			
			?>
	
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Senarai Peserta Tidak Hadir <? echo $hari;?></b></center>
						</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">Bil.</th>
									<th >Nama</th>
									<th >No. Kad Pengenalan</th>
									<th >Kumpulan</th>
								</tr>
							</thead>
							
							<?
									$i= 1;
									$data_peserta = getPesertaTidakHadir($id_sesi,$tarikh_mula);
									while($list_peserta = $data_peserta->fetch_assoc()) {								
								?>
							<tbody>
								<tr>
									<td><? echo $i;?></td>
									<td><? echo $list_peserta['nama'];?></td>
									<td><? echo $list_peserta['nokp'];?></td>
									<td><? echo $list_peserta['nama_kumpulan'];?></td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div><br><br>
			<?
				$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
			}
			
							?>
<? /* End senarai tidak hadir */ ?>
<p style="page-break-after:always;"></p>
<?//start rating aturcara?>
<br><br><br>
<center>
    <h1>4. Rating Sesi Aturcara</h1>

<br>
</center>
<?
		
		$tarikh_mula=$sesi['tarikh_mula'];
		$tarikh_tamat=$sesi['tarikh_tamat'];
		while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
			$hari=date("d F Y", strtotime($tarikh_mula));
			
			?>
	
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Rating Sesi Aturcara <? echo $hari;?></b></center>
						</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">Bil.</th>
									<th >Sesi Aturcara</th>
									<th >Bil. Pemberi Rating</th>
									<th >Jumlah Rating</th>
									<th >Rating Ahli</th>
								</tr>
							</thead>
							
							<?
									$i= 1;
									$data_rating = getRating($id_sesi,$tarikh_mula);
									while($list_rating = $data_rating->fetch_assoc()) {
										$bil_peserta = $list_rating['bil_peserta'];
										$jum_rating = $list_rating['jumlah_rating'];
										$jum_rating_semua = $bil_peserta*4;
										$bil_rating = round(($jum_rating/$jum_rating_semua)*4,0);
										
								?>
							<tbody>
								<tr>
									<td><? echo $i;?></td>
									<td><? echo 'Topik '.$i.' : '.$list_rating['tajuk'];?></td>
									<td><? echo $bil_peserta; ?></td>
									<td><? echo $jum_rating.'/'.$jum_rating_semua;?></td>
									<td>
									 
									  <? 
									  $x=1;
									  while($x <= $bil_rating){?>
										  
										  <i class="fa fa-star" aria-hidden="true"></i>
									  
									  <?$x++;}?>
									
									</td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div><br><br>
			<?
				$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
			}
			
							?>
<? /* End rating aturcara */ ?>
<p style="page-break-after:always;"></p>
<?//start q & a aturcara?>
<br><br><br>
<center>
    <h1>5. Senarai Q & A</h1>

<br>
</center>
<?
		
		$tarikh_mula=$sesi['tarikh_mula'];
		$tarikh_tamat=$sesi['tarikh_tamat'];
		while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
			$hari=date("d F Y", strtotime($tarikh_mula));
			
			?>
	
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Senarai Q & A <? echo $hari;?></b></center>
						</div>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th >Bil. Sesi Aturcara</th>
									<th >Jumlah Soalan</th>
									
								</tr>
							</thead>
							<?
								$sesi_qna=getJumlahAturcaraQna($id_sesi,$tarikh_mula)->fetch_assoc();
							?>
							<tbody>
								<tr>
									<td><center><strong><font color="black" size="7px"><?php echo $sesi_qna['bil_aturcara']; ?></font></strong></center></td>
									<td><center><strong><font color="black" size="7px"><?php echo $sesi_qna['bil_soalan']; ?></font></strong></center></td>
									
								</tr>
							</tbody>
						</table><br>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">Bil.</th>
									<th >Sesi Aturcara</th>
									<th >Bil. Soalan</th>
									<th >Soalan</th>
								</tr>
							</thead>
							
							<?
									$i= 1;
									$data_sesiQna = getSesiQna($id_sesi,$tarikh_mula);
									while($list_sesiQna = $data_sesiQna->fetch_assoc()) {
										
										
								?>
							<tbody>
								<tr>
									<td><? echo $i;?></td>
									<td><? echo 'Topik '.$i.' : '.$list_sesiQna['tajuk'];?></td>
									<td><? echo $list_sesiQna['bil_soalan']; ?></td>
									<td>
										<?
										$data_qna = getQnaAturcara($list_sesiQna['id_aturcara']);
										while($list_qna = $data_qna->fetch_assoc()) {
											echo '<img width="40" height="50" src="../../acara/foto_peserta/'.$list_qna['photo_filename'].'"/> '.$list_qna['nama'].'<br>';
											echo $list_qna['qna_soalan'].'<br><br>';
										
										}?>
									
									</td>
									
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div><br><br>
			<?
				$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
			}
			
							?>
	</body>
</html>