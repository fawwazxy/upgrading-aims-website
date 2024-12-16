<?php
include "../controller/auth.php";
require "../model/lookup.php";
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$otp_id = v02getOtPermissionById($id)->fetch_object()->id;
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_permission_remark_exec.php"
          enctype="multipart/form-data">
        <input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $otp_id ?>"/>

        <div class="form-group">
            <label for="remark">Remark<span class="text-danger">**</span>&nbsp;</label><br>
            <textarea class="form-control" id="remark" name="remark" type="text" rows="3"
                      onkeyup="convertToUppercase(this)"> </textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-block btn-primary">Add</button>
        </div>

    </form>
</div>

<script>
    function convertToUppercase(el) {
        if (!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>