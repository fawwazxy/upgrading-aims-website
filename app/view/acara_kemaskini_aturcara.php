<?php

include ('../controller/auth.php');


require "../model/acara_functions.php";


$id_aturcara=$_POST['id_aturcara'];
$id_sesi=$_POST['id_sesi'];



$data_aturcara = getAturcaraAcara($id_aturcara)->fetch_assoc();

?>
 
 
 
 
<form method="post" action="../controller/acara_aturcara_exec.php" enctype="multipart/form-data">
	<div>
	    <input type="hidden" name="action" value="aturcaraAddEdit" />
	    <input type="hidden" id="id" name="id" value="<?echo $id_aturcara?>" />
	    <input type="hidden" id="id_sesi" name="id_sesi" value="<?echo $id_sesi?>" />
	</div>

	<div class="form-group" align="left">
		<label>Masa Mula<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="masa_mula" name="masa_mula" type="text" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="23:59:00" required value="<?echo $data_aturcara['masa_mula']?>" />
	</div>

	<div class="form-group" align="left">
		<label>Masa Tamat<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="masa_tamat" name="masa_tamat" type="text" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" placeholder="23:59:00" required value="<?echo $data_aturcara['masa_tamat']?>"/>
	</div>

	<div class="form-group" align="left">
	  <label>Tajuk<font color="red">**</font>&nbsp;</label>
	  <input class="form-control" placeholder=" " name="tajuk" id="tajuk" required value="<?echo $data_aturcara['tajuk']?>">
	</div>
	<div class="form-group" align="left">
	    <label>Kategori</label>
	    <br><input type="radio" value="0" name="kategori" id="kategori"<?echo $data_aturcara['kategori'] == '0'?'checked':''?> />&nbsp; &nbsp;Bukan Keynote&nbsp; &nbsp; &nbsp;
	    <input type="radio" value="1" name="kategori" id="kategori" <?echo $data_aturcara['kategori'] == '1'?'checked':''?> />&nbsp; &nbsp;Keynote
	</div>
	<div class="form-group" align="left">
	    <label>Lagu Tema</label>
	    <br><input type="radio" value="0" name="lagu_tema_status" id="lagu_tema_status"<?echo $data_aturcara['lagu_tema_status'] == '0'?'checked':''?> />&nbsp; &nbsp;Tiada&nbsp; &nbsp; &nbsp;
	    <input type="radio" value="1" name="lagu_tema_status" id="lagu_tema_status" <?echo $data_aturcara['lagu_tema_status'] == '1'?'checked':''?> />&nbsp; &nbsp;Ada
	</div>
	<div class="form-group" align="left">
	    <label>Rating</label>
	    <br><input type="radio" value="0" name="rating" id="rating"<?echo $data_aturcara['rating'] == '0'?'checked':''?> />&nbsp; &nbsp;Tiada&nbsp; &nbsp; &nbsp;
	    <input type="radio" value="1" name="rating" id="rating" <?echo $data_aturcara['rating'] == '1'?'checked':''?> />&nbsp; &nbsp;Ada
	</div>
	<div class="form-group" align="left">
	    <label>Q & A</label>
	    <br><input type="radio" value="0" name="qna" id="qna"<?echo $data_aturcara['qna'] == '0'?'checked':''?> />&nbsp; &nbsp;Tiada&nbsp; &nbsp; &nbsp;
	    <input type="radio" value="1" name="qna" id="qna" <?echo $data_aturcara['qna'] == '1'?'checked':''?> />&nbsp; &nbsp;Ada
	</div>

	<div class="form-group" align="right">
	    <button type="submit" class="btn btn-primary">Simpan</button>
	</div>

</form>
