<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarRequestById($id)->fetch_assoc();
?>


					<form method="post" action="../controller/aims_carpassenger_add_exec.php">
					<input id="reserve_id" name="reserve_id" type="hidden" value="<? echo $id?>"/>
					<input id="name" name="name" type="hidden" value="<?php echo $_SESSION['SESS_NAME']?>"/>
	
    

				<div class="form-group " align="left">
				
						<label class="control-label">Date<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="dep_date" name="dep_date" type="date" required value="<? echo $car_info['dep_date'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>

				
				<div class="form-group " align="left">
					
						<label class="control-label">Purpose<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="purpose" name="purpose" type="text" required value="<? echo $car_info['purpose'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>

				<div class="form-group " align="left">
					
						<label class="control-label">Plate No<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="car_plate_no" name="car_plate_no" type="text" required value="<? echo $car_info['car_plate_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>
				
				<div class="form-group " align="left">
				
						<label class="control-label">Name Passenger<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="name_passenger" name="name_passenger" type="text" required value="" style="text-transform:uppercase" onchange=""/>
					
				</div>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Designation<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="jawatan" name="jawatan" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Department<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="description" name="description" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>
				
				
				
				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="reset" class="btn btn-warning">Reset</button>
				</div>
			</form>

		<script>
				function convertToUppercase(el) {
					if(!el || !el.value) return;
					el.value = el.value.toUpperCase();
				}
			</script>