<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getUtilityDescById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_utility_desc_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>"/>

    <div class="form-group">
        <label for="description">Description <span style="color: red">*</span></label>
        <input class="form-control" onkeyup="convertToUppercase(this)" name="description" id="description" value="<? echo $data['description']; ?>" >
    </div>

    <div class="form-group">
        <label for="code">Code <span style="color: red">*</span></label>
        <input class="form-control" onkeyup="convertToUppercase(this)" name="code" id="code" value="<? echo $data['code']; ?>" >
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
