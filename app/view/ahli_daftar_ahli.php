<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";

?>
<?
         
		 $id = $_POST['id'];
         $statact = $_POST['statact'];
         $tab = $_POST['tab'];
 ?>

                     
                      <form method="post" action="../controller/ahli_exec.php" >     
                         <div class="form-group" align="left">
                              
                              <? $data=getAhliById($id)->fetch_assoc();
                              		if($data['no_ahli']!=""){
								  		$no_ahli= $data['no_ahli'];
								  	}else{
								  		$no_ahli=getNo_Ahli();
								  	}

                              ?>
							 
                             
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							 <input type="hidden" name="statact" value="<?php echo $statact; ?>">
							 <input type="hidden" name="tab" value="<?php echo $tab; ?>">
							 <input type="hidden" name="action" value="daftarAhli">
								<div class="form-group"  align="left">
								  <label>No. Ahli<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="no_ahli" value="<? echo $no_ahli;?>" readonly >
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="nama" value="<? echo $data['nama'];?>" readonly>
								</div>
								
								<div class="form-group" align="left">
							 	<label class="control-label" for="date">Status Ahli<font color="red">&nbsp;**</font></label>
		                        <select required class="form-control" id="status_ahli" name="status_ahli" value="">
		                        <option value="">-- Pilih --</option>
		                            <?echo getDropDownStatusAhli($data['status_ahli']);?>
		                        </select>
		                        </div> 			
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      