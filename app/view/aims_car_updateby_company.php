<?php

	include ('../controller/auth.php');

	require "../model/aims_car_function.php";

?>
<?        
		 $id = $_GET['id'];
         $car_info = getcarById($id)->fetch_assoc();
?> 

                     
                      <form method="post" action="../controller/aims_car_updateby_company_exec.php" enctype="multipart/form-data">     

							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							        
							  <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
							  <input type="hidden" name="id" value="<?php echo $car_info['id']; ?>">
							  
								<div class="form-group row" align="center">
								
								<br>
								<?if($car_info['document_type'] == 'jpg' || $car_info['document_type'] == 'jpeg' || $car_info['document_type'] == 'png' || $car_info['document_type'] == 'gif') {
                                                echo '<img width="200" height="100" src="data:image/jpeg;base64,'.base64_encode( $car_info['document'] ).'"/><br>';}
                                         else if($car_info['document_type'] == 'pdf') {
                                                echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $car_info['document'] ).'"/><br>'.'" type="application/pdf"></object>';}
                                ?>
								</div>
							  
							  
								
								<div class="form-group row" align="center">
								
								  <label>STATUS:</label></br>
								  <input type="radio" name="car_status" <?php if($car_info['car_status']=="0") {echo "checked";}?> value="0"> AVAILABLE	
								  <input type="radio" name="car_status" <?php if($car_info['car_status']=="1") {echo "checked";}?> value="1"> NOT AVAILABLE
								
								</div>

                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                             </div>
         
         </form>