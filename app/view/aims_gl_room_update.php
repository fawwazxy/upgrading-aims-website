<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getRoomById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_room_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label for="room_no">Room No <span style="color: red">*</span></label>
        <input class="form-control" name="room_no" id="room_no" value="<? echo $data['room_no']; ?>" >
    </div>

    <div class="form-group">
        <label for="capacity">CAPACITY <span style="color: red">*</span></label>
        <input class="form-control" name="capacity" id="capacity" value="<? echo $data['capacity']; ?>" >
    </div>

    <div class="form-group">
        <label for="bed_type">BED TYPE <span style="color: red">*</span></label>
        <input class="form-control" name="bed_type" id="bed_type" value="<? echo $data['bed_type']; ?>" >
    </div>

    <div class="form-group">
        <label for="status">Status: </label></br>
        <input type="radio" id="status" name="status" <?php if($data['status']=="1") {echo "checked";}?> value="1"> Available
        <input type="radio" id="status" name="status" <?php if($data['status']=="0") {echo "checked";}?> value="0"> Not Available
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
                      