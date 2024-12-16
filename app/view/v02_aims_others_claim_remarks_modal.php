<?php
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id'];
?>

<div>
    <form name="" method="post" action="../controller/v02_aims_others_claim_hr_remarks.php" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="addRemarks" id="addRemarks" class="form-control" rows="5" cols=""></textarea>
                    <input type="hidden" required="" id="id" name="id" value="<? echo $id; ?>" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div align="right">
                <button type="submit" class="btn btn-primary" id="btnAdd">Add Remarks</button>
            </div>
        </div>
    </form>
</div>
