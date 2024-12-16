<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>
<?
         
		 $id = $_POST['id'];
		 $statact = $_POST['statact'];
         $tab = $_POST['tab'];
		 $data=getMaklumatYuran($id)->fetch_assoc();
		 if(!isset($id)){
		 	$id_yuran=$_POST['id_yuran'];
		 	$data=getMaklumatYuranByIdYuran($id_yuran)->fetch_assoc();
		 }
		 $nokp = $_POST['nokp'];

        
 ?>

                     
                      <form method="post" action="../controller/ahli_exec.php" >     
                         <div class="form-group" align="left">
                              
                              <? 
                              ?>
							 
                             
							<label><font color="red">** Maklumat Wajib Diisi **</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							  <input type="hidden" name="id_yuran" value="<?php echo $id_yuran; ?>">
							 <input type="hidden" name="nokp_ahli" value="<?php echo $nokp; ?>">
							 <input type="hidden" name="action" value="YuranAhli">
							 <input type="hidden" name="jenis_ahli" value="<?echo $data['status_ahli'];?>">
							 <input type="hidden" name="statact" value="<?php echo $statact; ?>">
							 <input type="hidden" name="tab" value="<?php echo $tab; ?>">
								<div class="form-group"  align="left">
								  <label>Nama</label>
								  <input class="form-control" placeholder=" "  name="nama" value="<? echo $data['nama'];?>" readonly>
								</div>
								
								<div class="form-group" align="left">
							 	<label class="control-label" for="date">Status Ahli</label>
		                        <select required class="form-control" id="status_ahli" name="status_ahli" value="" disabled>
		                        <option value="" >-- Pilih --</option>
		                            <?echo getDropDownStatusAhli($data['status_ahli']);?>
		                        </select>
		                        </div>

		                        <div class="form-group"  align="left">
								  <label>Jumlah Yuran</label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="yuran" value="<? echo $data['yuran'];?>" readonly>
								</div>

								 <div class="form-group"  align="left">
								  <label>Telah Bayar</label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="yuran" value="<? echo $data['jum_bayaran'];?>" readonly>
								</div>

								<div class="form-group"  align="left">
								  <label>Baki Perlu Bayar</label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="yuran" value="<? echo $data['jum_belum_bayar'];?>" readonly>
								</div>

								<div class="form-group"  align="left">
								  <label>Jumlah Bayaran&nbsp;<font color="red">**</font></label>
								  <input type="number" step="any" class="form-control" placeholder=" "  name="jum_yuran" value="<? echo $data['jum_yuran'];?>" required>
								</div>

								<div class="form-group" align="left">
		                        <label class="control-label" for="date">Kaedah Bayaran&nbsp;<font color="red">**</font></label>
		                        <select required class="form-control" id="jenis_bayaran" name="jenis_bayaran" value="">
		                        <option value="">-- Pilih --</option>
		                            <?echo getDropDown("jenis_perbelanjaan","nama","nama",$data['jenis_bayaran']);?>
		                        </select>
		                        </div>

		                        <div class="form-group"  align="left">
								  <label>No. Rujukan&nbsp;<font color="red"></font></label>
								  <input class="form-control" placeholder=" "  name="no_rujukkan" value="<? echo $data['no_rujukkan'] ?>" >
								</div> 			
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      