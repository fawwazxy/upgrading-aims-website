<?
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id'];
$cc = v02getCostCentreById($id)->fetch_assoc();
?>
<form method="post" action="../controller/v02_aims_others_cost_centre_update_exec.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_centre">Cost Centre:</label>
                        <input class="form-control" type="text" name="cost_centre" id="cost_centre" value="<? echo $cc['cost_centre']?>" required>
                        <input class="form-control" type="hidden" name="id" id="id" value="<? echo $cc['id']?>">
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company:</label><br>
                        <select class="form-control" id="company_name" name="company_name" required>
                            <option>-- Select Company --</option>
                            <? echo getCompanyDropdown($cc['company_id']); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_claim">Type Claim:</label>
                        <input class="form-control" type="text" name="type_claim" id="type_claim" value="<? echo $cc['description']?>" required>

                    </div>
                    <div class="form-group">
                        <label for="description">Description: <small class="text-muted">(optional)</small></label>
                        <input class="form-control" type="text" name="description" id="description" maxlength="50" value="<? echo $cc['remarks']?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="submit" class="btn btn-primary" id="btnSubmit" onclick="return confirm('Confirm update cost centre?')">Save Changes</button>
            </div>
        </div>
    </div>
</form>
