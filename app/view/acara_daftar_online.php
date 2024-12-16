<?php

	//include ('../controller/auth.php');
	require_once("../../util/qrcode.php");

	require "../model/acara_functions.php";

	$id_sesi = $_GET['id_sesi'];
	$act = $_GET['act'];
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




</head>

<body>
	<div class="container panel">				
			<div class="row" align="center" style="background-color:yellow;">

				<h1><b><u>PENDAFTARAN PENYERTAAN ONLINE</u></b></h1><br>
				<h2><b><? echo $acara['nama']; ?></b></h2>
				<h3><b><? echo $acara['lokasi']; ?></b></h3>
				<h3><b><? echo date("d F Y", strtotime($tarikh_mula))." - ".date("d F Y", strtotime($tarikh_tamat));?></b></h3>
												

			</div><br>
			 <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                      
                        <div class="panel-body">
						<? if ($act=='SUCCESS')
						        echo "<center><b><h3><font color=BLUE>Pendaftaran Penyertaan Telah Berjaya! Terima Kasih.</font></h3></b></center>";
						?>
						<? if(strtotime(date('Y-m-d')) <= strtotime($tarikh_tamat)){?>
							<form method="post" action="../controller/acara_daftar_online_exec.php" enctype="multipart/form-data">
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
                            <div>
                                <input type="hidden" name="action" value="daftarOnline" />
                                <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>" />
                            </div>

                            <div class="form-group" align="left">
                              <label>Nama Peserta<font color="red"> **</font>&nbsp;</label>
                              <input class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" placeholder=" " name="nama" id="nama" required >
                            </div>
                            <div class="form-group" align="left">
                              <label>No. Kad Pengenalan<font color="red"> **</font>&nbsp;</label>
                              <input class="form-control" placeholder=" " name="nokp" id="nokp" required>
                            </div>
                            <div class="form-group" align="left">
                              <label>No. Telefon<font color="red"> **</font>&nbsp;</label>
                              <input class="form-control" placeholder=" " name="notel" id="notel" required >
                            </div>
                            <div class="form-group" align="left">
                              <label>Jawatan<font color="red"> **</font>&nbsp;</label>
                              <input class="form-control" style="text-transform:uppercase" placeholder=" " name="jawatan" id="jawatan" required >
                            </div>
                            <div class="form-group" align="left">
                              <label>Kumpulan<font color="red"></font>&nbsp;</label>
                              <select required class="form-control" id="kumpulan" name="kumpulan" value=""><option value="">-- Pilih --</option><? echo getKumpulanDaftarOnline($id_sesi);?>
							</select>
                            </div>
                            <div class="form-group" align="left">
                              <label>Gambar Peserta<font color="red"> **</font>&nbsp;</label>
                              <input accept="image/*" type="file" class="btn btn-link" name="photo" />
                            </div>

                            
                             <div class="modal-footer" id="hantar">
                                   <button type="submit" class="btn btn-primary" >Simpan</button>
                                   <button type="reset" class="btn btn-info">Tetapan Semula</button>
                             </div>

                        </form>
						<?}else{?>
							<h1><strong><font color="red" >PENDAFTARAN TELAH DITUTUP!!!</strong></h1>
						<?}?>
						</div>
					</div>
				</div>
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
