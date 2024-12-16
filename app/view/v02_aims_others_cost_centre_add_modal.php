<?php
require "../model/v02_aims_others_claim_function.php"; ?>
<form method="post" action="../controller/v02_aims_others_cost_centre_add_exec.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_centre">Cost Centre:</label>
                        <input class="form-control" type="text" name="cost_centre" id="cost_centre" required>
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company:</label><br>
                        <select class="form-control" id="company_name" name="company_name" required>
                            <option>-- Select Company --</option>
                            <? echo getAllCompanyList(''); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_claim">Type Claim:</label>
                        <input class="form-control" type="text" name="type_claim" id="type_claim" required>

                    </div>
                    <div class="form-group">
                        <label for="description">Description: </label>
                        <input class="form-control" type="text" name="description" id="description" maxlength="50">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="submit" class="btn btn-primary" id="btnSubmit" onclick="return confirm('Confirm create cost centre?')">Submit</button>
            </div>
        </div>
    </div>
</form>
