<?php
require "../model/v02_aims_others_claim_function.php";
$claim_id = $_POST['id'];
?>
<div class="table-responsive">
    <form action="../controller/v02_aims_others_claim_finance_return_remarks_exec.php" enctype="multipart/form-data"
          method="post">
        <input type="hidden" name="id" value="<? echo $claim_id; ?>">
        <label for="remarks">Remarks <span class="required-span">*</span></label>
        <textarea class="form-control" id="remarks" name="remarks" required rows="5"></textarea>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" style="float: right" value="Return Claim">
        </div>
    </form>
</div>