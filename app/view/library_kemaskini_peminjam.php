<?php

include ('../controller/auth.php');


require "../model/library_functions.php";
$id=$_POST['id'];
$data_peminjam=getPeminjamInfo($id)->fetch_assoc();
?>

 
 
 <form method="post" action="../controller/library_peminjam_exec.php">
						
						   <input id="action" name="action" type="hidden" value="addEditPeminjam"/>
						   <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_ID'];?>"/>
						    <input id="id_peminjam" name="id_peminjam" type="hidden" value="<?echo $id?>"/>
						    <input id="status" name="status" type="hidden" value="<?echo $data_peminjam['status']?>"/>
                            <div class="form-group"> 
								<label class="control-label">No. Kad Pengenalan<font color="red"></font></label>
								<input class="form-control" id="nokp" name="nokp" type="text" required  value="<?echo $data_peminjam['nokp']?>" disabled/>
							</div> 
							<div class="form-group"> 
								<label class="control-label">Nama<font color="red"></font></label>
								<input class="form-control" id="nama" name="nama" type="text" required  value="<?echo $data_peminjam['nama']?>" disabled />
							</div>
							<div class="form-group"> 
								<label class="control-label">No. Telefon<font color="red"></font></label>
								<input class="form-control" id="notel" name="notel" type="text" required  value="<?echo $data_peminjam['notel']?>" disabled />
							</div>
							<div class="form-group"> 
								<label class="control-label">Tarikh Pinjam<font color="red"> **</font></label>
								<input class="form-control" id="tarikh_pinjam" name="tarikh_pinjam" type="date"required  value="<?echo $data_peminjam['tarikh_pinjam']?>"/>
							</div>
							<?if($data_peminjam['status'] == 1){?>
							<div class="form-group"> 
								<label class="control-label">Tarikh Hantar<font color="red"> **</font></label>
								<input class="form-control" id="tarikh_hantar" name="tarikh_hantar" type="date"required  value="<?echo $data_peminjam['tarikh_hantar']?>"/>
							</div><?}?>
							<div class="form-group"> 
								<label class="control-label">Bil. Hari Dipinjam<font color="red"> **</font></label>
								<input class="form-control" id="bil_hari_pinjam" name="bil_hari_pinjam" type="number" required  value="<?echo $data_peminjam['bil_hari_pinjam']?>"/>
							</div>
							<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-warning">Tetapan Semula</button>
							</div>
									
					
                         
                </form>
<script>

</script>