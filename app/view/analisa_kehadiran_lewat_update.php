<?php

include ('../controller/auth.php');

require "../model/analisa_kehadiran_functions.php";
require "../model/lookup.php";


?>
<?
         
		 $id = $_GET['id'];
        
 ?> 
<?$staff_details = masukSebabKelewatanById($id)->fetch_assoc();?>
                     
                      <form method="post" action="../controller/analisa_kehadiranlewat_update_exec.php?id=<? echo $staff_details['id']; ?>
					  &nokp_staff=<? echo $staff_details['nokp_staff']; ?>&sebab_kelewatan=<? echo $staff_details['sebab_kelewatan']; ?>" >     
							
                              
							
                             
							<br>
							 <input type="hidden" id="id" name="id" value="<?php echo $staff_details['id']; ?>">
							 <input type="hidden" id="nokp_staff" name="nokp_staff" value="<?php echo $staff_details['nokp_staff']; ?>">
								<div class="form-group"  align="left">
								  <label>Sebab Kelewatan<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " id="sebab_kelewatan" name="sebab_kelewatan" value="<? echo $staff_details['sebab_kelewatan'];?>" >
								</div>
								



                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      