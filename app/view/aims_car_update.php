<?php

include ('../controller/auth.php');
require "../model/aims_car_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$car_info = getcarById($id)->fetch_assoc();
//$return_mileage = getmilagecarById($id)->fetch_object()->return_milage;
//$current_mileage = ($return_mileage) ?: $car_info['current_mileage'];
$current_mileage = $car_info['current_mileage'];
?>
<form method="post" action="../controller/aims_car_update_exec.php" enctype="multipart/form-data">
    <input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
    <input type="hidden" name="id" value="<?php echo $car_info['id']; ?>">

    <div class="form-group row">
        <div class="car-card" style="height: auto; padding-bottom: 16px; margin: 0 64px">
            <?if(in_array($car_info['document_type'], ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $car_info['document'] ).'" alt="car-image"/><br>';
            }else if($car_info['document_type'] == 'pdf') {
                echo '<object width="200" height="100" data="data:application/pdf;base64,'.base64_encode( $car_info['document'] ).'" type="application/pdf"></object>';
            }else{
                echo '<img src="../car_photo/default-car-image.png" alt="car-default"/>';
            }
            ?>
            <div class="car-container">
                <h5><? echo $car_info['document_name'] ?></h5>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <input type="file" class="btn btn-default btn-block" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
            </div>
        </div>
    </div>

    <label style="color: red">* Required Information</label>
    <br>

    <h6>VEHICLE PROFILE</h6>
    <div class="form-group row">
        <div class="col-xs-6">
            <label for="car_model">MODEL&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="car_model" id="car_model" value="<? echo $car_info['car_model'];?>">
        </div>

        <div class="col-xs-6">
            <label for="car_owner">OWNER&nbsp;<span style="color: red; ">*</span></label>
            <select required class="form-control" name="car_owner" id="car_owner">
                <option value="">-- Choose Owner --</option>
                <? echo getDropDownCompany2($car_info['car_owner']);?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="car_type">TYPE OF CAR&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="car_type" id="car_type" value="<? echo $car_info['car_type'];?>">
        </div>
        <div class="col-xs-4">
            <label for="car_plate_no">PLATE NO&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="car_plate_no" id="car_plate_no" value="<? echo $car_info['car_plate_no'];?>">
        </div>
        <div class="col-xs-4">
            <label for="color">COLOR&nbsp;<span style="color: red;">*</span></label>
            <input class="form-control" placeholder="" name="color" id="color" value="<? echo $car_info['color'];?>" >
        </div>
    </div>

    <h6>PERSON IN CHARGE</h6>
    <div class="form-group row">
        <div class="col-xs-6">
            <label for="car_pic">PIC 1&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" list="pic1" name="car_pic" id="car_pic" value="<? echo $car_info['car_pic'];?>"/>
            <datalist id="pic1">
                <option value="">-- Choose Name --</option>
                <? echo getdropdownstaff($car_info['car_pic'])?>
            </datalist>
        </div>
        <div class="col-xs-6">
            <label for="car_pic2">PIC 2&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" list="pic2" id="car_pic2" name="car_pic2" value="<? echo $car_info['car_pic2'];?>"/>
            <datalist id="pic2">
                <option value="">-- Choose Name --</option>
                <? echo getdropdownstaff($car_info['car_pic2'])?>
            </datalist>
        </div>
    </div>

    <h6>VEHICLE INFORMATION</h6>
    <div class="form-group row">
        <div class="col-xs-6">
            <label for="engine_no">ENGINE NO&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="engine_no" id="engine_no" value="<? echo $car_info['engine_no'];?>" >
        </div>

        <div class="col-xs-6">
            <label for="chassis_no">CHASSIS NO&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="chassis_no" id="chassis_no" value="<? echo $car_info['chassis_no'];?>" >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3">
            <label for="cost_receipt">COST RECEIPT&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="cost_receipt" id="cost_receipt" value="<? echo $car_info['cost_receipt'];?>" >
        </div>
        <div class="col-xs-3">
            <label for="date_receipt">PURCHASING DATE&nbsp;<span style="color: red; ">*</span></label>
            <input type="date" class="form-control" placeholder="" name="date_receipt" id="date_receipt" value="<? echo $car_info['date_receipt'];?>" >
        </div>
        <div class="col-xs-6">
            <label for="suppliers">SUPPLIERS&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="suppliers" id="suppliers" value="<? echo $car_info['suppliers'];?>" >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="hire_account_no">HIRE PURCHASE NO</label>
            <input class="form-control" placeholder="" name="hire_account_no" id="hire_account_no" value="<? echo $car_info['hire_account_no'];?>" >
        </div>

        <div class="col-xs-6">
            <label for="name_account">ACCOUNT NAME</label>
            <input class="form-control" placeholder="" name="name_account" id="name_account" value="<? echo $car_info['name_account'];?>" >
        </div>
    </div>

    <h6>SERVICE INFORMATION</h6>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="last_service">LAST SERVICE<span style="color: red; ">*</span>&nbsp;</label>
            <input class="form-control" type="date" name="last_service" id="last_service" value="<? echo $car_info['last_service'];?>" >
        </div>

        <div class="col-xs-6">
            <label for="next_service">NEXT SERVICE&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="date" name="next_service" id="next_service" value="<? echo $car_info['next_service'];?>" >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="current_mileage">CURRENT MILEAGE&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder="" name="current_mileage" id="current_mileage" value="<? echo $current_mileage;?>" >
        </div>

        <div class="col-xs-6">
            <label for="next_mileage">NEXT MILEAGE SERVICE&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" placeholder=" " name="next_mileage" id="next_mileage" value="<? echo $car_info['next_mileage'];?>" >
        </div>
    </div>

    <h6>ROADTAX</h6>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="date_ex_rtx">DATE EXPIRED&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="date" name="date_ex_rtx" id="date_ex_rtx" value="<? echo $car_info['date_ex_rtx'];?>" >
        </div>

        <div class="col-xs-6">
            <label for="value_rtx">VALUE (RM)&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="text" name="value_rtx" id="value_rtx" value="<? echo $car_info['value_rtx'];?>" >
        </div>
    </div>

    <h6>INSURANCE PASSENGER</h6>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="date_ex_ins">DATE EXPIRED&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="date" name="date_ex_ins" id="date_ex_ins" value="<? echo $car_info['date_ex_ins'];?>">
        </div>
        <div class="col-xs-4">
            <label for="value_ins">VALUE (RM)&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="text" name="value_ins" id="value_ins" value="<? echo $car_info['value_ins'];?>">
        </div>
        <div class="col-xs-4">
            <label for="type_ins">TYPE OF INSURANCE&nbsp;<span style="color: red; ">*</span></label>
            <select id="type_ins" name="type_ins" class="form-control" value="">
                <option value="PLATINUM" <? if ($car_info['type_ins'] == 'PLATINUM') echo 'selected'; ?>>PLATINUM</option>
                <option value="PREMIUM" <? if ($car_info['type_ins'] == 'PREMIUM') echo 'selected'; ?>>PREMIUM</option>
                <option value="GOLD" <? if ($car_info['type_ins'] == 'GOLD') echo 'selected'; ?>>GOLD</option>
            </select>
        </div>
    </div>

    <h6>INSURANCE PRIVATE</h6>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="date_ex_priv">DATE EXPIRED&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="date" name="date_ex_priv" id="date_ex_priv" value="<? echo $car_info['date_ex_priv'];?>">
        </div>
        <div class="col-xs-4">
            <label for="value_priv">VALUE (RM)&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="text" name="value_priv" id="value_priv" value="<? echo $car_info['value_priv'];?>">
        </div>
        <div class="col-xs-4">
            <label for="sum_priv">SUM COVERED (RM)&nbsp;<span style="color: red; ">*</span></label>
            <input class="form-control" type="text" name="sum_priv" id="sum_priv" value="<? echo $car_info['sum_priv'];?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-12 text-center">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>


</form>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>