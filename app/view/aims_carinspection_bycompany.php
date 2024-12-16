<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

 $car_plate_no = $_GET['car_plate_no'];
 $department_code = $_GET['department_id'];
 $status = $_GET['status'];
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
	padding:30px;
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
					<form method="post" action="../controller/aims_car_inspectionbycompany_exec.php" >
					<input id="created_name" name="created_name" type="hidden" value="<?php echo $_SESSION['SESS_NAME']?>"/>
					<input id="status" name="status" type="hidden" value="<?php echo $status?>"/>
	
    

				<div class="form-group " align="left">
				
						<label class="control-label">Date<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="dep_date" name="dep_date" type="date" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					
				</div>


				<div class="form-group " align="left">
					
						<label class="control-label">Plate No<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="car_plate_no" name="car_plate_no" type="text" value="<?php echo $car_plate_no?>" readonly/>
						<input type="hidden" name="department_id" value="<?php echo $department_code ?>">
					
				</div>
				
				<div class="form-group " align="left">
				
						<label class="control-label">Fuel<font color="red">&nbsp;*</font></label>
						<select class ="form-control" id="fuel" name="fuel">
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
						<input class="form-control" id="dep_milage" name="dep_milage" type="text" value="" />
					</div>	
					<div class="col-xs-6">
						<label class="control-label">Return milage<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="return_milage" name="return_milage" type="text" value="" />
					</div>
				</div>
				
				
				<div class="form-group " align="left" >
					
						<label class="control-label">Vehicle Requirement Item<font color="red">&nbsp;*</font></label><br>
				<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MIRROR"/>  mirror</label> <br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="BODY"/>    body</label> <br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="LAMP"/>    lamp </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SEAT"/>   seat </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="ENGINE"/>   engine </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RIM"/>   RIM </label>
				</div>
				<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="DASHBOARD"/>   Dashboard </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="CANVAS"/>   Canvas </label><br> 
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="TYRE"/>   Tyre </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SERVICE BOOKLET"/> Service Booklet </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RADIO"/> Radio </label><br>		
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="CIGARETTE LIGHTER"/> Cigarette Lighter</label> 
						
				</div>
						
						
				<div class="column">
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="JACK"/> Jack </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="TOOL KITS"/> Tool Kit </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="SPARE TYRE"/> Spare  </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="HUB CAP"/> Hub Cap </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="MUD FLAP"/> Mud Flap </label><br>
						<label><input id="hd_vehicle" name="hd_vehicle[]" type="checkbox"  value="RADIO FREQ"/> Radio Freq</label>
				</div>	
				</div>

				<div class="form-group " align="left" >
				<br>       
						
				<div class="label1">
				    <label class="control-label">Exterior Part Of Vehicle</label>
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
					
						<label class="control-label">Comment<font color="red">&nbsp;*</font></label>
						<textarea class="form-control" id="comment1" name="comment1" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></textarea>
					
				</div>							



  <br>  
<div class="label1">
    <label class="control-label">Interior Part Of Vehicle</label>
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
					
						<label class="control-label">Comment<font color="red">&nbsp;*</font></label>
						<textarea class="form-control" id="comment" name="comment" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></textarea>
					
				</div>

                </div>
				
				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="reset" class="btn btn-warning">Reset</button>
				</div>
				
			</form>
			</div>
			</div>
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
			


				