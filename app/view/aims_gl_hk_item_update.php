<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getItemHkById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_hk_item_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label class="item">Item Name <span style="color: red">*</span></label>
        <input class="form-control" id="item" name="item" onkeyup="convertToUppercase(this)" value="<? echo $data['item']; ?>">
    </div>

    <div class="form-group">
        <label for="code">Item Code <span style="color: red">*</span></label>
        <input class="form-control" id="code" name="code" onkeyup="convertToUppercase(this)" value="<? echo $data['code']; ?>">
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>