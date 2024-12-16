<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$raw_data1 = getcarRequestById($id)->fetch_assoc();
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
                    <h1 class="page-header">Vehicle Inspection Form</h1>
                </div>
            </div>

            <div class="form-group" align="right">
            </div>
            
             
             <div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
					<form method="post" action="../controller/aims_car_inspection_exec.php">
					
					<input id="reserve_id" name="reserve_id" type="hidden" value="<?php echo $id?>"/>
					<input id="name" name="name" type="hidden" value="<?php echo $_SESSION['SESS_NAME']?>"/>
	
				<div class="form-group " align="left">
				
						<label class="control-label">Status Inception</label>
						<input id="status_incep" name="status_incep" type="radio" <?php if($raw_data1['status_incep']=="YES") {echo "checked";}?> value="YES"/>   YES
						<input id="status_incep" name="status_incep" type="radio" <?php if($raw_data1['status_incep']=="NO") {echo "checked";}?> value="NO"/>   NO 
					
				</div>


				<div class="form-group " align="left">
				
						<label class="control-label">Date</label>
						<input class="form-control" id="dep_date" name="dep_date" type="date" value="<?php echo $raw_data1['dep_date']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>


				<div class="form-group " align="left">
					
						<label class="control-label">Plate No</label>
						<select  required class="form-control" name="car_plate_no" id="department_name">
									<option value="">-- Choose Car Plate --</option>
									<? echo getDropDownCarplate($raw_data1['car_plate_no']);?>
						</select>
					
				</div>
				
				<div class="form-group " align="left">
				
						<label class="control-label">Fuel</label>
						<select class ="form-control" id="fuel" name="fuel">
						<option value="E">E</option>
						<option value="1/4">1/4</option>
						<option value="1/2">1/2</option>
						<option value="3/4">3/4</option>
						<option value="F">F</option>
						</select>
					
				</div>
				
				
				<div class="form-group " align="left" >
					
						<label class="control-label">Car Requirement</label><br>
				<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MIRROR"/>  mirror <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="BODY"/>    body <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="LAMP"/>    lamp <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SEAT"/>   seat <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="ENGINE"/>   engine <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RIM"/>   RIM
				</div>
				<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="DASHBOARD"/>   Dashboard <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="CANVAS"/>   Canvas <br> 
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="TYRE"/>   Tyre <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SERVICE BOOKLET"/> Service Booklet <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RADIO"/> Radio <br>		
						<label class="checkbox-inline"><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="CIGARETTE LIGHTER"/> Cigarette Lighter 
						
				</div>
						
						
				<div class="column">
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="JACK"/> Jack <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="TOOL KITS"/> Tool Kit <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SPARE TYRE"/> Spare  <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="HUB CAP"/> Hub Cap <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MUD FLAP"/> Mud Flap <br>
						<input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RADIO FREQ"/> Radio Freq
				</div>	
				</div>

				<div class="form-group " align="left" >
				<br>       
						
				<div class="label1">
						<br><font color="red">&nbsp;FOR SELECT MULTIPLE PRESS CTRL WHILE SELECT</font><br>
						<select class ="form-control" name="exterior_car[]" id="exterior_car" multiple>
						<option value="WINDOW/WINDSHIELD">WINDOW/WINDSHIELD</option>
						<option value="WINDSHEILD WIPERS">WINDSHEILD WIPERS</option>
						<option value="HEADLIGHTS">HEADLIGHTS</option>
						<option value="TAIL LIGHT/ BARKE LIGHT">TAIL LIGHT/ BARKE LIGHT</option>
						<option value="EMERGENCY BRAKE">EMERGENCY BRAKE</option>
						<option value="POWER BRAKE">POWER BRAKE</option>
						<option value="HORN & HAZARD LIGHT">HORN & HAZARD LIGHT</option>
						<option value="TIRE">TIRE</option>
						<option value="AIR LEAKS/ODOUR OF GASOLINE">AIR LEAKS/ODOUR OF GASOLINE</option>
						<option value="OIL/GREASE LEAKS">OIL/GREASE LEAKS</option>
						<option value="MIRROR">MIRROR</option>
						<option value="EXHAUST SYSTEM">EXHAUST SYSTEM</option>
						<option value="WHEELS AND FASTENERS">WHEELS AND FASTENERS</option>
						<option value="SIGNAL LIGHT">SIGNAL LIGHT</option>
						
						</select>
				</div>		
				<div class="form-group " align="left">
					
						<label class="control-label">Comment</label>
						<textarea class="form-control" id="comment1" name="comment1" type="text" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></textarea>
					
				</div>							



  <br>  
<div class="label1">
						<br><font color="red">&nbsp;FOR SELECT MULTIPLE PRESS CTRL WHILE SELECT</font><br>
						<select class ="form-control" name="interior_car[]" id="interior_car" multiple>
						<option value="HEATING">HEATING</option>
						<option value="AIR CONDITION">AIR CONDITION</option>
						<option value="WINDSHEILD DEFOGGING SYSTEM">WINDSHEILD DEFOGGING SYSTEM</option>
						<option value="WINDOW OPERATION">WINDOW OPERATION</option>
						<option value="DOOR HANDLES/LOCKS">DOOR HANDLES/LOCKS</option>
						<option value="ALARM">ALARM</option>
						<option value="SEATS">SEATS</option>
						<option value="SEAT BELTS">SEAT BELTS</option>
						<option value="INTERIOR LIGHT">INTERIOR LIGHT</option>
						<option value="MIRROR">MIRROR</option>
						<option value="WARNING LIGHT">ARNING LIGHT</option>
						<option value="FUEL LEVELS">FUEL LEVELS</option>
						<option value="OIL LEVEL">OIL LEVEL</option>
						<option value="WASHER FLUIDS">WASHER FLUIDS</option>
						<option value="EMERGANCY ROADSIDE">EMERGANCY ROADSIDE</option>
						
						</select>
				</div>		
				<div class="form-group " align="left">
					
						<label class="control-label">Comment</label>
						<textarea class="form-control" id="comment" name="comment" type="text"  style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></textarea>
					
				</div>

                </div>
					
					

				
				
				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="reset" class="btn btn-warning">Reset</button>
					<button type="reset" onclick="goBack()" class="btn btn-primary">Back</button>
				</div>
			</div>	
			</form>
			</div>
			
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
							<!-- /.col-lg-12 -->
						</div>
						<!-- /.row -->
						<!-- /.container-fluid -->
					</div>

					<!-- /#page-wrapper -->

				</div>