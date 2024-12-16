<?php

	include ('../controller/auth.php');

	require "../model/aims_car_function.php";

?>
<?        
		 $id = $_POST['id'];
		 $car_id = $_POST['car_id'];
         $car_info = getcarMaintenancebyId($id)->fetch_assoc();
 ?>
                      <form method="post" action="../controller/aims_car_maintenance_exec.php" enctype="multipart/form-data">     

							<label><font color="red">** Maklumat Wajib Diisi. </font></label>
							<br>
							        
							  <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
							  <input type="hidden" name="id" value="<?php echo $id; ?>">
							  <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">

								<div class="form-group row" align="left">
								<div class="col-xs-6">
								  <label>Kilmetre Reading(KM)<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="km_read" value="<? echo $car_info['km_read'];?>" >
								</div>							  
							  
							   <div class="col-xs-6">
								  <label>Odometre Reading<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="odom_read" value="<? echo $car_info['odom_read'];?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								  <label>Date<font color="red">**</font>&nbsp;</label>
								  <input type="date" class="form-control" placeholder=" " name="date" value="<? echo $car_info['date'];?>" >
								</div>								

								<div class="col-xs-6">
								  <label>Duration Period<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="duration" value="<? echo $car_info['duration'];?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Job Description<font color="red">**</font>&nbsp;</label>
                                 <textarea class="form-control" rows="4" cols="50" placeholder="" name="job_desc"  wrap="hard" value="<? echo $car_info['job_desc'];?>"><? echo $car_info['job_desc'];?></textarea>
								</div>
								
								<div class="col-xs-6">
								  <label>Item Description<font color="red">**</font>&nbsp;</label>
                                  <textarea class="form-control" rows="4" cols="50" placeholder="" name="item_desc"   wrap="hard" value="<? echo $car_info['item_desc'];?>"><? echo $car_info['item_desc'];?></textarea>
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Place Of Service<font color="red">**</font>&nbsp;</label>
								 <input class="form-control" placeholder="" name="place_service" value="<? echo $car_info['place_service'];?>" >
								</div>
								
								<div class="col-xs-6">
								  <label>Invoice No.<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder="" name="invoice_no" value="<? echo $car_info['invoice_no'];?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Issue During Inspection<font color="red">**</font>&nbsp;</label>
								 <textarea class="form-control" rows="4" cols="50" placeholder="" name="issue"  wrap="hard" value="<? echo $car_info['issue'];?>"><? echo $car_info['issue'];?></textarea>
								</div>
								</div>
								

                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary">Save</button>
                                  
                             </div>
         
         </form>