<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

 $id = $_GET['id'];
 $car_info = getCarInspectionById($id)->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <? require "../global/header.php"; ?>

</head>

<style>
.column{
	float: left;
	width: 28%;
	padding: 3px;
}

.label1{
	display: inline-block;
    max-width: 100%;
	margin-top: 30px;
    font-weight: 700;
}
</style>

<body>



    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
            <? include ('../global/menu_top.php'); ?>

            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
                            <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                        </li-->

                        <? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Vehicle Usage List</h1>
                </div>
            </div>

            <div class="form-group" align="right">
            </div>
            
             
             <div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
					<form method="post" action="../controller/aims_car_inspection_update_exec.php?">
					
					 <input type="hidden" name="id" value="<?php echo $car_info['id']; ?>">
					 <input type="hidden" name="reserve_id" value="<?php echo $car_info['reserve_id']; ?>">
	
				<div class="form-group " align="left">
				
						<label class="control-label">Status Inception<font color="red">&nbsp;*</font></label>
						<input id="status_incep" name="status_incep" type="radio"  <?php if($car_info['status_incep']=="YES") {echo "checked";}?> value="YES"/>   YES
						<input id="status_incep" name="status_incep" type="radio"  <?php if($car_info['status_incep']=="NO") {echo "checked";}?> value="NO"/>   NO 
					
				</div>

				<div class="form-group " align="left">
				
						<label class="control-label">Date<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="dep_date" name="dep_date" type="date" value="<? echo $car_info['dep_date'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>


				<div class="form-group " align="left">
					
						<label class="control-label">Plate No<font color="red">&nbsp;*</font></label>
						<select  required class="form-control" name="car_plate_no" id="car_plate_no">
									<option value="">-- Choose Car Plate --</option>
									<? echo getDropDownCarplate($car_info['car_plate_no']);?>
						</select>
				</div>
				
				<div class="form-group " align="left">
				
						<label class="control-label">Fuel<font color="red">&nbsp;*</font></label>
						<select class ="form-control" id="fuel" name="fuel">
						<option value="<? echo $car_info['fuel'];?>"><? echo $car_info['fuel'];?></option>
						<option value="E">E</option>
						<option value="1/4">1/4</option>
						<option value="1/2">1/2</option>
						<option value="3/4">3/4</option>
						<option value="F">F</option>
						</select>
					
				</div>
				<?php
				
				
			$conn=db();
			$sql = "SELECT * from aims_car_inspection
			WHERE id = '$id'";
			$run=mysqli_query($conn,$sql);
			$row=mysqli_fetch_array($run);
			
			$id = $row['id'];
			$car_plate_no = $row['car_plate_no'];
			$dep_date = $row['dep_date'];
			$fuel = $row['fuel'];
			$hd_vehicle = $row['hd_vehicle'];
			$exterior_car = $row['exterior_car'];
			$interior_car = $row['interior_car'];
			$comment = $row['comment'];
			$chk= explode(',',$hd_vehicle);
			$chk1= explode(',',$exterior_car);
			$chk2= explode(',',$interior_car);
			
				
				?>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Car Requirement<font color="red">&nbsp;*</font></label><br>
						<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MIRROR" <?php if(in_array("MIRROR",$chk)){echo "checked";}?> />  mirror<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="BODY"<?php if(in_array("BODY",$chk)) {echo "checked";}?> />    body<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("LAMP",$chk)){echo "checked";}?> value="LAMP"/>    lamp <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SEAT",$chk)) {echo "checked";}?> value="SEAT"/>   seat<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("ENGINE",$chk)) {echo "checked";}?> value="ENGINE"/>   engine<br> 
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RIM",$chk)) {echo "checked";}?> value="RIM"/>   RIM 
						</div>
						<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("DASHBOARD",$chk)){echo "checked";}?> value="DASHBOARD"/>   Dashboard<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("CANVAS",$chk)) {echo "checked";}?> value="CANVAS"/>   Canvas<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("TYRE",$chk)) {echo "checked";}?> value="TYRE"/>   Tyre <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SERVICE BOOKLET",$chk)) {echo "checked";}?> value="SERVICE BOOKLET"/> Service Booklet<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RADIO",$chk)) {echo "checked";}?> value="RADIO"/> Radio<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("CIGARETTE LIGHTER",$chk)) {echo "checked";}?> value="CIGARETTE LIGHTER"/> Cigarette Lighter
						</div>
						<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("JACK",$chk)) {echo "checked";}?> value="JACK"/> Jack<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("TOOL KITS",$chk)) {echo "checked";}?> value="TOOL KITS"/> Tool Kit<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SPARE TYRE",$chk)) {echo "checked";}?> value="SPARE TYRE"/> Spare Tyre <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("HUB CAP",$chk)) {echo "checked";}?> value="HUB CAP"/> Hub Cap<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("MUD FLAP",$chk)) {echo "checked";}?> value="MUD FLAP"/> Mud Flap<br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RADIO FREQ",$chk)) {echo "checked";}?> value="RADIO FREQ"/> Radio Freq
						</div>
				</div>
				
				
				
				
				<div class="form-group " align="left">
				        
						<div class="label1">
						<label class="control-label">Exterior Car</label>
						<br><font color="red">&nbsp;FOR SELECT MULTIPLE PRESS CTRL WHILE SELECT</font><br>
						<select class ="form-control" name="exterior_car[]" id="exterior_car" multiple>
						<option <?php if(in_array("WINDOW/WINDSHIELD",$chk1)) {echo 'selected = "selected"';}?>value="WINDOW/WINDSHIELD">WINDOW/WINDSHIELD</option>
						<option <?php if(in_array("WINDSHEILD WIPERS",$chk1)) {echo 'selected = "selected"';}?>value="WINDSHEILD WIPERS">WINDSHEILD WIPERS</option>
						<option <?php if(in_array("HEADLIGHTS",$chk1)) {echo 'selected = "selected"';}?>value="HEADLIGHTS">HEADLIGHTS</option>
						<option <?php if(in_array("TAIL LIGHT/ BARKE LIGHT",$chk1)) {echo "selected";}?>value="TAIL LIGHT/ BARKE LIGHT">TAIL LIGHT/ BARKE LIGHT</option>
						<option <?php if(in_array("EMERGENCY BRAKE",$chk1)) {echo 'selected = "selected"';}?>value="EMERGENCY BRAKE">EMERGENCY BRAKE</option>
						<option <?php if(in_array("POWER BRAKE",$chk1)) {echo 'selected = "selected"';}?>value="POWER BRAKE">POWER BRAKE</option>
						<option <?php if(in_array("HORN & HAZARD LIGHT",$chk1)) {echo 'selected = "selected"';}?>value="HORN & HAZARD LIGHT">HORN & HAZARD LIGHT</option>
						<option <?php if(in_array("TIRE",$chk1)) {echo 'selected = "selected"';}?>value="TIRE">TIRE</option>
						<option <?php if(in_array("AIR LEAKS/ODOUR OF GASOLINE",$chk1)) {echo 'selected = "selected"';}?>value="AIR LEAKS/ODOUR OF GASOLINE">AIR LEAKS/ODOUR OF GASOLINE</option>
						<option <?php if(in_array("OIL/GREASE LEAKS",$chk1)) {echo 'selected = "selected"';}?>value="OIL/GREASE LEAKS">OIL/GREASE LEAKS</option>
						<option <?php if(in_array("MIRROR",$chk1)) {echo 'selected = "selected"';}?>value="MIRROR">MIRROR</option>
						<option <?php if(in_array("EXHAUST SYSTEM",$chk1)) {echo 'selected = "selected"';}?>value="EXHAUST SYSTEM">EXHAUST SYSTEM</option>
						<option <?php if(in_array("WHEELS AND FASTENERS",$chk1)) {echo 'selected = "selected"';}?>value="WHEELS AND FASTENERS">WHEELS AND FASTENERS</option>
						<option <?php if(in_array("SIGNAL LIGHT",$chk1)) {echo 'selected = "selected"';}?>value="SIGNAL LIGHT">SIGNAL LIGHT</option>
						
						</select>
					
				</div>
				</div>
				
				<div class="form-group " align="left">
					
						<label class="control-label">Comment<font color="red">&nbsp;*</font></label>
						<textarea class="form-control" id="comment1" name="comment1" type="text"  value="<? echo $car_info['comment1'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"><? echo $car_info['comment1'];?></textarea>
					
				</div>					
				
				<div class="form-group " align="left">
				<div class="label1">
						<label class="control-label">Interior Car</label>
						<br><font color="red">&nbsp;FOR SELECT MULTIPLE PRESS CTRL WHILE SELECT</font><br>
						<select class ="form-control" name="interior_car[]" id="interior_car" multiple>
						<option <?php if(in_array("HEATING",$chk2)) {echo 'selected = "selected"';}?> value="HEATING">HEATING</option>
						<option <?php if(in_array("AIR CONDITION",$chk2)) {echo 'selected = "selected"';}?> value="AIR CONDITION">AIR CONDITION</option>
						<option <?php if(in_array("WINDSHEILD DEFOGGING SYSTEM",$chk2)) {echo 'selected = "selected"';}?> value="WINDSHEILD DEFOGGING SYSTEM">WINDSHEILD DEFOGGING SYSTEM</option>
						<option <?php if(in_array("WINDOW OPERATION",$chk2)) {echo 'selected = "selected"';}?> value="WINDOW OPERATION">WINDOW OPERATION</option>
						<option <?php if(in_array("DOOR HANDLES/LOCKS",$chk2)) {echo 'selected = "selected"';}?> value="DOOR HANDLES/LOCKS">DOOR HANDLES/LOCKS</option>
						<option <?php if(in_array("ALARM",$chk2)) {echo 'selected = "selected"';}?> value="ALARM">ALARM</option>
						<option <?php if(in_array("SEATS",$chk2)) {echo 'selected = "selected"';}?> value="SEATS">SEATS</option>
						<option <?php if(in_array("SEAT BELTS",$chk2)) {echo 'selected = "selected"';}?> value="SEAT BELTS">SEAT BELTS</option>
						<option <?php if(in_array("INTERIOR LIGHT",$chk2)) {echo 'selected = "selected"';}?> value="INTERIOR LIGHT">INTERIOR LIGHT</option>
						<option <?php if(in_array("MIRROR",$chk2)) {echo 'selected = "selected"';}?> value="MIRROR">MIRROR</option>
						<option <?php if(in_array("WARNING LIGHT",$chk2)) {echo 'selected = "selected"';}?> value="WARNING LIGHT">ARNING LIGHT</option>
						<option <?php if(in_array("FUEL LEVELS",$chk2)) {echo 'selected = "selected"';}?> value="FUEL LEVELS">FUEL LEVELS</option>
						<option <?php if(in_array("OIL LEVEL",$chk2)) {echo 'selected = "selected"';}?> value="OIL LEVEL">OIL LEVEL</option>
						<option <?php if(in_array("WASHER FLUIDS",$chk2)) {echo 'selected = "selected"';}?> value="WASHER FLUIDS">WASHER FLUIDS</option>
						<option <?php if(in_array("EMERGANCY ROADSIDE",$chk2)) {echo 'selected = "selected"';}?> value="EMERGANCY ROADSIDE">EMERGANCY ROADSIDE</option>
						
						</select>
					
				</div>
</div>				

				<div class="form-group " align="left">
					
						<label class="control-label">Comment<font color="red">&nbsp;*</font></label>
						<textarea class="form-control" id="comment" name="comment" type="text"  value="<? echo $car_info['comment'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"><? echo $car_info['comment'];?></textarea>
					
				</div>				
				
				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="reset" class="btn btn-warning">Reset</button>
					<button type="reset" onclick="goBack()" class="btn btn-primary">Back</button>
				</div>
				
			</form>
    <script>
        $('#exterior_car').change(function(){
            var opt = $("#exterior_car option:selected" ).val();
            console.log(opt); //output console log
        });
		
        $('#interior_car').change(function(){
            var opt = $("#interior_car option:selected" ).val();
            console.log(opt); //output console log
        });		
    </script>
	
	<script>
				function convertToUppercase(el) {
					if(!el || !el.value) return;
					el.value = el.value.toUpperCase();
				}
			</script>
			
			<script>
				function goBack() {
				  window.history.back();
				}
				</script>

			</div>
			

			
										</div>
							<!-- /.col-lg-12 -->
						</div>
						<!-- /.row -->
						<!-- /.container-fluid -->
					</div>

					<!-- /#page-wrapper -->

				</div>	