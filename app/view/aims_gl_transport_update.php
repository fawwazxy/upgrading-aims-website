<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$data = getTransportById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_transport_update_exec.php" enctype="multipart/form-data">
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label for="company_vehicle">COMPANY VEHICLE <span style="color: red">*</span></label>
        <input class="form-control" name="company_vehicle" id="company_vehicle" required onkeyup="convertToUppercase(this)" value="<? echo $data['company_vehicle']; ?>">
    </div>

    <div class="form-group">
        <label for="date_use">DATE</label>
        <input class="form-control" id="date_use" name="date_use" type="date" value="<? echo $data['date_use']; ?>"/>
    </div>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="mileagein">MILEAGE IN <span style="color: red">*</span></label>
            <input class="form-control" name="mileage_in" id="mileagein" type="number" step="0.01" min="0" value="<? echo $data['mileage_in']; ?>" required onkeyup="subtract()">
        </div>

        <div class="col-xs-4">
            <label for="mileageout">MILEAGE OUT <span style="color: red">*</span></label>
            <input class="form-control" name="mileage_out" id="mileageout" type="number" step="0.01" min="0" value="<? echo $data['mileage_out']; ?>" required onkeyup="subtract()">
        </div>

        <div class="col-xs-4">
            <label for="totalmileage">TOTAL MILEAGE <span style="color: red">*</span></label>
            <input class="form-control" name="total_mileage" id="totalmileage" type="number" step="0.01" min="0" value="<? echo $data['total_mileage'];?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="totalpetrol">TOTAL PETROL</label>
        <input class="form-control" id="totalpetrol" name="total" type="number" step="0.01" min="0" value="<? echo $data['total']; ?>">
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>

    </div>
</form>

<script type="text/javascript">
    function subtract(){
        var mileage_in = document.getElementById('mileagein').value;
        var mileage_out = document.getElementById('mileageout').value;

        var t = (mileage_out - mileage_in);
        var totall = (t * 0.9);
        var totals = t;
        var total_mileage = document.getElementById('totalmileage');
        total_mileage.value = totals;
        var total = document.getElementById('totalpetrol');
        total.value = totall.toFixed(2);
    }
</script>