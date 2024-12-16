<?php

	include ('../controller/auth.php');

	require "../model/niaga_function.php";

?>
<?
	$id=$_POST['rowid'];
?>


                     
                      <form method="post" action="../controller/pelanggan_update_exec.php?id=<? echo $id?>" >     
                         <div class="form-group" align="left">
                              <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>" />
							 
                              
							  <? $data= getLeadInformation($id);?>
                             
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							 
								<div class="form-group"  align="left">
								  <label>Nama<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" name="lead_name" value="<? echo $data['lead_name'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama Singkatan<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" name="lead_shrtname" value="<? echo $data['lead_shrtname'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Alamat Penuh<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" type="text" name="lead_address" value="<? echo $data['lead_address'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>No Telefon (WhatsApp)</label>
								  <input class="form-control" name="lead_telno"  value="<? echo $data['lead_telno'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Emel</label>
								  <input class="form-control" name="lead_email"  value="<? echo $data['lead_email'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Nama PIC<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" name="pic_name" value="<? echo $data['pic_name'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Jawatan PIC</label>
								  <input class="form-control" name="pic_position" value="<? echo $data['pic_position'];?>">
								</div>
								
								<div class="form-group" align="left">
									  <label>Negeri</label>
									  <select required class="form-control" name="negeri">
									  <option value="<? echo $data['id_negeri'];?>" selected><? echo $data['negeri'];?></option>
									  <? $negeri= getNegeri();
									   while ($list  = $negeri -> fetch_assoc()){ ?>
									   <option value="<? echo $list['id'];?>"><? echo $list['name'];?></option>
													
									 <?
									   }       
									 ?>
									   </select>
								</div>
								
								<div class="form-group"  align="left">
								  <label>Daerah</label>
								  <input class="form-control" name="daerah" value="<? echo $data['daerah'];?>">
								</div>
								
								<div class="form-group"  align="left">
								  <label>Koordinat GPS (longitud,latitud)</label>
								  <input class="form-control" name="lokasi" value="<? echo $data['lokasi'];?>">
								</div>
								
								<div class="form-group" align="left">
									  <label>Segmen</label>
									  <select required class="form-control" name="segmen" value="">
									  <option value="<? echo $data['id_lead_segmen'];?>" selected><? echo $data['segmen'];?></option>
									  <? $segmen= getSegmen();
									   while ($list  = $segmen -> fetch_assoc()){ ?>
									   <option value="<? echo $list['id'];?>"><? echo $list['name'];?></option>
													
									 <?
									   }       
									 ?>
									   </select>
								</div>
								
								<div class="form-group" align="left">
									  <label>Status</label>
									  <select required class="form-control" name="status">
									  <option value="<? echo $data['status'];?>" selected>
									      <?
									        if ($data['status']==0) {
									           echo "LEAD"; 
									        }
									        if ($data['status']==1) {
									           echo "PROSPECT"; 
									        }
									        if ($data['status']==2) {
									           echo "CLIENT"; 
									        }
									      
									      ?>
									  </option>
									  <option value=0>LEAD</option>
								      <option value=1>PROSPECT</option>
								      <option value=2>CLIENT</option>  		  
									  
									   </select>
								</div>
								
								<div class="form-group" align="left">
									  <label>Data Dimasukkan Oleh</label>
									  <select required class="form-control" name="created_by">
									  <option value="<? echo $data['created_by'];?>" selected><? echo $data['created_name'];?></option>
									  <? $created= getCreated();
									   while ($list  = $created -> fetch_assoc()){ ?>
									   <option value="<? echo $list['created_by'];?>"><? echo $list['created_by'];?>:<? echo $list['created_name'];?></option>
													
									 <?
									   }       
									 ?>
									   </select>
								</div>
										
                  
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
								   
                                  
                             </div>
         
         </form>