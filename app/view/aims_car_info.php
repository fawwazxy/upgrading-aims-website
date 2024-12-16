<?php

include ('../controller/auth.php');
require "../model/aims_car_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarById($id)->fetch_assoc();
//$car_mileage = getmilagecarById($id)->fetch_assoc();
//$current_mileage = ($car_mileage) ?: $car_info['current_mileage'];
?>
<div class="form-group row">
    <div class="car-card" style="height: auto; margin: 0 64px">
        <?if(in_array($car_info['document_type'], ['jpg', 'jpeg', 'png', 'gif'])) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $car_info['document'] ).'" alt="car-image"/><br>';
        }else if($car_info['document_type'] == 'pdf') {
            echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $car_info['document'] ).'" type="application/pdf"></object>';
        }else{
            echo '<img src="../car_photo/default-car-image.png" alt="car-default"/>';
        }
        ?>
    </div>
</div>

<div class="boxes">VEHICLE PROFILE</div>
<div class="form-group row text-center">
    <div class="col-xs-2 col-xs-offset-1">
        <label>OWNER</label><br>
        <? echo $car_info['car_owner'];?>
    </div>
    <div class="col-xs-2">
        <label>MODEL</label><br>
        <? echo $car_info['car_model'];?>
    </div>
    <div class="col-xs-2">
        <label>TYPE OF CAR</label><br>
        <? echo $car_info['car_type'];?>
    </div>
    <div class="col-xs-2">
        <label>PLATE NO</label><br>
        <? echo $car_info['car_plate_no'];?>
    </div>
    <div class="col-xs-2">
        <label>COLOR</label><br>
        <? echo $car_info['color'];?>
    </div>
</div>

<div class="boxes">PERSON IN CHARGE</div>
<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>PIC 1</label><br>
        <? echo $car_info['car_pic'];?>
    </div>
    <div class="col-xs-6">
        <label>PIC 2</label><br>
        <? echo $car_info['car_pic2'];?>
    </div>
</div>

<div class="boxes">VEHICLE INFORMATION</div>
<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>ENGINE NO</label><br>
        <? echo $car_info['engine_no'];?>
    </div>

    <div class="col-xs-6">
        <label>CHASSIS NO</label><br>
        <? echo $car_info['chassis_no'];?>
    </div>
</div>

<div class="form-group row text-center">
    <div class="col-xs-3">
        <label>PURCHASE VALUE</label><br>
        <? echo $car_info['cost_receipt'];?>
    </div>
    <div class="col-xs-3">
        <label>PURCHASE DATE</label><br>
        <? echo $car_info['date_receipt'];?>
    </div>
    <div class="col-xs-6">
        <label>SUPPLIERS</label><br>
        <? echo $car_info['suppliers'];?>
    </div>
</div>

<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>HIRE PURCHASE NO</label><br>
        <? echo $car_info['hire_account_no'];?>
    </div>

    <div class="col-xs-6">
        <label>ACCOUNT NAME</label><br>
        <? echo $car_info['name_account'];?>
    </div>
</div>

<div class="boxes">SERVICE INFORMATION</div>
<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>LAST SERVICE</label><br>
        <? echo $car_info['last_service'];?>
    </div>

    <div class="col-xs-6">
        <label>NEXT SERVICE</label><br>
        <? echo $car_info['next_service'];?>
    </div>
</div>

<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>CURRENT MILEAGE</label><br>
        <? echo $car_info['current_mileage'];?>
    </div>

    <div class="col-xs-6">
        <label>NEXT MILEAGE SERVICE</label><br>
        <? echo $car_info['next_mileage'];?>
    </div>
</div>

<div class="boxes">ROADTAX</div>
<div class="form-group row text-center">
    <div class="col-xs-6">
        <label>DATE EXPIRED</label><br>
        <? echo date('d/m/Y', strtotime($car_info['date_ex_rtx']));?>
    </div>

    <div class="col-xs-6">
        <label>VALUE</label><br>
        <? echo 'RM'.$car_info['value_rtx'];?>
    </div>
</div>

<div class="boxes">INSURANCE (PASSENGER)</div>
<div class="form-group row text-center">
    <div class="col-xs-4">
        <label>DATE EXPIRED</label><br>
        <? echo date('d/m/Y', strtotime($car_info['date_ex_ins']));?>
    </div>
    <div class="col-xs-4">
        <label>VALUE</label><br>
        <? echo 'RM '.$car_info['value_ins'];?>
    </div>
    <div class="col-xs-4">
        <label>TYPE OF INSURANCE</label><br>
        <? echo $car_info['type_ins'];?>
    </div>
</div>
<div class="boxes">INSURANCE (PRIVATE)</div>

<div class="form-group row text-center">
    <div class="col-xs-4">
        <label>DATE EXPIRED</label><br>
        <? echo date('d/m/Y', strtotime($car_info['date_ex_priv']));?>
    </div>
    <div class="col-xs-4">
        <label>VALUE</label><br>
        <? echo 'RM '.$car_info['value_priv'];?>
    </div>
    <div class="col-xs-4">
        <label>VALUE</label><br>
        <? echo 'RM '.$car_info['sum_priv'];?>
    </div>
</div>