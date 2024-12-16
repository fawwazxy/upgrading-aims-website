<?php

	include ('../controller/auth.php');

	require "../model/surat_function.php";

?>
<?
	$id=$_POST['rowid'];
?>


                     
                      <form method="post" action="../controller/lead_update_exec.php?id=<? echo $id?>" >     
                         <div class="form-group" align="left">
                              <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />
							 
                              
							  <? $data= getLeadInfo($id);?>
                             
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							 
								<div class="form-group"  align="left">
								  <label>Nama Agensi/Syarikat<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="lead_name" value="<? echo $data['lead_name'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama singkatan<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="lead_shrtname" value="<? echo $data['lead_shrtname'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Alamat Penuh<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " type="text" name="lead_address" value="<? echo $data['lead_address'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>No Telefon (WhatsApp)</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="lead_telno"  value="<? echo $data['lead_telno'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Email</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="lead_email"  value="<? echo $data['lead_email'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama Personel<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="pic_name" value="<? echo $data['pic_name'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Jawatan Personel</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="pic_position" value="<? echo $data['pic_position'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Lokasi (longitud,latitud)</font>&nbsp;</label>
								  <input class="form-control" placeholder=" "  name="lokasi" value="<? echo $data['lokasi'];?>">
								</div>
								
								
								
								
								
										
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
								   
                                  
                             </div>
         
         </form>