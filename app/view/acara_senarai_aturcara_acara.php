<?php

	//include ('../controller/auth.php');
	require_once("../../util/qrcode.php");

	require "../model/acara_functions.php";

	$id_sesi = $_GET['id_sesi'];
	$tarikh = $_GET['tarikh'];
	//$aturcara = getAturcara($id_sesi,$tarikh)->fetch_assoc();
	$acara = getSesiAcaraById($id_sesi)->fetch_assoc();
	$tarikh_mula = $acara['tarikh_mula'];
	$tarikh_tamat = $acara['tarikh_tamat'];
	//$flagScreen = $_GET['tarikh'];


?>
 
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
}


</script>
<script language="javascript" type="text/javascript">
setInterval(function () {
    
	 location.reload();
	 
    
}, 20000);
<!--
function popitup(url) {
	/*newwindow=window.open(url,'name','height=842,width=595');*/
	newwindow=window.open(url,'name','height=595,width=842');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>


</head>

<body id="refresh">
	<div class="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<table align="left" border="0" width="100%">
					<tr bgcolor="yellow">
						<td  align="left" width="80%" rowspan="2">
							&nbsp;&nbsp;<center><? echo '<h3><b>'.$acara['nama'].'</b></h3>';?></center>
						</td>
						<td width="20%">
							<h1 align="right">
								<font color="blue">
									<div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
								</font>
							</h1>
							<h4 align="right">
								<font color="blue">
									<span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
								</font>
							</h4>
						</td>
						<td width="30%">&emsp;&emsp;</td>
					</tr>
				</table>
			</div>
		</nav>
		<br>
		<!-- Table Sasaran Jualan -->
		<div class="col-lg-12">
			<?
				$i=1;
				$flagScreen = $tarikh;
				while (strtotime($tarikh_mula) <= strtotime($tarikh_tamat)) {
				$hari=date("d F Y", strtotime($tarikh_mula));
				$hari_tarikh = date("Y-m-d", strtotime($tarikh_mula));
			?>
			<div id='cssmenu'>
				<ul >
					<li class="<? echo ($flagScreen==$tarikh_mula?'active':'') ?>"><a href="acara_senarai_aturcara_acara.php?id_sesi=<?echo $id_sesi?>&tarikh=<?echo $tarikh_mula?>"><strong><?echo $hari?></strong></a></li>
					<?
						$tarikh_mula = date ("Y-m-d", strtotime("+1 day", strtotime($tarikh_mula)));
						
						$i++;}
							
					?>
				</ul>
			</div>
			<br>
			<div class="col-xs-6 col-md-8">
	    		<div class="panel panel-red">
					<!-- /.panel-heading -->
					<div class="panel-heading">
						<center><b>ATURCARA KESELURUHAN</b></center>
					</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th width="20%">Masa</th>
								<th width="40%">Agenda Aturcara</th>
								<th width="20%">Speaker/Penceramah/Penyampai</th>
							</tr>
						</thead>
						<tbody>
						<?
							$aturcara = getAturcara($id_sesi,$tarikh);
							while($list_aturcara = $aturcara->fetch_assoc()) {
						?>
							<tr class="odd gradeX">
								<td><strong><?php echo $list_aturcara['masa_mula']; ?> - <?php echo $list_aturcara['masa_tamat']; ?></strong></td>
								<td><?php echo $list_aturcara['tajuk']; ?></td>
								<td>
									<?php
										if($list_aturcara['kategori']==1){
											$speaker = getSpeakerAcara($list_aturcara['id']);
											while($list_speaker = $speaker->fetch_assoc()) {
												echo '<img src="../../acara/foto_peserta/'.$list_speaker['speaker_photo'].'" style="width:30px;height:30px;"><br>';
												echo '<strong><font color=blue size=2>'.$list_speaker['speaker_name'].'</font><br><font color=black size=1>'.$list_speaker['speaker_jawatan'].'</font></strong><br>';
											}
										}else{
											echo "-";
										}
									?>
								</td>
							</tr>
						<? } ?>
						</tbody>
					</table>
                </div>
		
			</div>
			<div class="col-xs-6 col-md-4">
				<div class="short-div" style="background-color:green">
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Status Kehadiran Terkini</b></center>
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
								$kehadiran = getPeratusanKehadiran($id_sesi,$tarikh)->fetch_assoc();
								if($kehadiran['bilangan_peserta'] !='' && $kehadiran['bilangan_hadir'] != ''){
									$kehadiran_peserta = $kehadiran['bilangan_peserta'];
									$kehadiran_hadir = $kehadiran['bilangan_hadir'];
									$peratusan = $kehadiran_hadir/$kehadiran_peserta*100;

								}else{
									$kehadiran_peserta = 0;
									$kehadiran_hadir = 0;
									$peratusan = 0;
								}
								
							?>
								<tr class="odd gradeX">
									<td><center><strong><font color="black" size="7px"><b><?php echo $kehadiran_peserta; ?></b></font></strong></center></td>
									<td><center><strong><font color="blue" size="7px"><b><?php echo $kehadiran_hadir; ?></b></font></strong></center></td>
									<td><center><strong><font color="red" size="7px"><b><?php echo number_format($peratusan, 0);?>%</b></font></strong></center></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="short-div" style="background-color:green">
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Scan QR-Code Untuk Log Kehadiran</b></center>
						</div>
						<br>
						<center>
						<? 
							$qr = new QRCode();
							$qr = QRCode::getMinimumQRCode($id_sesi, QR_ERROR_CORRECT_LEVEL_L);
							$qr->printHTML("10px");
						?>	
						</center>
						<br>
					</div>
				</div>
				<div class="short-div" style="background-color:green">
					<div class="panel panel-red">
						<div class="panel-heading">
						<center><b>Galeri Foto Kehadiran</b></center>
						</div>
						<?
							$kehadiran = getKehadiranAcara($id_sesi,$tarikh);
							while($list_kehadiran = $kehadiran->fetch_assoc()) {
						?>
						<?if($list_kehadiran['peserta_photo']!=''){?>
							<img src="../../acara/foto_peserta/<? echo $list_kehadiran['peserta_photo'];?>" style="width:70px;height:70px;" title="<? echo $list_kehadiran['peserta_nama'];?>">
						<?}else{?>
							<img src="../../acara/foto_peserta/nophoto.jpg" style="width:70px;height:70px;" title="<? echo $list_kehadiran['peserta_nama'];?>">
						<?}?>
						<?}?>
						<br>
					</div>
				</div>
				
			</div>
			
			<!-- /.panel -->
		</div>

		
		
	</div>
	<div class="footer-section">
			<div class="copy-section">
				<!--<div class="container">-->
					<center>
						<p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
						Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
					</center>
				<!--</div>-->
			</div>
		</div>
</body>

</html>
