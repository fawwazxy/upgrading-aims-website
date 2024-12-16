<?php

include ('../controller/auth.php');


require "../model/aims_carReserve_function.php";
require "../model/lookup.php";


$id = $_POST['id'];
$car_info = getcarRequestById($id)->fetch_assoc();
?>



<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>APPLICANT NAME</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['name'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>JAWATAN</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['jawatan'].'</b>';?>
    </div>
</div>



<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>DRIVER NAME</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['drivername'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>PURPOSE</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['purpose'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>DESTINATION</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['destination'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>COMPANY</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['description'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>TYPE OF CAR</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['car_type'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>NO. PASSENGERS</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['no_passengers'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>PLATE NO</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['car_plate_no'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>DEPARTURE DATE</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['dep_date'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>DEPARTURE TIME</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['dep_time'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>DEPARTURE MILEAGE</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['dep_milage'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>RETURN DATE</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['return_date'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>RETURN TIME</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['return_time'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>RETURN MILEAGE</label>
    </div>
<div class="col-xs-8">
       <?echo '<b>'.$car_info['return_milage'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>CREATED DATE</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['created_date'].'</b>';?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>CREATED BY</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$car_info['created_by'].'</b>';?>
    </div>
</div>


<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>APPROVE BY</label>
    </div>
    <div class="col-xs-8">
        <?'<b>'.$carinfo = $car_info['approve_by'];
		if($carinfo == PENDING){
		echo "<span style='color:red'><b>*Pending from SBU/HOD</b></span>";
		}
		else{
	    echo $carinfo; } ?>
    </div>
</div>


<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>STATUS APPROVAL SBU/HOD</label>
    </div>
    <div class="col-xs-8">
       <?'<b>'.$car_info['sbu_hod_app'].'</b>';
	   if($car_info['sbu_hod_app']=="PENDING"){
	   echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
	   else if ($car_info['sbu_hod_app']=="APPROVE"){
		   echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
	   ;}
	   else{
		   echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>"
	   ;}'</b>'?>
		   
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>ADMIN APPROVAL</label>
    </div>
    <div class="col-xs-8">
       <?'<b>'.$car_info['app_status'].'</b>';
	   if($car_info['app_status']=="PENDING"){
	   echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
	   else if ($car_info['app_status']=="APPROVE"){
		   echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>APPROVED</span>"
	   ;}
	   else{
		   echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVE</span>"
	   ;}'</b>'?>
		   
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>STATUS INCPECTION</label>
    </div>
    <div class="col-xs-8">
       <?'<b>'.$car_info['status_incep'].'</b>';
	   if($car_info['status_incep'] == 'NO'){
	   echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>NO</span>";}
	   else{
		   echo"<span style='background-color:Blue;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>Yes</span>"
	   ;}'</b>'?>
		   
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>HEALTH STATUS</label>
    </div>
    <div class="col-xs-8">
       <?'<b>'.$car_info['health_status'].'</b>';
	   if($car_info['health_status'] == 'Fit_To_Travel'){
	   echo"<span style='padding:5px;font-weight:bold;color:black;'>FIT TO TRAVEL</span>";}
	   else if ($car_info['health_status'] == 'Not_Fit_To_Travel'){
		   echo"<span style='padding:5px;font-weight:bold;color:black;'>NOT FIT TO TRAVEL</span>"
	   ;}
	   else{
		   echo"<span style='padding:5px; font-weight:bold;color:black;'>-</span>"
	   ;}'</b>'?>
		   
    </div>
</div>


<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
