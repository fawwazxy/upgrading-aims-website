<?php

	include ('../controller/auth.php');

	require "../model/aims_carReserve_function.php";

?>
<?        
$id = $_GET['id'];
$raw_data = getcarRequestById($id)->fetch_assoc();
 ?> 

                     
                      <form method="post" action="../controller/aims_carstatusCeo_update.php?id=<? echo $id ?>" >     
							
                              
							  
                             
							  <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                            <br>
							<input type="hidden" name="id" value="<?php echo $raw_data['id']; ?>">
							<input type="hidden" name="app_by" value="<?php echo $_SESSION['SESS_NAME']; ?>">
							
                                <div class="form-group"  align="left">
                                  <label>Name<font color="red">**</font>&nbsp;</label>
                                  <?php echo $raw_data['name'];?><br>
                                </div>							
                                
                                <div class="form-group"  align="left">
								<label>Status:</label></br>
								<input type="radio" name="ceo_app" <?php if($raw_data['ceo_app']=="PENDING") {echo "checked";}?> value="PENDING"> PENDING
								<input type="radio" name="ceo_app" <?php if($raw_data['ceo_app']=="APPROVE") {echo "checked";}?> value="1"> APPROVE
								<input type="radio" name="ceo_app" <?php if($raw_data['ceo_app']=="DISAPPROVE") {echo "checked";}?> value="2"> DISAPPROVE
                                </div>						



                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                                  
                             </div>
         
         </form>
                      