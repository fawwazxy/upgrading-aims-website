<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

 $id = $_GET['id'];
 $department_code = $_GET['department_id'];
 $status = $_GET['status'];
 $month = $_GET['month'];
 $car_info = getcarinspectionById1($id)->fetch_assoc();

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
.div {
  padding: 40px;
}

.box {
    background-color: hsla(201, 100%, 6%, 0.6);
    padding: 50px 30px 20px;
    width: 90%;
}

.full-screen-container {
   background-image:url('https://www.meru.in/assets/corporate/inner-pages/images/car-rentals1.png');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
}
label{
	color:white;
}

.ag-format-container {
  width: 1142px;
  margin: 0 auto;
}

.ag-arrow-block {
  padding: 0 0 100px;
}
.ag-arrow_box {
  display: table;
  margin: 30px auto;
  cursor: pointer;
}
.ag-arrow_arrow {
  width: 40px;
  height: 4px;
  margin: 0 0 5px;

  position: relative;
}
.ag-arrow_left {
  display: inline-block;
  margin: 0 0 0 -35px;

  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.ag-arrow_right {
  display: inline-block;
  margin: 0 -35px 0 0;

  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
.ag-arrow_arrow:before,
.ag-arrow_arrow:after {
  content: "";
  height: 100%;
  width: 50%;
  background-color: rgba(255, 255, 255, .35);

  position: absolute;
  top: 0;

  -webkit-animation: an-arrow-lighting-1 1.2s ease-in infinite;
  -moz-animation: an-arrow-lighting-1 1.2s ease-in infinite;
  -o-animation: an-arrow-lighting-1 1.2s ease-in infinite;
  animation: an-arrow-lighting-1 1.2s ease-in infinite;
}
.ag-arrow_arrow:before {
  left: 0;

  -webkit-box-shadow: -.125em 0 .5625em #0c8ca6;
  -moz-box-shadow: -.125em 0 .5625em #0c8ca6;
  -o-box-shadow: -.125em 0 .5625em #0c8ca6;
  box-shadow: -.125em 0 .5625em #0c8ca6;

  -webkit-transform-origin: 0 0;
  -moz-transform-origin: 0 0;
  -o-transform-origin: 0 0;
  transform-origin: 0 0;
}
.ag-arrow_up:before {
  -webkit-transform: skewY(145deg);
  -moz-transform: skewY(145deg);
  -o-transform: skewY(145deg);
  transform: skewY(145deg);
}
.ag-arrow_left:before {
  -webkit-transform: skewY(35deg);
  -moz-transform: skewY(35deg);
  -o-transform: skewY(35deg);
  transform: skewY(35deg);
}

.ag-arrow_right:before {
  -webkit-transform: skewY(35deg);
  -moz-transform: skewY(35deg);
  -o-transform: skewY(35deg);
  transform: skewY(35deg);
}
.ag-arrow_down:before {
  -webkit-transform: skewY(35deg);
  -moz-transform: skewY(35deg);
  -o-transform: skewY(35deg);
  transform: skewY(35deg);
}
.ag-arrow_arrow:after {
  right: 0;

  -webkit-box-shadow: .125em 0 .5625em #0c8ca6;
  -moz-box-shadow: .125em 0 .5625em #0c8ca6;
  -o-box-shadow: .125em 0 .5625em #0c8ca6;
  box-shadow: .125em 0 .5625em #0c8ca6;

  -webkit-transform-origin: 100% 0;
  -moz-transform-origin: 100% 0;
  -o-transform-origin: 100% 0;
  transform-origin: 100% 0;
}
.ag-arrow_up:after {
  -webkit-transform: skewY(-145deg);
  -moz-transform: skewY(-145deg);
  -o-transform: skewY(-145deg);
  transform: skewY(-145deg);
}
.ag-arrow_left:after {
  -webkit-transform: skewY(-35deg);
  -moz-transform: skewY(-35deg);
  -o-transform: skewY(-35deg);
  transform: skewY(-35deg);
}
.ag-arrow_right:after {
  -webkit-transform: skewY(-35deg);
  -moz-transform: skewY(-35deg);
  -o-transform: skewY(-35deg);
  transform: skewY(-35deg);
}
.ag-arrow_down:after {
  -webkit-transform: skewY(-35deg);
  -moz-transform: skewY(-35deg);
  -o-transform: skewY(-35deg);
  transform: skewY(-35deg);
}
.ag-arrow_up-3:before,
.ag-arrow_up-3:after,
.ag-arrow_down-1:before,
.ag-arrow_down-1:after {
  -webkit-animation-name: an-arrow-lighting-1;
  -moz-animation-name: an-arrow-lighting-1;
  -o-animation-name: an-arrow-lighting-1;
  animation-name: an-arrow-lighting-1;
}

.ag-arrow_up-2:before,
.ag-arrow_up-2:after,
.ag-arrow_left-2:before,
.ag-arrow_left-2:after,
.ag-arrow_right-2:before,
.ag-arrow_right-2:after,
.ag-arrow_down-2:before,
.ag-arrow_down-2:after {
  -webkit-animation-name: an-arrow-lighting-2;
  -moz-animation-name: an-arrow-lighting-2;
  -o-animation-name: an-arrow-lighting-2;
  animation-name: an-arrow-lighting-2;
}
.ag-arrow_up-1:before,
.ag-arrow_up-1:after,
.ag-arrow_left-1:before,
.ag-arrow_left-1:after,
.ag-arrow_right-3:before,
.ag-arrow_right-3:after,
.ag-arrow_down-3:before,
.ag-arrow_down-3:after {
  -webkit-animation-name: an-arrow-lighting-3;
  -moz-animation-name: an-arrow-lighting-3;
  -o-animation-name: an-arrow-lighting-3;
  animation-name: an-arrow-lighting-3;
}

@-webkit-keyframes an-arrow-lighting-1 {
  0%,
  0% {
    background-color: rgba(255, 255, 255, .35);
  }
  25%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-moz-keyframes an-arrow-lighting-1 {
  0%,
  0% {
    background-color: rgba(255, 255, 255, .35);
  }
  25%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-o-keyframes an-arrow-lighting-1 {
  0%,
  0% {
    background-color: rgba(255, 255, 255, .35);
  }
  25%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@keyframes an-arrow-lighting-1 {
  0%,
  0% {
    background-color: rgba(255, 255, 255, .35);
  }
  25%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}

@-webkit-keyframes an-arrow-lighting-2 {
  0%,
  25% {
    background-color: rgba(255, 255, 255, .35);
  }
  50%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-moz-keyframes an-arrow-lighting-2 {
  0%,
  25% {
    background-color: rgba(255, 255, 255, .35);
  }
  50%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-o-keyframes an-arrow-lighting-2 {
  0%,
  25% {
    background-color: rgba(255, 255, 255, .35);
  }
  50%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@keyframes an-arrow-lighting-2 {
  0%,
  25% {
    background-color: rgba(255, 255, 255, .35);
  }
  50%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}

@-webkit-keyframes an-arrow-lighting-3 {
  0%,
  50% {
    background-color: rgba(255, 255, 255, .35);
  }
  75%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-moz-keyframes an-arrow-lighting-3 {
  0%,
  50% {
    background-color: rgba(255, 255, 255, .35);
  }
  75%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@-o-keyframes an-arrow-lighting-3 {
  0%,
  50% {
    background-color: rgba(255, 255, 255, .35);
  }
  75%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}
@keyframes an-arrow-lighting-3 {
  0%,
  50% {
    background-color: rgba(255, 255, 255, .35);
  }
  75%,
  75% {
    background-color: #FFF;
  }
  100% {
    background-color: rgba(255, 255, 255, .35);

    -webkit-animation-timing-function: ease-out;
    -moz-animation-timing-function: ease-out;
    -o-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
  }
}

/* new arrows */
/*
* Prefixed by https://autoprefixer.github.io
* PostCSS: v7.0.29,
* Autoprefixer: v9.7.6
* Browsers: last 100 version
*/

@font-face {
  font-family: Icons;
  src: url(https://raw.githubusercontent.com/SochavaAG/example-mycode/master/pens/animation-arrow/fonts/icons/Icons.eot);
  src: url(https://raw.githubusercontent.com/SochavaAG/example-mycode/master/pens/animation-arrow/fonts/icons/Icons.eot?#iefix) format("embedded-opentype"),
  url(https://raw.githubusercontent.com/SochavaAG/example-mycode/master/pens/animation-arrow/fonts/icons/Icons.woff) format("woff"),
  url(https://raw.githubusercontent.com/SochavaAG/example-mycode/master/pens/animation-arrow/fonts/icons/Icons.ttf) format("truetype"),
  url(https://raw.githubusercontent.com/SochavaAG/example-mycode/master/pens/animation-arrow/fonts/icons/Icons.svg#Icons) format("svg");
  font-weight: 400;
  font-style: normal;
  font-display: swap;
}
.ag-n-arrow_icon {
  display: inline-block;
  line-height: 1;

  vertical-align: middle;
  font-family: Icons, sans-serif;
  font-weight: 400;
  font-style: normal;
  color: #FFF;

  font-variant: normal;
  text-rendering: auto;

  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
}
.ag-n-arrow_icon-b:before {
  content: "\E001";
}
.ag-n-arrow_icon-b-1:before {
  content: "\E002";
}
.ag-n-arrow_icon-l:before {
  content: "\E003";
}
.ag-n-arrow_icon-r:before {
  content: "\E004";
}
.ag-n-arrow_icon-r-1:before {
  content: "\E005";
}
.ag-n-arrow_icon-r-2:before {
  content: "\E006";
}

.ag-n-arrow_box {
  display: inline-block;
  padding: 0 100px 100px;
}

.ag-n-arrow_prev,
.ag-n-arrow_next {
  display: inline-block;

  vertical-align: top;
  color: #FFF;
}
.ag-n-arrow_prev {
  -webkit-transform: translateY(-50%) scaleY(-1);
  -moz-transform: translateY(-50%) scaleY(-1);
  -ms-transform: translateY(-50%) scaleY(-1);
  -o-transform: translateY(-50%) scaleY(-1);
  transform: translateY(-50%) scaleY(-1);
}
.ag-n-arrow_right {
  display: inline-block;
  margin: 0 100px 0 0;
}
.ag-n-arrow_left {
  display: inline-block;

  -webkit-transform: scaleX(-1);
  -moz-transform: scaleX(-1);
  -ms-transform: scaleX(-1);
  -o-transform: scaleX(-1);
  transform: scaleX(-1);
}
.ag-n-arrow_icon {
  display: block;
  line-height: 1;

  font-size: .8em;

  position: relative;
}
.ag-n-arrow_icon-vertical {
  -webkit-animation: an-arrow-vertical 1.5s infinite;
  -moz-animation: an-arrow-vertical 1.5s infinite;
  -o-animation: an-arrow-vertical 1.5s infinite;
  animation: an-arrow-vertical 1.5s infinite;
}
.ag-n-arrow_icon-horizontal {
  display: inline-block;

  -webkit-animation: an-arrow-horizontal 1.5s infinite;
  -moz-animation: an-arrow-horizontal 1.5s infinite;
  -o-animation: an-arrow-horizontal 1.5s infinite;
  animation: an-arrow-horizontal 1.5s infinite;
}
.ag-n-arrow_icon:nth-child(2) {
  -webkit-animation-delay: -.2s;
  -moz-animation-delay: -.2s;
  -o-animation-delay: -.2s;
  animation-delay: -.2s;
}
.ag-n-arrow_icon:nth-child(3) {
  -webkit-animation-delay: -.4s;
  -moz-animation-delay: -.4s;
  -o-animation-delay: -.4s;
  animation-delay: -.4s;
}

@-webkit-keyframes an-arrow-vertical {
  0% {
    opacity: 0;

    -webkit-transform: translateY(-20px);
    transform: translateY(-20px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -webkit-transform: translateY(20px);
    transform: translateY(20px);
  }
}
@-moz-keyframes an-arrow-vertical {
  0% {
    opacity: 0;

    -moz-transform: translateY(-20px);
    transform: translateY(-20px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -moz-transform: translateY(20px);
    transform: translateY(20px);
  }
}
@-o-keyframes an-arrow-vertical {
  0% {
    opacity: 0;

    -o-transform: translateY(-20px);
    transform: translateY(-20px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -o-transform: translateY(20px);
    transform: translateY(20px);
  }
}
@keyframes an-arrow-vertical {
  0% {
    opacity: 0;

    -webkit-transform: translateY(-20px);
    -moz-transform: translateY(-20px);
    -o-transform: translateY(-20px);
    transform: translateY(-20px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -webkit-transform: translateY(20px);
    -moz-transform: translateY(20px);
    -o-transform: translateY(20px);
    transform: translateY(20px);
  }
}

@-webkit-keyframes an-arrow-horizontal {
  0% {
    opacity: 0;

    -webkit-transform: translateX(2px);
    transform: translateX(2px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -webkit-transform: translateX(-2px);
    transform: translateX(-2px);
  }
}
@-moz-keyframes an-arrow-horizontal {
  0% {
    opacity: 0;

    -moz-transform: translateX(2px);
    transform: translateX(2px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -moz-transform: translateX(-2px);
    transform: translateX(-2px);
  }
}
@-o-keyframes an-arrow-horizontal {
  0% {
    opacity: 0;

    -o-transform: translateX(2px);
    transform: translateX(2px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -o-transform: translateX(-2px);
    transform: translateX(-2px);
  }
}
@keyframes an-arrow-horizontal {
  0% {
    opacity: 0;

    -webkit-transform: translateX(2px);
    -moz-transform: translateX(2px);
    -o-transform: translateX(2px);
    transform: translateX(2px);
  }
  50% {
    opacity: 1;
  }
  to {
    opacity: 0;

    -webkit-transform: translateX(-2px);
    -moz-transform: translateX(-2px);
    -o-transform: translateX(-2px);
    transform: translateX(-2px);
  }
}
/* /new arrows */


@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}

@media only screen and (max-width: 639px) {

}

@media only screen and (max-width: 479px) {

}

@media (min-width: 768px) and (max-width: 979px) {
  .ag-format-container {
    width: 750px;
  }

}

@media (min-width: 980px) and (max-width: 1161px) {
  .ag-format-container {
    width: 960px;
  }

}

</style>
</style>

<body>





    <div id="wrapper">
   
             
				<div class="full-screen-container">
				
				<div  align="left" style="margin-right:30px;margin-left:-40px">
				 <div class="ag-arrow_box">
				  <div class="ag-arrow_arrow ag-arrow_left ag-arrow_left-1" onclick="goBack()" title="Back"></div>
				  <div class="ag-arrow_arrow ag-arrow_left ag-arrow_left-2" onclick="goBack()" title="Back"></div>
				  <div class="ag-arrow_arrow ag-arrow_left ag-arrow_left-3" onclick="goBack()" title="Back"></div>
				</div>
				</div>

                    <div class="box">
					<form method="post" action="../controller/aims_car_inspection_update1_exec.php?id=<? echo $id ?>">
					
					 <input type="hidden" name="id" value="<? echo $id ?>">
					<input type="hidden" name="department_id" value="<?php echo $department_code ?>">
					<input type="hidden" name="name" value="<?php echo $car_info['created_name'] ?>">
					<input type="hidden" name="status" value="<?php echo $status ?>">
					<input type="hidden" name="month" value="<?php echo $month ?>">
    

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
				
				<div class="form-group " align="left">
					<div class="col-xs-6">
						<label class="control-label">Depature milage<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="dep_milage" name="dep_milage" type="text" value="<?php echo $car_info['dep_milage'];?>" />
					</div>	
					<div class="col-xs-6">
						<label class="control-label">Return milage<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="return_milage" name="return_milage" type="text" value="<?php echo $car_info['return_milage'];?>" />
					</div>
				</div>
				
				<?php
				
				
			$conn=db();
			$sql = "SELECT * from aims_car_inspection_bycompany
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
					
						<label class="control-label">Vehicle Requirement Item<font color="red">&nbsp;*</font></label><br>
						<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MIRROR" <?php if(in_array("MIRROR",$chk)){echo "checked";}?> />  mirror</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="BODY"<?php if(in_array("BODY",$chk)) {echo "checked";}?> />    body</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("LAMP",$chk)){echo "checked";}?> value="LAMP"/>    lamp </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SEAT",$chk)) {echo "checked";}?> value="SEAT"/>   seat</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("ENGINE",$chk)) {echo "checked";}?> value="ENGINE"/>   engine</label><br> 
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RIM",$chk)) {echo "checked";}?> value="RIM"/>   RIM </label>
						</div>
						<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("DASHBOARD",$chk)){echo "checked";}?> value="DASHBOARD"/>   Dashboard</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("CANVAS",$chk)) {echo "checked";}?> value="CANVAS"/>   Canvas</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("TYRE",$chk)) {echo "checked";}?> value="TYRE"/>   Tyre </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SERVICE BOOKLET",$chk)) {echo "checked";}?> value="SERVICE BOOKLET"/> Service Booklet</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RADIO",$chk)) {echo "checked";}?> value="RADIO"/> Radio</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("CIGARETTE LIGHTER",$chk)) {echo "checked";}?> value="CIGARETTE LIGHTER"/> Cigarette Lighter</label>
						</div>
						<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("JACK",$chk)) {echo "checked";}?> value="JACK"/> Jack</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("TOOL KITS",$chk)) {echo "checked";}?> value="TOOL KITS"/> Tool Kit</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("SPARE TYRE",$chk)) {echo "checked";}?> value="SPARE TYRE"/> Spare Tyre </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("HUB CAP",$chk)) {echo "checked";}?> value="HUB CAP"/> Hub Cap</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("MUD FLAP",$chk)) {echo "checked";}?> value="MUD FLAP"/> Mud Flap</label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  <?php if(in_array("RADIO FREQ",$chk)) {echo "checked";}?> value="RADIO FREQ"/> Radio Freq</label>
						</div>
				</div>
				
				
				
				
				<div class="form-group " align="left">
				        
						<div class="label1">
						<label class="control-label">Exterior Part Of Vehicle</label>
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
						<label class="control-label">Interior Part Of Vehicle</label>
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

			</div>
			

			
										</div>
							<!-- /.col-lg-12 -->
						</div>
						<!-- /.row -->
						<!-- /.container-fluid -->
					

					<!-- /#page-wrapper -->

			