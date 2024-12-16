<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$data = getUtilityById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_utility_update_exec.php" enctype="multipart/form-data">
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>"/>

    <div class="form-group">
        <label for="utility_desc_id">UTILITY TYPE <span style="color: red">*</span></label>
        <select  required class="form-control" name="utility_desc_id" id="utility_desc_id" value="<? echo $data['utility_desc_id']; ?>">
            <option value="">-- Choose UTILITY --</option>
            <? echo getDropDownUtility($data['utility_desc_id']); ?>
        </select>
    </div>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="num_20">NO 20 <span style="color: red">*</span></label>
            <input class="form-control auto-number" id="num_20" name="no_20" type="number" step="0.01" min="0" required  value="<? echo $data['no_20']; ?>" onkeyup="multi()" >
        </div>

        <div class="col-xs-4">
            <label for="num_21">NO 21 <span style="color: red">*</span></label>
            <input class="form-control auto-number" id="num_21" name="no_21" type="number" step="0.01" min="0" required value="<? echo $data['no_21']; ?>" onkeyup="multi()">
        </div>

        <div class="col-xs-4">
            <label for="update_total">TOTAL <span style="color: red">*</span></label>
            <input class="form-control auto-number" id="update_total" name="total" type="number" step="0.01" min="0" required value="<? echo $data['total']; ?>"  >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="month">MONTH <span style="color: red">*</span></label>
            <select required class="form-control" name="month" id="month">
                <option><? echo $data['month']; ?></option>
                <option value="JANUARY">JANUARY</option>
                <option value="FEBRUARY">FEBRUARY</option>
                <option value="MARCH">MARCH</option>
                <option value="APRIL">APRIL</option>
                <option value="MAY">MAY</option>
                <option value="JUNE">JUNE</option>
                <option value="JULY">JULY</option>
                <option value="AUGUST">AUGUST</option>
                <option value="SEPTEMBER">SEPTEMBER</option>
                <option value="OCTOBER">OCTOBER</option>
                <option value="NOVEMBER">NOVEMBER</option>
                <option value="DECEMBER">DECEMBER</option>
            </select>
        </div>
        <div class="col-xs-6">
            <label for="year">YEAR <span style="color: red">*</span></label>
            <input class="form-control" name="year" id="year" required value="<? echo $data['year']; ?>" >
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

<script type="text/javascript">
    function multi(){
        var no_20 = document.getElementById("num_20").value;
        var no_21 = document.getElementById("num_21").value;

        var totals = ((+no_20) + (+no_21));
        var total = document.getElementById('update_total');
        total.value = totals.toFixed(2);
    }
</script>
