<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>
<?
         
		 $id = $_POST['id'];
		 $created_by = $_POST['created_by'];
		 $data=getRekodSumbanganById($id)->fetch_assoc();
		 

        
 ?>

                     
                      <form method="post" action="../controller/ahli_sumbangan_perbelanjaan_exec.php" >     
                         <div class="form-group" align="left">
                              
                              <? 
                              ?>
							 
                             
							<label><font color="red">** Maklumat Wajib Diisi **</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							 <input type="hidden" name="action" value="addEditSumbangan">
							  <input type="hidden" name="created_by" value="<?php echo $created_by; ?>">
							 
								<div class="form-group"  align="left">
								  <label>Tarikh&nbsp;<font color="red">**</font></label>
								  <input class="form-control" type="date" placeholder=" "  name="tarikh" value="<? echo $data['tarikh'];?>" required>
								</div>


								<div class="form-group" align="left">
		                         <label>Keterangan<font color="red"></font>&nbsp;</label>
		                         <textarea class="form-control" name="keterangan" rows="5"><? echo $data['keterangan']; ?></textarea>
		                        </div>

								<div class="form-group"  align="left">
								  <label>Penyumbang&nbsp;<font color="red">**</font></label>
								  <input class="form-control" placeholder=" "  name="penyumbang" value="<? echo $data['penyumbang'] ?>" required>
								</div> 


								<div class="form-group"  align="left">
								  <label>Diterima Oleh&nbsp;<font color="red">**</font></label>
								  <input class="form-control" placeholder=" "  name="diterima_oleh" value="<? echo $data['diterima_oleh'] ?>" required>
								</div> 


		                        <div class="form-group"  align="left">
								  <label>No. Rujukan&nbsp;<font color="red"></font></label>
								  <input class="form-control" placeholder=" "  name="no_rujukan" value="<? echo $data['no_rujukan'] ?>" >
								</div> 	

		                        <div class="form-group"  align="left">
								  <label>Jumlah&nbsp;<font color="red">**</font></label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="jumlah" value="<? echo $data['jumlah'];?>" required>
								</div>

								

                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                   <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                  
                             </div>
         
         </form>
                      