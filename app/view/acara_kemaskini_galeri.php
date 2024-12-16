<?php

include ('../controller/auth.php');


require "../model/acara_functions.php";


$id_sesi=$_POST['id_sesi'];
$id_galeri=$_POST['id_galeri'];




$data_galeri = getGaleriAcaraById($id_galeri)->fetch_assoc();

?>
 
 
 
 
 <form method="post" action="../controller/acara_galeri_exec.php">
				
				<div> 
								<label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>						 
                           </div>
						   <input id="action" name="action" type="hidden" value="edit_galeri"/>
						   <input id="id_sesi" name="id_sesi" type="hidden" value="<? echo $id_sesi;?>"/>
						   <input id="id_galeri" name="id_galeri" type="hidden" value="<? echo $id_galeri;?>"/>
                            <div class="form-group"> 
								<label class="control-label">Tajuk Folder<font color="red">**</font></label>
								<input class="form-control" id="tajuk_folder" name="tajuk_folder" type="text" value="<? echo $data_galeri['tajuk_folder'];?>"/>
							</div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                </div>
						
					
                         
                </form>