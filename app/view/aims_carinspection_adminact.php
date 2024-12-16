<?php
require "../model/aims_carReserve_function.php";

$id = $_GET['id'];
$month = $_GET['month'];
$raw_data1 = getCarInspectionById($id)->fetch_assoc();
?>
<form method="post" action="../controller/aims_carinspection_adminact_exec.php?" >
    <div class="form-group">
        <label style="color: red;"> * Required</label>
        <input id="id" name="id" type="hidden" value="<?php echo $id?>"/>
        <input id="month" name="month" type="hidden" value="<?php echo $month?>"/>
        <input id="admin_actby" name="admin_actby" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
    </div>

    <div class="form-group">
        <label for="admin_action">STATUS ACTION:</label><br>
        <input type="radio" name="admin_action" id="admin_action" <?php if($raw_data1['admin_action']=="PENDING") {echo "checked";}?> value="PENDING"> PENDING &nbsp;
        <input type="radio" name="admin_action" id="admin_action" <?php if($raw_data1['admin_action']=="CHECK") {echo "checked";}?> value="CHECK"> CHECK
    </div>

    <div class="form-group">
        <label for="costing">COSTING</label>
        <input class="form-control" type="number" step="0.01" name="costing" id="costing" value="<?php echo $raw_data1['costing'] ?>">
    </div>

    <div class="form-group">
        <label for="description">DESCRIPTION &nbsp;<span style="color: red; ">*</span></label>
        <input class="form-control" placeholder="" name="description" id="description" required
               value="<?php echo $raw_data1['description'] ?>" style="text-transform:uppercase"
               onkeyup="convertToUppercase(this)">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary">Save</button>
    </div>
</form>
<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>