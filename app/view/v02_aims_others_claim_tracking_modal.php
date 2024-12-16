<?php
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id'];
$res = v02OthersClaimById($id)->fetch_assoc();
$tracking = v02TrackingNoByClaimId($id);
?>
<form action="../controller/v02_aims_others_claim_finance_close_payment_exec.php" enctype="multipart/form-data" method="post">
    <input type="hidden" name="claim_id" value="<? echo $id?>">
    <div class="modal-body">
        <div class="form-group">
            <label>Total Claim : <b><? echo 'RM '.number_format($res['total_claim'],2)?></b></label>
        </div>
        <div class="form-group">
            <label for="tracking_no">Tracking Number<span style="color: red;"> *</span></label>
            <input class="form-control" id="tracking_no" name="tracking_no" required type="text" value="<? echo $tracking; ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <input class="btn btn-success" type="submit" value="Submit">
    </div>
</form>
