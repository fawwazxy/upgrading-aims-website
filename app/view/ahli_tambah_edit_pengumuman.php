<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>
<?
         
		 $id = $_POST['id'];
		 $created_by = $_POST['created_by'];
		 $data=getPengumumanById($id)->fetch_assoc();
		 $str=$data['dokumen_filename'];
         $type=explode(".",$str);
         $file_type=end($type);
 ?>

                     
                      <form method="post" action="../controller/ahli_pengumuman_exec.php" enctype="multipart/form-data">     
                         <div class="form-group" align="left">
                           
							<label><font color="red">** Maklumat Wajib Diisi **</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $id; ?>">
							 <input type="hidden" name="action" value="addEditPengumuman">
							  <input type="hidden" name="created_by" value="<?php echo $created_by; ?>">

							  <div class="form-group"  align="left">
								  <label>Tajuk&nbsp;<font color="red">**</font></label>
								  <input class="form-control" placeholder=" "  name="tajuk" value="<? echo $data['tajuk'] ?>" required>
								</div> 
							 

								<div class="form-group"  align="left">
								  <label>Tarikh Mula&nbsp;<font color="red">**</font></label>
								  <input class="form-control" type="date" placeholder=" "  name="tarikh_mula" value="<? echo $data['tarikh_mula'];?>" required>
								</div>

								<div class="form-group"  align="left">
								  <label>Tarikh Tamat&nbsp;<font color="red">**</font></label>
								  <input class="form-control" type="date" placeholder=" "  name="tarikh_tamat" value="<? echo $data['tarikh_tamat'];?>" required>
								</div>
								<?
									if($data['kategori']=="0" || $data['kategori']==""  ){
										$checkPengumuman="checked";
									}else{
										$checkPengumuman="";
									}
									if($data['kategori']=="1" ){
										$checkAktiviti="checked";
									}else{
										$checkAktiviti="";
									}
								?>

								<div class="form-group"  align="left">
									<label>Kategori&nbsp;<font color="red">**</font></label>
									<div class="radio">
									  <label><input type="radio" name="kategori" value="0" <?echo $checkPengumuman;?>>Pengumuman</label>
									  <label><input type="radio" name="kategori" value="1" <?echo $checkAktiviti;?>>Aktiviti</label>
									</div>
								</div>

								<div class="form-group" align="left">
		                         <label>Keterangan<font color="red">**</font>&nbsp;</label>
		                         <textarea class="form-control" name="keterangan" rows="5" required><? echo $data['keterangan']; ?></textarea>
		                        </div>

								<div class="form-group" align="left">
		                        <label>Lampiran&nbsp;<font color="red"><i>(Hanya fail format pdf/jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
		                        <br><?if($data['dokumen_filename'] != ''){
		                        	if($file_type!="pdf") {
							            echo '<br><img width="200" height="200" src="../../iahli/lampiran/'.$data['dokumen_filename'].'"/><br>';}
							        else{
							          echo '<object width="200" height="200" data="../../iahli/lampiran/'.$data['dokumen_filename'].'"/><br>'.'</object>';}
							         
		                        }
		                        echo $data['dokumen_filename'];?>
		                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
		                        <input type="file" accept=".pdf,.jpg,.jpeg,.png,.gif" name="dokumen" id="dokumen">   
		                        </div>
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                   <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                  
                             </div>
         
         </form>
                      