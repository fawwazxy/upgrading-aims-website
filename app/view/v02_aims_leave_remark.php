<?php
require "../model/v02_aims_leave_function.php";
$id = $_POST['id'];
$leave_remark = getLeaveById($id)->fetch_object()->remark;
?>
<input name="leave_id" type="hidden" class="input-short" value="<? echo $id;?>" />

<div class="form-group row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="control-label" for="remark">Remarks: </label>
            <textarea class="form-control" name="remark" id="remark" rows="4"><? echo $leave_remark ?></textarea>
        </div>
    </div>
</div>