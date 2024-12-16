<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarpassengerById($id)->fetch_assoc();
?>


					<form method="post" action="../controller/aims_carpassenger_update_exec.php">
					<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
	
				
				<div class="form-group " align="left">
				
						<label class="control-label">Name Passenger<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="name_passenger" name="name_passenger" type="text"  value="<?php echo $car_info['name_passenger'];?>" style="text-transform:uppercase" onchange=""/>
					
				</div>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Designation<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="jawatan" name="jawatan" type="text" value="<?php echo $car_info['jawatan'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Department<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="description" name="description" type="text" value="<?php echo $car_info['description'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
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