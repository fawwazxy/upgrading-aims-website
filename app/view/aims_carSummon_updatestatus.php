<?php

	include ('../controller/auth.php');

	require "../model/aims_carReserve_function.php";

?>
<?
         
		 $id = $_GET['id'];
        
 ?> 

                     
                      <form method="post" action="../controller/aims_carSummon_update1.php?id=<? echo $id ?>" >     
							
                              
							  <?$data = getcarsummonById($id)->fetch_assoc();?>
                             
							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							 <input type="hidden" name="id" value="<?php echo $data['id']; ?>">


								<div class="form-group"  align="left">

  								<label>Status: <?php echo $data['summon_status']; ?></label></br>
								<input type="radio" name="status" <?php if($data['summon_status']=="UNPAID") {echo "checked";}?> value="UNPAID">UNPAID	
								<input type="radio" name="status" <?php if($data['summon_status']=="PAID") {echo "checked";}?> value="PAID">PAID
								</div>



                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      