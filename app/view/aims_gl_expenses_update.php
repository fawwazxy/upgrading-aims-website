<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$data = getExpensesById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_expenses_update_exec.php" enctype="multipart/form-data">
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">
    <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME']; ?>">

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="ref_no">RR NUMBER <span style="color: red">*</span></label>
            <input class="form-control" name="ref_no" id="ref_no" readonly value="<? echo $data['ref_no']; ?>">
        </div>

        <div class="col-xs-6">
            <label for="arrival_date">CHECK IN DATE <span style="color: red">*</span></label>
            <input class="form-control" id="arrival_date" name="arrival_date" required readonly type="date" value="<? echo $data['arrival_date']; ?>"/>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-3">
            <label for="room_id">ROOM NO <span style="color: red">*</span></label>
            <input class="form-control" onkeyup="convertToUppercase(this)"  name="room_id" id="room_id" readonly value="<? echo $data['room_id']; ?>">
        </div>
        <div class="col-xs-3">
            <label for="bed_id">BED NO <span style="color: red">*</span></label>
            <input class="form-control auto-number" name="bed_id" id="bed_id" value="<? echo $data['bed_id']; ?>" required readonly>
        </div>

        <div class="col-xs-3">
            <label for="hk_date">HOUSEKEEPING DATE <span style="color: red">*</span></label>
            <input class="form-control auto-number" type="date" name="hk_date" id="hk_date" value="<? echo $data['hk_date']; ?>" required>
        </div>

        <div class="col-xs-3">
            <label for="hk_status">STATUS HK <span style="color: red">*</span></label>
            <select class="form-control" name="hk_status" id="hk_status">
                <option><?php echo $data['hk_status']; ?></option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>

    <label>DOBBY______________________________________________________________________________________________________________________</label>
    <div class="form-group row">
        <div class="col-xs-4">
            <label for="dobby_bs">B-S <span style="color: red">*</span></label>
            <input class="form-control" name="dobby_bs" id="dobby_bs" value="<? echo $data['dobby_bs']; ?>">
        </div>
        <div class="col-xs-4">
            <label for="dobby_bl">BL <span style="color: red">*</span></label>
            <input class="form-control" name="dobby_bl" id="dobby_bl" value="<? echo $data['dobby_bl']; ?>" required>
        </div>

        <div class="col-xs-4">
            <label for="dobby_twl">TOWEL <span style="color: red">*</span></label>
            <input class="form-control" name="dobby_twl" id="dobby_twl" value="<? echo $data['dobby_twl']; ?>" required>
        </div>
    </div>

    <label>BEVERAGE___________________________________________________________________________________________________________________</label>
    <div class="form-group row">
        <div class="col-xs-4">
            <label for="tea">TEA (QTYx1) <span style="color: red">*</span></label>
            <input class="form-control" name="tea" id="tea" value="<? echo $data['tea']; ?>">
        </div>
        <div class="col-xs-4">
            <label for="sugar">SUGAR (QTYx2) <span style="color: red">*</span></label>
            <input class="form-control" name="sugar" id="sugar" value="<? echo $data['sugar']; ?>" required>
        </div>

        <div class="col-xs-4">
            <label for="creamer">CREAMER (QTYx3) <span style="color: red">*</span></label>
            <input class="form-control" name="creamer" id="creamer" value="<? echo $data['creamer']; ?>" required>
        </div>
    </div>

    <label>TOILETRIES__________________________________________________________________________________________________________________</label>
    <div class="form-group row">
        <div class="col-xs-4">
            <label for="soap">BATCH SOAP <span style="color: red">*</span></label>
            <input class="form-control"  name="soap" id="soap" value="<? echo $data['soap']; ?>">
        </div>
        <div class="col-xs-4">
            <label for="shampoo">SHAMPOO <span style="color: red">*</span></label>
            <input class="form-control" name="shampoo" id="shampoo" value="<? echo $data['shampoo']; ?>" required>
        </div>

        <div class="col-xs-4">
            <label for="water">MINERAL WATER <span style="color: red">*</span></label>
            <input class="form-control" name="water" id="water" value="<? echo $data['water']; ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>