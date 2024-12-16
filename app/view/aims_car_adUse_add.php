<?php
require "../controller/auth.php";
require "../model/aims_carReserve_function.php";

$id = $_GET['id'];
$status = $_GET['status'];
$car_request = getcarRequestById1($id)->fetch_assoc();
?>
<form method="post" action="../controller/aims_caradmin_add_exec.php">
    <div class="form-group">
        <label style="color: red;">* Required</label>
        <input id="id" name="id" type="hidden" value="<?php echo $id?>"/>
        <input id="status" name="status" type="hidden" value="<?php echo $status?>"/>

        <div class="form-group row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="app_status">Status:</label><br>
                    <input type="radio" id="app_status" name="app_status" <?php if($car_request['app_status']=="PENDING") {echo "checked";}?> value="PENDING"> PENDING <br>
                    <input type="radio" id="app_status" name="app_status" <?php if($car_request['app_status']=="APPROVE") {echo "checked";}?> value="APPROVE"> APPROVE <br>
                    <input type="radio" id="app_status" name="app_status" <?php if($car_request['app_status']=="DISAPPROVE") {echo "checked";}?> value="DISAPPROVE"> REJECT
                </div>
            </div>

            <div class="col-md-10">
                <div class="form-group">
                    <label for="reason">Reason</label>
                    <textarea class="form-control" rows="3" name="reason" id="reason"><?php echo $car_request['reason'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name_admin">Name&nbsp;<span style="color: red; ">*</span></label>
                    <input class="form-control" placeholder="" name="name_admin" id="name_admin" value ="<?php echo $_SESSION['SESS_NAME'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="department">Department&nbsp;<span style="color: red; ">*</span></label>
                    <input class="form-control" placeholder="" name="department" id="department" value ="<?php echo $_SESSION['SESS_DEPARTMENT_SUB'] ?>" readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="description">Designation&nbsp;<span style="color: red; ">*</span></label>
                    <input required class="form-control" placeholder="EXECUTIVE" name="description" id="description" value="<?php echo $car_request['descrip'] ?>" style="text-transform:uppercase">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-block btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>