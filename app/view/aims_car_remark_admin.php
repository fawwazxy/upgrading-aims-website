<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarRemarkById($id)->fetch_assoc();
?>


					<form method="post" action="../controller/aims_car_remarkadmin_exec.php">
					<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
					<input id="remark_name" name="remark_name" type="hidden" value="<?php echo $_SESSION['SESS_NAME']?>"/>
	
    
					<div class="form-group"  align="left">
					<label>Status:</label></br>
					<input type="radio" name="status_remark" <?php if($car_info['status_remark']=="UNCHECK") {echo "checked";}?> value="UNCHECK"> UNCHECK
					<input type="radio" name="status_remark" <?php if($car_info['status_remark']=="CHECK") {echo "checked";}?> value="CHECK"> CHECK
                    </div>
					
					<div class="form-group " align="left">
					
						<label class="control-label">Costing<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="costing" name="costing" type="text" required value="<? echo $car_info['costing'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
					</div>
				
					<div class="form-group " align="left">
						
							<label class="control-label">Remark/Comment<font color="red">&nbsp;*</font></label>
							<input class="form-control" id="remark" name="remark" type="text" required value="<? echo $car_info['remark'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
						
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