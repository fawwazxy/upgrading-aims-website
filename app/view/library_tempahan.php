<?php

include ('../controller/auth.php');


require "../model/library_functions.php";


$id_library=$_POST['id_library'];
$id_tempahan=$_POST['id_tempahan'];
$data_dokumen = getLibraryInfo($id_library)->fetch_assoc();

?>
 
 <h1><strong><? echo $data_dokumen['nama']; ?></strong></h1>
 
 
 <form method="post" action="../controller/library_tempahan_exec.php">
				
						<div> 
								<label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>						 
                           </div>
						   <input id="action" name="action" type="hidden" value="addEditTempahan"/>
						   <input id="id_library" name="id_library" type="hidden" value="<? echo $id_library;?>"/>
						   <input id="status" name="status" type="hidden" value="0"/>
                            <div class="form-group"> 
								<label class="control-label">No. Kad Pengenalan<font color="red">**</font></label>
								<input class="form-control" id="nokp" name="nokp" type="text" onkeyup="getPeminjam(this)" required />
							</div> 
							<div class="form-group"> 
								<label class="control-label">Nama<font color="red">**</font></label>
								<input class="form-control" id="nama" name="nama" type="text" required />
							</div>
							<div class="form-group"> 
								<label class="control-label">No. Telefon<font color="red">**</font></label>
								<input class="form-control" id="notel" name="notel" type="text" required />
							</div>
							<div class="form-group"> 
								<label>Status Segera<font color="red"> **</font>&nbsp;</label><br>
								<input type="radio" value="0" name="status_urgent" checked=""/>
								<label>Tidak Segera</label>&nbsp; &nbsp; &nbsp;
								<input type="radio" value="1" name="status_urgent" />
								<label>Segera</label>
							</div>
							<div class="form-group"> 
								<label class="control-label">Anggaran Tarikh Diperlukan<font color="red">**</font></label>
								<input class="form-control" id="anggaran_tarikh_tempah" name="anggaran_tarikh_tempah" type="date" required />
							</div>
						
							<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Tempahan</button>
							<button type="reset" class="btn btn-warning">Tetapan Semula</button>
							</div>
									
					
                         
                </form>
<script>

</script>