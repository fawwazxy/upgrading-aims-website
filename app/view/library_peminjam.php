<?php

include ('../controller/auth.php');


require "../model/library_functions.php";


$id_library=$_POST['id_library'];
$data_dokumen = getLibraryInfo($id_library)->fetch_assoc();
?>
	<div align="center">
 	<h3><strong>Tajuk : <? echo $data_dokumen['nama']; ?></strong></h3>
 	</div>
 <form method="post" action="../controller/library_peminjam_exec.php">
				
		<div> 
		<label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>						 
       	</div>
	   	<input id="action" name="action" type="hidden" value="addEditPeminjam"/>
	   	<input id="id_library" name="id_library" type="hidden" value="<? echo $id_library;?>"/>
	   	<input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_ID'];?>"/>
	   	<input id="status" name="status" type="hidden" value="0"/>
        <div class="form-group"> 
			<label class="control-label">No. Kad Pengenalan<font color="red"> **</font></label>
			<input class="form-control" id="nokp" name="nokp" type="text" onkeyup="getPeminjam(this)" required />
		</div> 
		<div class="form-group"> 
			<label class="control-label">Nama<font color="red"> **</font></label>
			<input class="form-control" id="nama" name="nama" type="text" required />
		</div>
		<div class="form-group"> 
			<label class="control-label">No. Telefon<font color="red"> **</font></label>
			<input class="form-control" id="notel" name="notel" type="text" required />
		</div>
		<div class="form-group"> 
			<label class="control-label">Tarikh Pinjam<font color="red"> **</font></label>
			<input class="form-control" id="tarikh_pinjam" name="tarikh_pinjam" type="date" required />
		</div>
		<div class="form-group"> 
			<label class="control-label">Bil. Hari Dipinjam<font color="red"> **</font></label>
			<input class="form-control" id="bil_hari_pinjam" name="bil_hari_pinjam" type="number" required />
		</div>
		<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Simpan</button>
		<button type="reset" class="btn btn-warning">Tetapan Semula</button>
		</div>
</form>
<script>

</script>