<?php

	include ('../controller/auth.php');

	require "../model/surat_function.php";
	
	

?>
<?
         
		 $id = $_POST['rowid'];
        
 ?>


                     
                      <form method="post" action="../controller/jenis_surat_update_exec.php?id=<? echo $id?>" >     
                         <div class="form-group" align="left">
                              <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />
							 
                        <?      
							  
                             $data = getJenisSuratInfo($id)->fetch_assoc();?>
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
								<div class="form-group"  align="left">
								  <label>Kod Surat<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="code" value="<? echo $data['code'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama Surat<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="surat" value="<? echo $data['surat'];?>">
								</div>
								
								
								
								
								 
								
								
								
								
										
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                     