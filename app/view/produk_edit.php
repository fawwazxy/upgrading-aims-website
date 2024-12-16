<?php

	include ('../controller/auth.php');

	require "../model/surat_function.php";

?>
<?
         
		 $id = $_GET['id'];
        
 ?>

                     
                      <form method="post" action="../controller/produk_update_exec.php?id=<? echo $id ?>" >     
                         <div class="form-group" align="left">
                              <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />
							
                              
							  <?$data = getJenisProdukInfo($id);?>
                             
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
								<div class="form-group"  align="left">
								  <label>Nama Produk<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="produk" value="<? echo $data['produk'];?>" >
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama singkatan Produk<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="code" value="<? echo $data['code'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Penerangan Tentang Produk<font color="red">**</font>&nbsp;</label>
								  <textarea rows="8" class="form-control" placeholder=" " name="penerangan" ><? echo $data['penerangan'];?></textarea>
								</div>
								
								
								 
								
								
								
								
										
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      