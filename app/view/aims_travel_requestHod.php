<?php

include ('../controller/auth.php');

require "../model/aims_travel_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$travel_hod = getTravelById($id)->fetch_assoc();

?>  
<style>
 
		
.separator {
    display: flex;
    align-items: center;
    text-align: center;
	padding-bottom: 10px;
	padding-top: 10px;
}
.separator::before, .separator::after {
    content: '';
    flex: 1;
    border-top: 3px double #8c8b8b; 
	<!--border-bottom: 1px solid #000;-->
}
.separator::before {
    margin-right: .25em;
}
.separator::after {
    margin-left: .25em;
}
</style>
    
        
				<form method="post" action="../controller/aims_travel_requestHod_exec.php">
				<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
					
			
				<div class="form-group row" align="left">
					<div class="col-xs-5">
	                        <label class="control-label">Company</label>
							<input class="form-control" id="company_id" name="company_id" type="text" value="<? echo $travel_hod['company_id'] ?>" readonly/>
	                         
					</div>		 
					<div class="col-xs-4">		 
	                        <label class="control-label">Department</label>
							<input class="form-control" id="department_id" name="department_id" type="text" value="<? echo $travel_hod['department_id'] ?>" onkeyup="convertToUppercase(this)" readonly/>
	                </div>	  
					<div class="col-xs-3">
						<label class="control-label">Staff No</label>
						<input class="form-control" id="no_staff" name="no_staff" type="text" value="<? echo $travel_hod['no_staff'] ?>" onkeyup="convertToUppercase(this)" readonly/>
					</div>
	            </div>
				
			
				
				<div class="form-group row" align="left">
					<div class="col-xs-5">
						<label class="control-label">Name</label>
						<input class="form-control" id="name" name="name" type="text" value="<? echo $travel_hod['name'] ?>"  onkeyup="convertToUppercase(this)" readonly/>
					</div>
					
					<div class="col-xs-4">
						<label class="control-label">Designation</label>
						<input class="form-control" id="staff_designation" name="staff_designation" type="text" value="<? echo $travel_hod['staff_designation'] ?>" onkeyup="convertToUppercase(this)" readonly/>
					</div>
					
					<div class="col-xs-3">
						<label class="control-label">I/C No</label>
						<input class="form-control" id="noic" name="noic" type="text" value="<? echo $travel_hod['noic'] ?>" readonly/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-5" align="left">
						<label class="control-label">Purpose</label>
						<textarea class="form-control" id="travel_purpose" name="travel_purpose" type="text" placeholder="<? echo $travel_hod['travel_purpose'] ?>" rows="5" style="height:190px" readonly><? echo $travel_hod['travel_purpose'] ?></textarea>
					</div>
					
					<div class="col-xs-3">
						<label class="control-label">Mode of Travel</label>
						<input class="form-control" id="travel_mode_id" name="travel_mode_id" type="text" value="<? echo $travel_hod['travel_mode_id'] ?>" readonly/>
					</div>
					
					<div class="col-xs-3">
							<label class="control-label">Job No</label>
							<input class="form-control" id="job_no" name="job_no" type="text" value="<? echo $travel_hod['job_no'] ?>" onkeyup="convertToUppercase(this)" value="" readonly/>
					</div>
					 <div class="col-xs-3" style="margin-top:1%">
	                        <label class="control-label">Departure Date</label>
							<input class="form-control" id="departure_date" name="departure_date" type="date" style="text-transform:uppercase;" value="<? echo $travel_hod['departure_date'] ?>" readonly/>
	                </div>
					
					<div class="col-xs-3" style="margin-top:1%">
	                     	<label class="control-label">Return Date</label>
							<input class="form-control" id="return_date" name="return_date" type="date" style="text-transform:uppercase;" value="<? echo $travel_hod['return_date'] ?>" readonly/>
	                </div>
					<div class="col-xs-3" style="margin-top:1%">
	                        <label class="control-label">Departure Time (hh:mm:AM/PM)</label>
							<input class="form-control" id="departure_time" name="departure_time" type="time" value="<? echo $travel_hod['departure_time'] ?>" style="text-transform:uppercase;" value="" readonly/>
	                </div>   
					
					<div class="col-xs-3" style="margin-top:1%">
	                     	<label class="control-label">Return Time (hh:mm:AM/PM)</label>
							<input class="form-control" id="return_time" name="return_time" type="time" style="text-transform:uppercase;" value="<? echo $travel_hod['return_time'] ?>" readonly/>
	                </div>
				</div>
				
				<div class="separator"><b>HOTEL ACCOMODATION</b></div>
			
				<div class="form-group row" align="left">
				
					<div class="col-xs-3">
	                        <label class="control-label">Request for Hotel : <? echo $travel_hod['request_hotel'] ?> <font color="red"></font></label>
	                </div>
					<div class="col-xs-3">
	                        <label class="control-label">Duration of Stays (days):<font color="red"></font></label>
							<input class="form-control" id="hotel_duration" name="hotel_duration" type="text" required value="<? echo $travel_hod['hotel_duration'] ?>" style="text-transform:uppercase;" readonly/>
	                </div>   
				
					<div class="col-xs-3">
	                        <label class="control-label">Date Check In<font color="red"></font></label>
							<input class="form-control" id="check_in" name="check_in" type="date" required value="<? echo $travel_hod['check_in'] ?>" style="text-transform:uppercase;" readonly/>
	                </div>   
					
					<div class="col-xs-3">
	                        <label class="control-label">Date Check Out<font color="red"></font></label>
							<input class="form-control" id="check_out" name="check_out" type="date" required value="<? echo $travel_hod['check_out'] ?>" style="text-transform:uppercase;" readonly/>
	                </div>  
				</div>
				
			<div class="separator"><b>TRANSPORTATION</b></div>
			
				<div class="form-group row" align="left">
				
					<div class="col-xs-6">
							<label class="control-label">Transportation From Airport (KT/KUA) : <? echo $travel_hod['transport_fairport'] ?></label>
							<br>
							<label class="control-label">Request for Company Driver: <? echo $travel_hod['request_driver'] ?> </label>
					</div>
					<div class="col-xs-6">
							<label class="control-label">Transportation To Airport (KT/KUA) : <? echo $travel_hod['transport_tairport'] ?></label>
							<br>
							<label class="control-label">Advance Required: <? echo $travel_hod['advance_required'] ?></label>
					</div>   
					
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-6">
							<label class="control-label">Destination</label>
							<input class="form-control" id="destination" name="destination" type="text" onkeyup="convertToUppercase(this)" value="<? echo $travel_hod['destination'] ?>" readonly/>
					</div>   
					<div class="col-xs-4">	
						<label class="control-label">Total (RM):</label>
						<input class="form-control" id="travel_advance" name="travel_advance" type="text" value="<? echo $travel_hod['travel_advance'] ?>" readonly/>
					</div>	
					
				</div>
				
				<div class="form-group row">
					<div class="col-xs-6" style="align:center;float:center;text-align: center">
						<label class="control-label" align="center">Action<font color="red">&nbsp;*</font></label>
						<select style="align:center;float:center;text-align: center" required class="form-control" name="hod_approval" id="hod_approval" style="">
									<option value=""><? echo $travel_hod['hod_approval'] ?></option>
									<option value="APPROVED">APPROVE</option>
									<option value="REJECTED">REJECT</option>
						</select>
					</div>
					<div class="col-xs-6" style="align:center;float:center;text-align: center">
						<label style="align:center;float:center;text-align: center" class="control-label" align="center">Verified By (HOD/CEO)<font color="red">&nbsp;*</font></label>
						<input style="align:center;float:center;text-align: center" class="form-control" id="hod_by" name="hod_by" type="text" value="<?php echo $_SESSION['SESS_NAME'] ?>" readonly/>
					</div>
				</div>
		
				
            <div align="center">
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
        
			</form>
			
			<script>
		
				function convertToUppercase(el) {
					if(!el || !el.value) return;
					el.value = el.value.toUpperCase();
				}
			</script>
								
			
				<script>
					

					
			
					
				</script>

</body>

</html>

