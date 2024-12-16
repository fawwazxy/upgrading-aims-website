<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getBedById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_bed_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>"/>

    <div class="form-group">
        <label for="room_id">ROOM NO <span style="color: red">*</span></label>
        <select  required class="form-control" name="room_id" id="room_id">
            <option value="">-- Choose Room --</option>
            <? echo getDropDownRoom($data['room_no']); ?>
        </select>
    </div>

    <div class="form-group">
        <label for="bed_no">BED NO <span style="color: red">*</span></label>
        <input class="form-control" name="bed_no" id="bed_no" value="<? echo $data['bed_no']; ?>" >
    </div>

    <div class="form-group">
        <label for="status">Status: </label></br>
        <input type="radio" id="status" name="status" <?php if($data['status']=="1") {echo "checked";}?> value="1"> Active
        <input type="radio" id="status" name="status" <?php if($data['status']=="0") {echo "checked";}?> value="0"> Inactive
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>

    </div>
</form>
                      