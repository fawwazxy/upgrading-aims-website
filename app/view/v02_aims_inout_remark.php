<?php
require "../model/v02_aims_inout_function.php";
$id = $_POST['id'];
$inout_remark = getInOutById($id)->fetch_object()->remark;
?>
<input name="inout_id" type="hidden" class="input-short" value="<? echo $id;?>" />
<div class="form-group row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="control-label" for="remark">Remark: </label>
            <textarea class="form-control" name="remark" id="remark" rows="4"><? echo $inout_remark ?></textarea>
        </div>
    </div>
</div>