<?php

include ('../controller/auth.php');


require "../model/acara_functions.php";


$id=$_POST['id_sesi'];




$data_sesi = getSesiAcaraById($id)->fetch_assoc();

?>
 
 
 
 
 <form method="post" action="../controller/acara_sesi_exec.php">
				
				<div> 
								<label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>						 
                           </div>
						   <input id="action" name="action" type="hidden" value="edit_sesi"/>
						   <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_NAME'];?>"/>
						   <input id="id_sesi" name="id_sesi" type="hidden" value="<? echo $id;?>"/>
                            <div class="form-group"> 
								<label class="control-label">Nama Sesi<font color="red">**</font></label>
								<input class="form-control" id="nama" name="nama" type="text" value="<? echo $data_sesi['nama'];?>"/>
							</div>
							<div class="form-group"> 
								<label class="control-label">Lokasi<font color="red">**</font></label>
								<input class="form-control" id="lokasi" name="lokasi" type="text" value="<? echo $data_sesi['lokasi'];?>"/>
							</div>
							<div class="form-group">
								<label class="control-label">Tarikh Mula<font color="red">**</font></label>
								<input class="form-control" id="tarikh_mula" name="tarikh_mula" type="date" value="<? echo $data_sesi['tarikh_mula'];?>"/>
							</div>
							<div class="form-group">
								<label class="control-label">Tarikh Tamat<font color="red">**</font></label>
								<input class="form-control" id="tarikh_tamat" name="tarikh_tamat" type="date" value="<? echo $data_sesi['tarikh_tamat'];?>"/>
							</div>
							<div class="form-group">
								<label class="control-label">Tahun<font color="red">**</font></label>
								<input class="form-control" id="tahun" name="tahun" type="number" value="<? echo $data_sesi['tahun'];?>"/>
							</div>
				
				
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                </div>
						
					
                         
                </form>