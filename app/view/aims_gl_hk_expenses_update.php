<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$data = getHkExpensesById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_hk_expenses_update_exec.php" enctype="multipart/form-data">
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label for="location">LOCATION <span style="color: red">*</span></label>
        <input class="form-control" name="location" id="location" required onkeyup="convertToUppercase(this)" value="<? echo $data['location']; ?>">
    </div>

    <div class="form-group">
        <label for="date_purchase">DATE <span style="color: red">*</span></label>
        <input class="form-control" id="date_purchase" name="date_purchase" required type="date" value="<? echo $data['date_purchase']; ?>"/>
    </div>


    <div class="form-group">
        <label for="item">ITEM <span style="color: red">*</span></label>
        <input class="form-control" onkeyup="convertToUppercase(this)"  name="item" id="item" value="<? echo $data['item']; ?>">
    </div>

    <div class="form-group row">
        <div class="col-xs-4">
            <label for="unitupdate">UNIT <span style="color: red">*</span></label>
            <input class="form-control auto-number" name="unit" id="unitupdate" value="<? echo $data['unit']; ?>" required onkeyup="multi()">
        </div>

        <div class="col-xs-4">
            <label for="priceupdate">PRICE <span style="color: red">*</span></label>
            <input class="form-control auto-number" placeholder=" " name="price" id="priceupdate" value="<? echo $data['price']; ?>" required onkeyup="multi()">
        </div>


        <div class="col-xs-4">
            <label for="totalupdate">TOTAL <span style="color: red">*</span></label>
            <input class="form-control" id="totalupdate" name="total" value="<? echo $data['total'];?>">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script type="text/javascript">
    function multi(){
        var unit = document.getElementById('unitupdate').value;
        var price = document.getElementById('priceupdate').value;

        var totals = (unit * price);
        var total = document.getElementById('totalupdate');
        total.value = totals.toFixed(2);
    }
</script>