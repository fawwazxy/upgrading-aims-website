<?php

include ('../controller/auth.php');


require "../model/library_functions.php";

$id_tempahan=$_POST['id_tempahan'];
$data_tempahan = getTempahanById($id_tempahan)->fetch_assoc();
$data_library = getLibraryById($data_tempahan['id_elibrary'])->fetch_assoc();
$data_peminjam = getPeminjamByNokp($data_tempahan['nokp'])->fetch_assoc();
?>
<div align="center">
 	<h3><strong>Tajuk : <? echo $data_library['nama']; ?></strong></h3>
 	</div>
 <form method="post" action="../controller/library_peminjam_exec.php">
				
	<div> 
		<label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>						 
   </div>
   <input id="action" name="action" type="hidden" value="tempahanAddPinjaman"/>
   <input id="id_naskah" name="id_naskah" type="hidden" value="<? echo $data_tempahan['id_naskah'];?>"/>
   <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_ID'];?>"/>
   <input id="id_tempahan" name="id_tempahan" type="hidden" value="<? echo $id_tempahan;?>"/>
    <div class="form-group"> 
		<label class="control-label">No. Kad Pengenalan<font color="red"> **</font></label>
		<input class="form-control" id="nokp" name="nokp" type="text" value="<? echo $data_peminjam['nokp'];?>"required readonly />
	</div> 
	<div class="form-group"> 
		<label class="control-label">Nama<font color="red"> **</font></label>
		<input class="form-control" id="nama" name="nama" value="<?echo $data_peminjam['nama']?>" type="text" required readonly />
	</div>
	<div class="form-group"> 
		<label class="control-label">No. Telefon<font color="red"> **</font></label>
		<input class="form-control" id="notel" name="notel" value="<?echo $data_peminjam['notel']?>" type="text" required readonly />
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