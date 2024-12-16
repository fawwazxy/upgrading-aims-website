<?php

	include ('../controller/auth.php');
	require "../model/aims_car_function.php";
	require "../model/lookup.php";

	$id = $_POST['id'];
	
	$main = getMaintenancebyId($id)->fetch_assoc();
?>

                     
                      <form method="post" action="../controller/aims_car_maintenance_add_exec.php" enctype="multipart/form-data">     

							<label><font color="red">** Maklumat Wajib Diisi.</font></label>
							<br>
							        
							  <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
							  <input id="id" name="id" type="hidden" value="<?php echo $id ?>"/>
								
								<div class="form-group row" align="left">
							    <div class="col-xs-6">
								  <label>Car Model</label>
								  <select  required class="form-control" name="car_model" id="car_model">
									<option value="">-- Choose Vehicle--</option>
									<? echo getDropDown("aims_car_info","car_model","car_model",$main['car_model']);?>
								  </select>
								</div>
								
								<div class="col-xs-6">
								  <label>Date Inspection Issue<font color="red">**</font>&nbsp;</label>
								  <input type="date" class="form-control" placeholder=" " name="dep_date" value="<?php echo $main['dep_date'] ?>" >
								</div>							  
								</div>
								
								<label><b>Issue Identified During Inspection : </b></label>
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								  <label>Interior<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="interior_car1" value="<?php echo $main['interior_car1'] ?>" >
								</div>							  
							  
							   <div class="col-xs-6">
								  <label>Exterior<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="exterior_car1" value="<?php echo $main['exterior_car1'] ?>" >
								</div>
								</div>
							  
								<div class="form-group row" align="left">
								<div class="col-xs-4">
								  <label>Kilmetre Reading(KM)<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="km_read" value="<?php echo $main['km_read'] ?>" >
								</div>							  
							  
							   <div class="col-xs-4">
								  <label>Odometre Reading<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="odom_read" value="<?php echo $main['odom_read'] ?>" >
								</div>
								
								<div class="col-xs-4">
								  <label>Costing Inspection<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="costing" value="<?php echo $main['costing'] ?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								  <label>Date<font color="red">**</font>&nbsp;</label>
								  <input type="date" class="form-control" placeholder=" " name="date" value="<?php echo $main['date'] ?>" >
								</div>								

								<div class="col-xs-6">
								  <label>Duration Period<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder=" " name="duration" value="<?php echo $main['duration'] ?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Job Description<font color="red">**</font>&nbsp;</label>
                                 <textarea class="form-control" rows="4" cols="50" placeholder="" name="job_desc" value="<?php echo $main['job_desc'] ?>"><?php echo $main['job_desc'] ?></textarea>
								</div>
								
								<div class="col-xs-6">
								  <label>Item Description<font color="red">**</font>&nbsp;</label>
                                  <textarea class="form-control" rows="4" cols="50" placeholder="" name="item_desc"  value="<?php echo $main['item_desc'] ?>"><?php echo $main['item_desc'] ?></textarea>
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Place Of Service<font color="red">**</font>&nbsp;</label>
								 <input class="form-control" placeholder="" name="place_service" value="<?php echo $main['place_service'] ?>" >
								</div>
								
								<div class="col-xs-6">
								  <label>Invoice No.<font color="red">**</font>&nbsp;</label>
								  <input class="form-control" placeholder="" name="invoice_no" value="<?php echo $main['invoice_no'] ?>" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-6">
								 <label>Issue During Inspection<font color="red">**</font>&nbsp;</label>
								 <textarea class="form-control" rows="4" cols="50" placeholder="" name="issue" value="<?php echo $main['issue'] ?>"><?php echo $main['issue'] ?></textarea>
								</div>
								</div>
								

                             <div class="modal-footer">
                                   <center><button type="submit" class="btn btn-primary">Save</button></center>
                                  
                             </div>
         
         </form>