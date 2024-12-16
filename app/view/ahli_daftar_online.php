<?php

	//include ('../controller/auth.php');
	

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

	//$id_sesi = $_GET['id_sesi'];
	$act = $_GET['act'];
	//$aturcara = getAturcara($id_sesi,$tarikh)->fetch_assoc();
	
	 $ahli_kelab_persatuan_info = getAhliKelabPersatuanInfo()->fetch_assoc();


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

				<h3><b><u>PENDAFTARAN AHLI ONLINE</u></b></h3>
				<?if($ahli_kelab_persatuan_info['logo'] != ''){echo '<img width="150" height="150" src="data:image/jpeg;base64,'.base64_encode( $ahli_kelab_persatuan_info['logo'] ).'"/>';
                }?>  
                <h4><b><?echo $ahli_kelab_persatuan_info['nama'];?></b></h4>
												

			</div><br>
			 <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                      
                        <div class="panel-body">
						<? if ($act=='SUCCESS')
						        echo "<center><b><h3><font color=BLUE>Pendaftaran Ahli Telah Berjaya! Terima Kasih.</font></h3></b></center>";
						?>
						<? if ($act=='FAILED')
						        echo "<center><b><h3><font color=RED>Pendaftaran Ahli Tidak Berjaya! Rekod Telah Wujud.</font></h3></b></center>";
						?>
						
					<form id="myform" method="post"  action="../controller/ahli_exec.php" name="myform"  enctype="multipart/form-data" >
	                    
	                 	<input name="action" type="hidden" class="input-short" value="daftarOnline" />
	                    <label><font color="red">** Maklumat Wajib Diisi **</font></label>
	                    <br>
						 	<div class="form-group" align="left">
	                         <label>Nama<font color="red">&nbsp;**</font></label>
	                         <input type="text" class="form-control"  style="text-transform:uppercase" name="nama" value="" required>
	                         </div>
							 
							 <div class="form-group" align="left">
	                         <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
	                         <input type="text" class="form-control" id="nokp" name="nokp" value="" required>
	                         </div>
							 
							 <div class="form-group" align="left">
	                         <label>No. Telefon<font color="red">&nbsp;** (cth: +60123456789)</font></label>
	                         <input type="text" class="form-control" id="notel" name="notel" value="" required>
	                         </div>
	                         
						  	<div class="form-group" align="left">
	                     	<label>Gps Koordinat<font color="red"><i>&nbsp;(Jika Ada)</i></font></label>
	                     	<input type="text" class="form-control" name="gps_koordinat" value="">
	                     	</div>

	                        <div class="form-group" align="left">
	                        <label class="control-label" for="date">Kategori Umur<font color="red">&nbsp;**</font></label>
	                        <select required class="form-control" id="kategori_umur" name="kategori_umur" value="">
	                        <option value="">-- Pilih --</option>
	                            <?echo getDropDownKategoriUmur($list_ahli['kategori_umur']);?>
	                        </select>
	                        </div>

	                        <div class="form-group" align="left">
	                        <label class="control-label" for="date">Galur<font color="red">&nbsp;**</font></label>
	                        <select required class="form-control" id="galur" name="galur" value="">
	                        <option value="">-- Pilih --</option>
	                            <?echo getDropDown("ahli_lkp_galur","kod","nama_galur",$list_ahli['galur']);?>
	                        </select>
	                        </div>  	
						
					
						  	<div class="form-group" align="left">
	                     	<label>Alamat<font color="red"></font>&nbsp;</label>
	                     	<textarea class="form-control" name="alamat" rows="5"  ></textarea>
	                     	</div>
							 
							<div class="form-group" align="left">
						 	<label class="control-label" for="date">Negeri<font color="red">&nbsp;**</font></label>
	                        <select required class="form-control" id="negeri" name="negeri" value="">
	                        <option value="">-- Pilih --</option>
	                            <?echo getDropDown("lkp_negeri","code","name",$list_ahli['negeri']);?>
	                        </select>
	                        </div> 

	                        <div class="form-group" align="left">
	                        <label>Gambar Profil&nbsp;<font color="red"><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
	                       
	                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	                        <input type="file" accept=".jpg,.jpeg,.png,.gif" name="photo" id="photo">   
	                        </div>

							  <div class="modal-footer">
	                                    <button type="submit" class="btn btn-success">Simpan</button>
	                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
	                         </div>
	                     
	                        </form>
						
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
